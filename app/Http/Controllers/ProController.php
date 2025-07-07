<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the authenticated employee
        $employee = Auth::user();

        // If Admin, show all projects; otherwise, show only assigned projects
        $projects = ($employee->role->name === 'Admin')
            ? Project::with(['tasks', 'employees'])->get()
            : $employee->projects()->with(['tasks', 'employees'])->get();

        foreach ($projects as $project) {
            // Count total tasks and completed tasks
            $totalTasks = $project->tasks->count();
            $completedTasks = $project->tasks->where('status', 'Done')->count();

            // Assign calculated values to the project
            $project->tasks_count = $totalTasks;
            $project->completed_tasks = $completedTasks;
            $project->progress = ($totalTasks > 0) ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

            // Generate employee initials dynamically
            $project->ownerNames = $project->employees->map(function ($employee) {
                $nameParts = explode(' ', trim($employee->name));
                $initials = implode('', array_map(fn($part) => strtoupper(substr($part, 0, 1)), $nameParts));
                return $initials; // Return only initials (e.g., "NS" for "Noah Smith")
            })->implode(', ');
        }

        return view('Projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'start_date' => 'nullable|date', // Allowing nullable start_date
            'deadline' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:New,In Progress,Completed',
            'priority' => 'required|in:Low,Medium,High',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048' // File validation
        ]);

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public'); // Store in storage/app/public/attachments
        }

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'status' => $request->status,
            'priority' => $request->priority,
            'attachment' => $attachmentPath,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('Projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $employees = Employee::all(); // Get all employees
        $assignedEmployees = $project->employees->pluck('id')->toArray(); // Get assigned employees

        return view('Projects.edit', compact('project', 'employees', 'assignedEmployees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //dd($request);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'start_date' => 'nullable|date',
            'deadline' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:New,In Progress,Completed',
            'priority' => 'required|in:Low,Medium,High',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'employees' => 'nullable|array', // Allow multiple employee IDs
            'employees.*' => 'exists:employees,id', // Ensure IDs exist
        ]);

        //dd($request);
        

        // Handle file update
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            $project->attachment = $attachmentPath; // Update attachment path
        }

        // Update project details
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'status' => $request->status,
            'priority' => $request->priority,
            'attachment' => $project->attachment, // Keep existing or update
        ]);

        // Sync assigned employees (many-to-many)
        $project->employees()->sync($request->employees ?? []);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
