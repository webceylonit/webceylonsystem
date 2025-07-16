<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectDocs;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class ProjectDocsController extends Controller
{
    public function index()
    {
        if (!PermissionService::has('View Documents')) {
            return redirect()->route('unauthorized');
        }
        $projectDocs = ProjectDocs::latest()->get();
        return view('ProjectDoc.index', compact('projectDocs'));
    }
    public function create(Request $request)
    {
        if (!PermissionService::has('Create Documents')) {
            return redirect()->route('unauthorized');
        }
        $project_id = $request->query('project_id');
        $project = Project::findOrFail($project_id);
        return view('ProjectDoc.create', compact('project'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'document_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $doc = ProjectDocs::create([
            'project_id'     => $request->project_id,
            'document_name'  => $request->document_name,
            'description'    => $request->description,
            'added_by'       => auth()->id(),
        ]);

        return redirect()
            ->route('projectDocs.index')
            ->with('success', 'Document added successfully.')
            ->with('new_doc_id', $doc->id)
            ->with('new_doc_name', $doc->document_name);
    }

    public function edit($id)
    {
        if (!PermissionService::has('Edit Documents')) {
            return redirect()->route('unauthorized');
        }
        $projectDoc = ProjectDocs::with('project')->findOrFail($id);

        return view('ProjectDoc.edit', compact('projectDoc'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'document_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $projectDoc = ProjectDocs::findOrFail($id);

        $projectDoc->update([
            'document_name' => $request->document_name,
            'description' => $request->description,
        ]);

        return redirect()->route('projectDocs.index')->with('success', 'Document updated successfully.');
    }

    public function destroy($id)
    {
        if (!PermissionService::has('Delete Documents')) {
            return redirect()->route('unauthorized');
        }
        $projectDoc = ProjectDocs::findOrFail($id);
        $projectDoc->delete();

        return redirect()->back()->with('success', 'Document deleted successfully.');
    }

    public function print($id)
    {
        $doc = ProjectDocs::with(['project.client'])->findOrFail($id);

        return view('Documents.project_doc', compact('doc'));
    }
}
