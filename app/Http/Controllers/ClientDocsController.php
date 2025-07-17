<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDocs;
use App\Models\Project;
use App\Models\ProjectDocs;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class ClientDocsController extends Controller
{
    public function index()
    {
        if (!PermissionService::has('View Documents')) {
            return redirect()->route('unauthorized');
        }
        $clientDocs = ClientDocs::latest()->get();
        return view('ClientDoc.index', compact('clientDocs'));
    }
    public function create(Request $request)
    {
        if (!PermissionService::has('Create Documents')) {
            return redirect()->route('unauthorized');
        }
        $client_id = $request->query('client_id');
        $client = Client::findOrFail($client_id);
        return view('ClientDoc.create', compact('client'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_name' => 'nullable|string|max:255',
            'document_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $doc = ClientDocs::create([
            'client_id'      => $request->client_id,
            'project_name'   => $request->project_name,
            'document_name'  => $request->document_name,
            'description'    => $request->description,
            'added_by'       => auth()->id(),
        ]);

        return redirect()
            ->route('clientDocs.index')
            ->with('success', 'Document added successfully.')
            ->with('new_doc_id', $doc->id)
            ->with('new_doc_name', $doc->document_name);
    }

    public function edit($id)
    {
        if (!PermissionService::has('Edit Documents')) {
            return redirect()->route('unauthorized');
        }
        $clientDoc = ClientDocs::with('client')->findOrFail($id);

        return view('ClientDoc.edit', compact('clientDoc'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'project_name' => 'nullable|string|max:255',
            'document_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $clientDoc = ClientDocs::findOrFail($id);

        $clientDoc->update([
            'project_name' => $request->project_name,
            'document_name' => $request->document_name,
            'description' => $request->description,
        ]);

        return redirect()->route('clientDocs.index')->with('success', 'Document updated successfully.');
    }

    public function destroy($id)
    {
        if (!PermissionService::has('Delete Documents')) {
            return redirect()->route('unauthorized');
        }
        $clientDoc = ClientDocs::findOrFail($id);
        $clientDoc->delete();

        return redirect()->back()->with('success', 'Document deleted successfully.');
    }

    public function print($id)
    {
        $doc = ClientDocs::with(['client'])->findOrFail($id);

        return view('Documents.client_doc', compact('doc'));
    }
}
