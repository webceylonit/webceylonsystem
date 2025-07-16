<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Project;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        if (!PermissionService::has('View invoices')) {
            return redirect()->route('unauthorized');
        }
        $invoices = Invoice::latest()->get();
        return view('Invoices.index', compact('invoices'));
    }
    public function create(Request $request)
    {
        if (!PermissionService::has('Create Invoices')) {
            return redirect()->route('unauthorized');
        }
        $project_id = $request->query('project_id');
        $project = Project::findOrFail($project_id);
        return view('Invoices.create', compact('project'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'     => 'required|exists:projects,id',
            'items'          => 'required|array|min:1',
            'items.*.item'   => 'required|string|max:255',
            'items.*.amount' => 'required|numeric|min:0',
            'sub_total'      => 'required|numeric|min:0',
            'sscl'           => 'required|numeric|min:0',
            'vat'            => 'required|numeric|min:0',
            'total_amount'   => 'required|numeric|min:0',
        ]);

        // Generate unique invoice number (e.g., INV-00001)
        $lastInvoice = Invoice::latest('id')->first();
        $nextNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $invoiceNumber = 'INV-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // Create the invoice
        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'project_id'     => $request->project_id,
            'sub_total'      => $request->sub_total,
            'sscl'           => $request->sscl,
            'vat'            => $request->vat,
            'total_amount'   => $request->total_amount,
            'added_by'       => auth()->id(),
        ]);

        // Create invoice items
        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item'       => $item['item'],
                'amount'     => $item['amount'],
            ]);
        }

        return redirect()
    ->route('invoices.index', $request->project_id)
    ->with('success', 'Invoice created successfully.')
    ->with('new_invoice_id', $invoice->id)
    ->with('new_invoice_number', $invoice->invoice_number);
    }

    // public function edit($id)
    // {
    //     if (!PermissionService::has('Edit Invoices')) {
    //         return redirect()->route('unauthorized');
    //     }
    //     $invoice = Invoice::with('project')->findOrFail($id);

    //     return view('Invoices.edit', compact('invoice'));
    // }

    // public function update(Request $request, $id) {}

    public function destroy($id) {
        
    }

    public function print($id)
    {
        $doc = Invoice::with(['project.client'])->findOrFail($id);

        return view('Documents.invoice', compact('doc'));
    }
}
