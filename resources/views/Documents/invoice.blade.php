@extends('Documents.main')

@section('title', 'Invoice')

@section('content')
<style>
    .invoice-title {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 25px;
    }

    .details-wrapper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .details-left td,
    .details-right td {
        padding: 4px 8px;
    }

    .description-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .description-table th,
    .description-table td {
        border: 1px solid #000;
        padding: 8px;
    }

    .description-table th:nth-child(3),
    .description-table td:nth-child(3) {
        text-align: right;
    }

    .totals-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        margin-bottom: 15px;
        float: right;
    }

    .totals-table td {
        padding: 6px 8px;
    }

    .totals-table td:first-child {
        border: none;
        width: 70%;
        text-align: right;
    }

    .totals-table td:last-child {
        border: 1px solid #000;
        width: 18%;
        text-align: right;
    }

    .bold {
        font-weight: bold;
    }

    .terms,
    .bank-details {
        margin-top: 30px;
        font-size: 14px;
    }

    .note {
        margin-top: 20px;
        font-size: 13px;
        font-style: italic;
    }
</style>

<div class="content">
    <div class="invoice-title">INVOICE</div>

    <div class="details-wrapper">
        <table class="details-left">
            <tr>
                <td class="bold">Customer Name:</td>
                <td>{{ $doc->project->client->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="bold">Address:</td>
                <td>{{ $doc->project->client->address ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="bold">Contact No:</td>
                <td>{{ $doc->project->client->client_contact ?? 'N/A' }}</td>
            </tr>
        </table>
        <table class="details-right">
            <tr>
                <td class="bold">Invoice No:</td>
                <td>{{ $doc->invoice_number }}</td>
            </tr>
            <tr>
                <td class="bold">Invoice Date:</td>
                <td>{{ $doc->created_at->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td class="bold">Project Code:</td>
                <td>{{ $doc->project->project_code ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <table class="description-table">
        <thead>
            <tr>
                <th style="width: 10%;">No</th>
                <th style="width: 70%;">Description</th>
                <th style="width: 20%;">Amount (LKR/USD)</th>
            </tr>
        </thead>
        <tbody>
             @foreach ($doc->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->item }}</td>
                <td>{{ number_format($item->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td class="bold">Sub Total</td>
            <td>{{ number_format($doc->sub_total, 2) }}</td>
        </tr>
        <tr>
            <td class="bold">SSCL 2.5%</td>
            <td>{{ number_format($doc->sscl, 2) }}</td>
        </tr>
        <tr>
            <td class="bold">VAT 18%</td>
            <td>{{ number_format($doc->vat, 2) }}</td>
        </tr>
        <tr>
            <td class="bold">Total Amount</td>
            <td class="bold">{{ number_format($doc->total_amount, 2) }}</td>
        </tr>
    </table>

    <div class="terms">
        <p><strong>Payment Terms:</strong>
        This invoice is structured for payment in the following three instalments:</p>
        <ol>
            <li>First Instalment – 50% of the invoice value is due immediately upon receipt of this invoice.</li>
            <li>Second Instalment – 40% of the invoice value is due upon 60% completion of the project.</li>
            <li>Final & Balance – 10% of the invoice value is payable prior to the final handover or official project closure.</li>
        </ol>
    </div>

    <div class="bank-details">
        <p class="bold">Payment should be deposited or transferred only to the below bank details:</p>
        <ul>
            <li>Account Name: Ceylon Business Partners (Pvt) Ltd</li>
            <li>Account Number: 154010013656</li>
            <li>Bank Name: Hatton National Bank (HNB)</li>
            <li>Branch Name: Athurugiriya</li>
            <li>Bank Code: 7083</li>
            <li>Branch Code: 154</li>
        </ul>
    </div>

    <div class="note">
        Approved by: WebCeylon.com<br>
        Note: This is a system-generated invoice and physical signature is not required.
    </div>
</div>

@endsection

@section('scripts')
<script>
    window.onafterprint = function() {
        window.location.href = "{{ route('invoices.index') }}";
    };
</script>
@endsection
