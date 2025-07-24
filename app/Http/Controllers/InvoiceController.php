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

    public function createinvoices(Request $request)
    {
        $project = Project::findOrFail($request->project_id);

        if ($request->type === 'commercial') {
            return view('invoices.create_commercial', compact('project'));
        } elseif ($request->type === 'tax') {
            return view('invoices.create_tax', compact('project'));
        } else {
            // Fallback or show type selector again
            return view('invoices.create', compact('project'));
        }
    }


    public function store(Request $request)
    {
        // Validate common fields
        $rules = [
            'project_id'     => 'required|exists:projects,id',
            'items'          => 'required|array|min:1',
            'items.*.item'   => 'required|string|max:255',
            'items.*.amount' => 'required|numeric|min:0',
            'type'           => 'required|in:commercial,tax',
        ];

        // Conditional validations based on invoice type
        if ($request->type === 'tax') {
            $rules = array_merge($rules, [
                'client_vat_no'        => 'required|string|max:50',
                'discount_percentage'  => 'required|numeric|min:0|max:100',
                'discount_amount'      => 'required|numeric|min:0',
                'after_discount_total' => 'required|numeric|min:0',
                'sscl'                 => 'required|numeric|min:0',
                'after_sscl_total'     => 'required|numeric|min:0',
                'vat'                  => 'required|numeric|min:0',
                'final_total'          => 'required|numeric|min:0',
            ]);
        } else {
            // Commercial Invoice Validations
            $rules = array_merge($rules, [
                'sub_total'           => 'required|numeric|min:0',
                'discount_percentage' => 'nullable|numeric|min:0|max:100',
                'discount_amount'     => 'required|numeric|min:0',
                'final_total'         => 'required|numeric|min:0',
            ]);
        }

        $validated = $request->validate($rules);

        // Generate unique invoice number
        $lastInvoice = Invoice::latest('id')->first();
        $nextNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $invoiceNumber = 'INV-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // Common data for all invoices
        $data = [
            'invoice_number' => $invoiceNumber,
            'project_id'     => $request->project_id,
            'type'           => $request->type,
            'added_by'       => auth()->id(),
        ];

        // Specific data based on invoice type
        if ($request->type === 'tax') {
            $data = array_merge($data, [
                'client_vat_no'        => $request->client_vat_no,
                'discount_percentage'  => $request->discount_percentage,
                'discount_amount'      => $request->discount_amount,
                'after_discount_total' => $request->after_discount_total,
                'sscl'                 => $request->sscl,
                'after_sscl_total'     => $request->after_sscl_total,
                'vat'                  => $request->vat,
                'final_total'          => $request->final_total,
            ]);
        } else {
            $data = array_merge($data, [
                'sub_total'           => $request->sub_total,
                'discount_percentage' => $request->discount_percentage ?? 0,
                'discount_amount'     => $request->discount_amount,
                'final_total'         => $request->final_total,
            ]);
        }

        // Create Invoice
        $invoice = Invoice::create($data);

        // Add Invoice Items
        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item'       => $item['item'],
                'amount'     => $item['amount'],
            ]);
        }

        return redirect()
            ->route('invoices.index')
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
