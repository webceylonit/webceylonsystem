<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sprint;
use App\Models\Project;

class SprintController extends Controller
{
    /**
     * Display a listing of the sprints.
     */
    public function index(Request $request)
    {
        $projectId = $request->query('project_id'); // Get project ID from URL
        $sprints = Sprint::where('project_id', $projectId)->get();
        return view('sprints.index', compact('sprints', 'projectId'));
    }

    /**
     * Show the form for creating a new sprint.
     */
    public function create()
    {
        $projects = Project::all(); // Get all projects to assign a sprint
        return view('sprints.create', compact('projects'));
    }

    /**
     * Store a newly created sprint in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Not Started,In Progress,Completed',
        ]);

        Sprint::create($request->all());

        return back()->with('success', 'Sprint created successfully.');
    }

    /**
     * Show the form for editing a sprint.
     */
    public function edit(Sprint $sprint)
    {
        $projects = Project::all();
        return view('sprints.edit', compact('sprint', 'projects'));
    }

    /**
     * Update the specified sprint in storage.
     */
    public function update(Request $request, Sprint $sprint)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Not Started,In Progress,Completed',
        ]);

        $sprint->update($request->all());

        return back()->with('success', 'Sprint Updated successfully.');
    }

    /**
     * Remove the specified sprint from storage.
     */
    public function destroy(Sprint $sprint)
    {
        $sprint->delete();

        return back()->with('success', 'Sprint deleted successfully.');
    }
}
