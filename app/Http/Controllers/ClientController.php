<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->get();
        return view('Clients.index', compact('clients'));
    }

    public function create()
    {
        return view('Clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Client Details
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:100',
            'email' => 'required|email|unique:clients,email',
            'client_contact' => 'required|string|max:20',

            // Company Details
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'address' => 'nullable|string',

            // Other
            'notes' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $validated['added_by'] = Auth::id();

        $client = Client::create($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client created successfully!')
            ->with('new_client_id', $client->id)
            ->with('new_client_name', $client->name);
    }

    public function edit(Client $client)
    {
        return view('Clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'designation'     => 'required|string|max:100',
            'email'           => 'required|email|unique:clients,email,' . $client->id,
            'client_contact'  => 'required|string|max:20',

            'company'         => 'nullable|string|max:255',
            'phone'           => 'nullable|string|max:20',
            'company_email'   => 'nullable|email|max:255',
            'address'         => 'nullable|string',

            'notes'           => 'nullable|string',
            'status'          => 'required|in:Active,Inactive',
        ]);

        $client->update($request->all());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function show(Client $client)
    {
        return view('Clients.show', compact('client'));
    }


    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
