<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDocs;
use Illuminate\Http\Request;

class ClientDocsController extends Controller
{

    public function index()
    {
        $clientDocs = ClientDocs::all();
        return view('ClientDoc.index', compact('clientDocs'));
    }
    public function create()
    {
        $clients = Client::all();
        return view('ClientDoc.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_name' => 'nullable|string|max:255',
            'document_name' => 'required|string|max:255',
            'description_1' => 'nullable|string',
            'description_2' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $document = ClientDocs::create($request->all());

        return redirect()->route('ClientDoc.index', $document->id)->with('success', 'Document saved successfully!');
    }

    public function show($id)
    {
        $document = ClientDocs::with('client')->findOrFail($id);
        return view('ClientDoc.show', compact('document'));
    }
}
