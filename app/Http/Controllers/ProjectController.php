<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['tasks', 'employees'])->get();

        foreach ($projects as $project) {
            // Count total tasks and completed tasks
            $totalTasks = $project->tasks->count();
            $completedTasks = $project->tasks->where('status', 'Done')->count();

            // Assign calculated values to the project
            $project->tasks_count = $totalTasks;
            $project->completed_tasks = $completedTasks;
            $project->progress = ($totalTasks > 0) ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

            // Format project employees' names with initials
            $project->ownerNames = $project->employees->map(function ($employee) {
                $nameParts = explode(' ', $employee->name);
                $initials = strtoupper(substr($nameParts[0], 0, 1));
                if (isset($nameParts[1])) {
                    $initials .= strtoupper(substr($nameParts[1], 0, 1));
                }
                return "{$employee->name} - {$initials}";
            })->implode(', ');
        }
        
        return view('Projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|string|in:New,In Progress,Completed',
            'priority' => 'required|string|in:Low,Medium,High',
        ]);

        Project::create($validated);

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
        return view('Projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|string|in:New,In Progress,Completed',
            'priority' => 'required|string|in:Low,Medium,High',
        ]);

        $project->update($validated);

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
