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
        padding: 4px;
    }

    .description-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .description-table th,
    .description-table td {
        border: 1px solid #999;
        padding: 8px;
    }

    .totals {
        width: 300px;
        margin-left: auto;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .totals td {
        padding: 6px;
    }

    .bold {
        font-weight: bold;
    }

    .terms,
    .bank-details {
        margin-top: 30px;
    }

    ul {
        padding-left: 20px;
        margin: 0;
    }
</style>

<!-- Main printable content -->
<div class="content">
    <div class="invoice-title">INVOICE</div>

    <div class="details-wrapper">
        <table class="details-left">
            <tr>
                <td class="bold">ISSUED TO:</td>
                <td>...........................................</td>
            </tr>
            <tr>
                <td class="bold">Customer:</td>
                <td>...........................................</td>
            </tr>
            <tr>
                <td class="bold">Contact No:</td>
                <td>...........................................</td>
            </tr>
        </table>
        <table class="details-right">
            <tr>
                <td class="bold">Invoice No:</td>
                <td>INV-001</td>
            </tr>
            <tr>
                <td class="bold">Date:</td>
                <td>{{ \Carbon\Carbon::now()->format('Y-m-d') }}</td>
            </tr>
        </table>
    </div>

    <table class="description-table">
        <thead>
            <tr>
                <th style="width: 10%;">No</th>
                <th style="width: 60%;">Description</th>
                <th style="width: 30%;">Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>...................................</td>
                <td>xxxx.xx</td>
            </tr>
            <tr>
                <td>2</td>
                <td>...................................</td>
                <td>xxxx.xx</td>
            </tr>
            <tr>
                <td>3</td>
                <td>...................................</td>
                <td>xxxx.xx</td>
            </tr>
            <tr>
                <td colspan="2" class="bold">TOTAL</td>
                <td>xxxx.xx</td>
            </tr>
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>SUBTOTAL:</td>
            <td>xxxx.xx</td>
        </tr>
        <tr>
            <td>DISCOUNT:</td>
            <td>xxxx.xx</td>
        </tr>
        <tr>
            <td>TAX:</td>
            <td>xxxx.xx</td>
        </tr>
        <tr>
            <td class="bold">BALANCE:</td>
            <td class="bold">xxxx.xx</td>
        </tr>
    </table>

    <div class="terms">
        <p class="bold">Payment Terms:</p>
        <p>This invoice allows for payment in two instalments:</p>
        <ul>
            <li>First Payment (50%): xxxx.xx</li>
            <li>Second Payment (50%): xxxx.xx</li>
        </ul>
        <p>Kindly settle the first payment upon receipt of this invoice.<br />The second
            payment is due upon project completion/delivery.<br />
            Please note this document serves as the official payment request. </p>
    </div>

    <div class="bank-details">
        <p class="bold">Bank Details:</p>
        <ul>
            <li>Bank Name: xxxxxxxxxxxxxxx</li>
            <li>Account Holder Name: xxxxxxxxxxxxxxxxx</li>
            <li>Account Number: xxxxxxxxxxxxxxxxxxx</li>
            <li>Branch Name: xxxxxxxxxxxxxxxxxxxxx</li>
        </ul>
    </div>
</div>

@endsection

@section('scripts')
<script>
    window.onafterprint = function() {
        window.location.href = "{{ route('dashboard') }}";
    };
</script>
@endsection