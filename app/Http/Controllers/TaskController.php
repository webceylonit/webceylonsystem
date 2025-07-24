<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Sprint;
use App\Models\Employee;
use App\Models\TaskUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TaskController extends Controller
{
    // 🔹 Show Tasks for a Specific Sprint
    public function index(Sprint $sprint)
    {
        $employees = Employee::all();
        $tasks = $sprint->tasks()->with(['assignedTo', 'updates'])->get();

        return view('tasks.index', compact('tasks', 'sprint', 'employees'));
    }

    // 🔹 Create Task Form
    public function create(Sprint $sprint)
    {
        $employees = Employee::all();
        return view('tasks.create', compact('sprint', 'employees'));
    }

    // 🔹 Store a New Task
    public function store(Request $request)
    {
        $request->validate([
            'sprint_id' => 'required|exists:sprints,id',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:employees,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,In Progress,Done',
            'priority' => 'required|in:Low,Medium,High',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $task = Task::create($request->all());

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
        $request->validate([
            'assigned_to' => 'required|exists:employees,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,In Progress,Done,Approval',
            'priority' => 'required|in:Low,Medium,High',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $task->update($request->all());

        return back()->with('success', 'Task updated successfully.');
    }

    // 🔹 Delete Task (Check for Dependencies)
    public function destroy(Task $task)
    {
        // Check if the task has dependencies before deleting
        if (Task::where('dependent_task_id', $task->id)->exists()) {
            return back()->with('error', 'Task cannot be deleted because it has dependent tasks.');
        }

        $task->delete();
        return back()->with('success', 'Task deleted successfully.');
    }

    // 🔹 Show Single Task with Updates
    public function show(Task $task)
    {
        $task->load(['updates.employee']); // Load task updates with employee names
        return view('tasks.show', compact('task'));
    }

    // 🔹 Add an Update (Issue, Requirement, Progress)
    public function addUpdate(Request $request, Task $task)
    {
        $request->validate([
            'update_text' => 'required|string',
            'type' => 'required|in:problem,requirement,progress',
        ]);

        TaskUpdate::create([
            'task_id' => $task->id,
            'employee_id' => Auth::id(),
            'update_text' => $request->update_text,
            'type' => $request->type,
        ]);

        return back()->with('success', 'Task update added successfully.');
    }

    // 🔹 Get Overdue Tasks (With Delay Reasons)
    public function getOverdueTasks()
    {
        $overdueTasks = Task::where('status', '!=', 'Done')
            ->whereDate('due_date', '<', Carbon::today())
            ->with('updates') // Load updates (to check issues)
            ->get();

        return view('tasks.overdue', compact('overdueTasks'));
    }

    public function solveUpdate(TaskUpdate $taskUpdate)
    {
        if (Auth::user()->role->name !== 'Admin' && Auth::user()->role->name !== 'Manager') {
            return back()->with('error', 'You are not authorized to mark this as solved.');
        }

        $taskUpdate->markAsSolved();
        return back()->with('success', 'Issue marked as solved.');
    }

}
