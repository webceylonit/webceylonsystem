@extends('Documents.main_invoice')

@section('title', 'Invoice')

@section('content')
<style>
    .invoice-title {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 25px;
        font-family: 'Arial', sans-serif;
        margin-top:50px;
    }

    .description-table {
        width: 100%;
        border-collapse: separate;
        border:1px solid #000;
        border-spacing: 0;
        margin-top: 20px;
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        overflow: hidden;
        border-radius: 8px 8px 0 0;
    }

    .description-table th {
        background-color: #007793;
        color: #ffffff;
        padding: 12px 10px;
        text-align: left;
        border-bottom: 2px solid #005e6b;
    }

    .description-table td {
        background-color: #ffffff;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .description-table tr:last-child td {
        border-bottom: none;
    }

    .description-table tr:nth-child(even) td {
        background-color: #f9f9f9;
    }

    .description-table th:nth-child(3),
    .description-table td:nth-child(3) {
        text-align: right;
    }

    .description-table tbody tr:hover td {
        background-color: #eef6f7;
    }

    .totals-table {
        width: 35%;
        margin-left: auto;
        border-collapse: separate;
        border-spacing: 0;
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        border-radius: 0 0 8px 8px;
        border:1px solid #000;
        overflow: hidden;
    }

    .totals-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #ddd;
        background-color: #ffffff;
    }

    .totals-table tr td:first-child {
        text-align: right;
        font-weight: bold;
        width: 65%;
    }

    .totals-table tr td:last-child {
        text-align: right;
        width: 35%;
    }

    .totals-table tr:last-child td {
        color: #000;
        font-weight: bold;
        font-size: 15px;
    }

    .bold {
        font-weight: bold;
    }

    .terms, .bank-details {
        margin-top: 30px;
        font-size: 12px;
    }

    .note {
        margin-top: 20px;
        font-size: 13px;
        font-style: italic;
    }
</style>

<div class="content">
    <div class="invoice-title">
        {{ strtoupper($doc->type) === 'TAX' ? 'TAX INVOICE' : 'INVOICE' }}
    </div>

    <div class="details-wrapper">
        <table style="width: 100%; border-collapse: collapse; font-family: 'Arial', sans-serif;">
            <tr>
                <td style="width: 20%; text-align: left; font-weight: bold;">Customer Name</td>
                <td style="width: 5%; text-align: center;">:</td>
                <td style="width: 25%; text-align: left;">{{ $doc->project->client->name ?? 'N/A' }}</td>

                <td style="width: 20%;"></td> <!-- Spacer -->

                <td style="width: 15%; text-align: left; font-weight: bold;">Invoice No</td>
                <td style="width: 2%; text-align: center;">:</td>
                <td style="width: 23%; text-align: right;">{{ $doc->invoice_number }}</td>
            </tr>
            <tr>
                <td style="text-align: left; font-weight: bold;">Address</td>
                <td style="text-align: center;">:</td>
                <td style="text-align: left;">{{ $doc->project->client->address ?? 'N/A' }}</td>

                <td></td> <!-- Spacer -->

                <td style="text-align: left; font-weight: bold;">Invoice Date</td>
                <td style="text-align: center;">:</td>
                <td style="text-align: right;">{{ $doc->created_at->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: left; font-weight: bold;">Contact No</td>
                <td style="text-align: center;">:</td>
                <td style="text-align: left;">{{ $doc->project->client->client_contact ?? 'N/A' }}</td>

                <td></td> <!-- Spacer -->

                <td style="text-align: left; font-weight: bold;">Project Code</td>
                <td style="text-align: center;">:</td>
                <td style="text-align: right;">{{ $doc->project->project_code ?? '-' }}</td>
            </tr>

            @if($doc->type === 'tax')
            <tr>
                <td style="text-align: left; font-weight: bold;">Client VAT No</td>
                <td style="text-align: center;">:</td>
                <td style="text-align: left;">{{ $doc->client_vat_no ?? 'N/A' }}</td>
                <td></td> <td></td> <td></td> <td></td>
            </tr>
            @endif
        </table>
    </div>

    <table class="description-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 70%;">Description</th>
                <th style="width: 25%;">Amount (LKR/USD)</th>
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

            @php
                $emptyRows = max(0, 3 - $doc->items->count());
            @endphp

            @for ($i = 0; $i < $emptyRows; $i++)
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @endfor
        </tbody>
    </table>

    <table class="totals-table">
        @if($doc->type === 'tax')
            <tr>
                <td class="bold">Sub Total</td>
                <td>{{ number_format($doc->after_discount_total, 2) }}</td>
            </tr>
            <tr>
                <td class="bold">SSCL (2.5%)</td>
                <td>{{ number_format($doc->sscl, 2) }}</td>
            </tr>
            <tr>
                <td class="bold">VAT (18%)</td>
                <td>{{ number_format($doc->vat, 2) }}</td>
            </tr>
            <tr>
                <td class="bold">Final Total</td>
                <td class="bold">{{ number_format($doc->final_total, 2) }}</td>
            </tr>
        @else
            <tr>
                <td class="bold">Sub Total</td>
                <td>{{ number_format($doc->sub_total, 2) }}</td>
            </tr>
            <tr>
                <td class="bold">Discount ({{ number_format($doc->discount_percentage, 2) }}%)</td>
                <td>- {{ number_format($doc->discount_amount, 2) }}</td>
            </tr>
            <tr>
                <td class="bold">Final Total</td>
                <td class="bold">{{ number_format($doc->final_total, 2) }}</td>
            </tr>
        @endif
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
