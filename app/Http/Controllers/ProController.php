<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Employee;
use App\Models\ProjectCategory;
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
        $projects = in_array($employee->role->name, ['Admin', 'Manager'])
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

    public function tableView()
    {
        $projects = Project::latest()->get();
        return view('Projects.tableview', compact('projects'));
    }

    public function create(Request $request)
    {
        $clients = Client::all();
        $categories = ProjectCategory::all();

        $selectedClientId = $request->query('client_id');

        return view('Projects.create', compact('clients', 'categories', 'selectedClientId'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'category_id' => 'required|exists:project_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:New,In Progress,Completed,On Hold,Cancelled',
            'priority' => 'required|string|in:Low,Medium,High',
            'estimate_budget' => 'nullable|numeric',
            'additional_note' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:20480',

            'authorized_persons' => 'required|array|min:1',
            'authorized_persons.*.name' => 'required|string|max:255',
            'authorized_persons.*.designation' => 'required|string|max:255',
            'authorized_persons.*.contact' => 'required|string|max:20',
            'authorized_persons.*.email' => 'required|email|max:255',
        ]);

        // Generate the auto-increment project code like WC00001
        $lastProject = Project::orderBy('id', 'desc')->first();
        $nextId = $lastProject ? $lastProject->id + 1 : 1;
        $projectCode = 'WC' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        // Handle file upload if present
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        // Create the project
        $project = Project::create([
            'project_code' => $projectCode,
            'client_id' => $request->client_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'status' => $request->status,
            'priority' => $request->priority,
            'estimate_budget' => $request->estimate_budget,
            'additional_note' => $request->additional_note,
            'attachment' => $attachmentPath,
            'added_by' => auth()->id(),
        ]);

        // Save authorized persons
        foreach ($request->authorized_persons as $person) {
            $project->authorizedPersons()->create([
                'name' => $person['name'],
                'designation' => $person['designation'],
                'contact' => $person['contact'],
                'email' => $person['email'],
            ]);
        }

        return redirect()->route('projects.tableView')->with('success', 'Project created successfully.');
    }


    public function show(Project $project)
    {
        return view('Projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $clients = Client::all();
        $categories = ProjectCategory::all();
        $employees = Employee::all();
        $assignedEmployees = $project->employees->pluck('id')->toArray();

        return view('Projects.edit', compact('project', 'clients', 'categories', 'employees', 'assignedEmployees'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'category_id' => 'required|exists:project_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'deadline' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:New,In Progress,Completed,On Hold,Cancelled',
            'priority' => 'required|in:Low,Medium,High',
            'estimate_budget' => 'nullable|numeric',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'additional_note' => 'nullable|string',
            'employees' => 'nullable|array',
            'employees.*' => 'exists:employees,id',
            'authorized_persons' => 'nullable|array',
            'authorized_persons.*.name' => 'required|string|max:255',
            'authorized_persons.*.designation' => 'required|string|max:255',
            'authorized_persons.*.contact' => 'required|string|max:20',
            'authorized_persons.*.email' => 'required|email|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            $project->attachment = $attachmentPath;
        }

        // Update project
        $project->update([
            'client_id' => $request->client_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'status' => $request->status,
            'priority' => $request->priority,
            'estimate_budget' => $request->estimate_budget,
            'attachment' => $project->attachment,
            'additional_note' => $request->additional_note,
        ]);

        // Sync employees
        $project->employees()->sync($request->employees ?? []);

        // Update authorized persons
        $project->authorizedPersons()->delete(); // Clear existing
        if ($request->has('authorized_persons')) {
            foreach ($request->authorized_persons as $person) {
                $project->authorizedPersons()->create([
                    'name' => $person['name'],
                    'designation' => $person['designation'],
                    'contact' => $person['contact'],
                    'email' => $person['email'],
                ]);
            }
        }

        return redirect()->route('projects.tableView')->with('success', 'Project updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.tableView')->with('success', 'Project deleted successfully.');
    }
}
