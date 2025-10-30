<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Sprint;
use App\Models\Employee;
use App\Models\TaskUpdate;
use App\Models\SprintNote; // NEW
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Show mixed board (tasks + notes) for a sprint, preserving order.
     * View should iterate $board (each item: ['type' => 'task'|'note', 'model' => Model])
     */
    public function index(Sprint $sprint)
    {
        $employees = Employee::all();

        // Preload data
        $tasks = $sprint->tasks()
            ->with(['assignedTo', 'updates.employee'])
            ->get()
            ->keyBy('id');

        $notes = $sprint->notes()->get()->keyBy('id');

        $board = [];

        if (!empty($sprint->board_order)) {
            // Use mixed order tokens like ["t:12","n:3",...]
            foreach ($sprint->board_order as $token) {
                if (str_starts_with($token, 't:')) {
                    $id = (int) substr($token, 2);
                    if ($tasks->has($id)) $board[] = ['type' => 'task', 'model' => $tasks[$id]];
                } elseif (str_starts_with($token, 'n:')) {
                    $id = (int) substr($token, 2);
                    if ($notes->has($id)) $board[] = ['type' => 'note', 'model' => $notes[$id]];
                }
            }
            // Append any new tasks/notes not yet in board_order
            $knownTaskIds = collect($sprint->board_order)->filter(fn($t)=>str_starts_with($t,'t:'))->map(fn($t)=>(int)substr($t,2))->all();
            $knownNoteIds = collect($sprint->board_order)->filter(fn($t)=>str_starts_with($t,'n:'))->map(fn($t)=>(int)substr($t,2))->all();

            foreach ($tasks->except($knownTaskIds) as $t) $board[] = ['type'=>'task','model'=>$t];
            foreach ($notes->except($knownNoteIds) as $n) $board[] = ['type'=>'note','model'=>$n];
        } else {
            // Legacy fallback to task_order (then notes)
            $orderedIds = $sprint->task_order ?? [];
            $orderedTasks   = collect($orderedIds)->map(fn($id)=>$tasks->get($id))->filter()->values();
            $remainingTasks = $tasks->except($orderedIds)->values();

            foreach ($orderedTasks as $t)  $board[] = ['type'=>'task','model'=>$t];
            foreach ($remainingTasks as $t) $board[] = ['type'=>'task','model'=>$t];
            foreach ($notes as $n)         $board[] = ['type'=>'note','model'=>$n];
        }

        return view('tasks.index', compact('sprint', 'employees', 'board'));
    }

    /**
     * Persist drag & drop order of mixed items (tasks + notes).
     * Expects payload: { sprint_id, order: ["t:12","n:3","t:5", ...] }
     */
    public function reorder(Request $request)
    {
        $data = $request->validate([
            'sprint_id' => ['required','exists:sprints,id'],
            'order'     => ['required','array'],
            'order.*'   => ['string','regex:/^(t|n):\d+$/'],
        ]);

        $sprint = Sprint::findOrFail($data['sprint_id']);

        // Validate against current sprint membership
        $taskIds = Task::where('sprint_id', $sprint->id)->pluck('id')->map(fn($i)=>(int)$i)->all();
        $noteIds = SprintNote::where('sprint_id', $sprint->id)->pluck('id')->map(fn($i)=>(int)$i)->all();

        $filtered = [];
        foreach ($data['order'] as $token) {
            [$kind, $idStr] = explode(':', $token);
            $id = (int) $idStr;
            if ($kind === 't' && in_array($id, $taskIds, true)) $filtered[] = "t:$id";
            if ($kind === 'n' && in_array($id, $noteIds, true)) $filtered[] = "n:$id";
        }

        $sprint->board_order = array_values($filtered);
        $sprint->save();

        return response()->json(['ok' => true, 'board_order' => $sprint->board_order]);
    }

    // 🔹 Create Task Form
    public function create(Sprint $sprint)
    {
        $employees = Employee::all();
        return view('tasks.create', compact('sprint', 'employees'));
    }

    // 🔹 Store a New Task (append to board end)
    public function store(Request $request)
    {
        $data = $request->validate([
            'sprint_id'   => 'required|exists:sprints,id',
            'project_id'  => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:employees,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Pending,In Progress,Done,Approval',
            'priority'    => 'required|in:Low,Medium,High',
            'start_date'  => 'nullable|date',
            'due_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        $task = Task::create($data);

        // Append to mixed board order
        $sprint = Sprint::find($data['sprint_id']);
        $order = $sprint->board_order ?? [];
        $order[] = "t:{$task->id}";
        $sprint->board_order = $order;
        $sprint->save();

        return back()->with('success', 'Task created successfully.');
    }

    // 🔹 Edit Task
    public function edit(Task $task)
    {
        $employees = Employee::all();
        return view('tasks.edit', compact('task', 'employees'));
    }

    // 🔹 Update Task Details
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'assigned_to' => 'required|exists:employees,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Pending,In Progress,Done,Approval',
            'priority'    => 'required|in:Low,Medium,High',
            'start_date'  => 'nullable|date',
            'due_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        $task->update($data);

        return back()->with('success', 'Task updated successfully.');
    }

    // 🔹 Delete Task (remove from board order too)
    public function destroy(Task $task)
    {
        // Optional dependency guard (keep your logic)
        if (Task::where('dependent_task_id', $task->id)->exists()) {
            return back()->with('error', 'Task cannot be deleted because it has dependent tasks.');
        }

        $sprint = $task->sprint;
        $token = "t:{$task->id}";
        $task->delete();

        if ($sprint) {
            $order = collect($sprint->board_order ?? [])->reject(fn($t) => $t === $token)->values()->all();
            $sprint->board_order = $order;
            $sprint->save();
        }

        return back()->with('success', 'Task deleted successfully.');
    }

    // 🔹 Show Single Task with Updates
    public function show(Task $task)
    {
        $task->load(['updates.employee']);
        return view('tasks.show', compact('task'));
    }

    // 🔹 Add an Update (Issue, Requirement, Progress)
    public function addUpdate(Request $request, Task $task)
    {
        $data = $request->validate([
            'update_text' => 'required|string',
            'type'        => 'required|in:problem,requirement,progress',
        ]);

        TaskUpdate::create([
            'task_id'     => $task->id,
            // If your app uses employees table, adjust this accordingly:
            'employee_id' => Auth::user()?->employee_id ?? Auth::id(),
            'update_text' => $data['update_text'],
            'type'        => $data['type'],
            'is_solved'   => false,
        ]);

        return back()->with('success', 'Task update added successfully.');
    }

    // 🔹 Get Overdue Tasks (With Delay Reasons)
    public function getOverdueTasks()
    {
        $overdueTasks = Task::where('status', '!=', 'Done')
            ->whereDate('due_date', '<', Carbon::today())
            ->with('updates')
            ->get();

        return view('tasks.overdue', compact('overdueTasks'));
    }

    public function solveUpdate(TaskUpdate $taskUpdate)
    {
        if (Auth::user()->role->name !== 'Admin' && Auth::user()->role->name !== 'Manager') {
            return back()->with('error', 'You are not authorized to mark this as solved.');
        }

        // Assuming TaskUpdate has a markAsSolved() helper; otherwise set flag directly
        if (method_exists($taskUpdate, 'markAsSolved')) {
            $taskUpdate->markAsSolved();
        } else {
            $taskUpdate->is_solved = true;
            $taskUpdate->save();
        }

        return back()->with('success', 'Issue marked as solved.');
    }
}
