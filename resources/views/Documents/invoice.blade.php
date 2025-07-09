<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice PDF</title>
    <style>
        @page {
            size: A4;
            margin-top: 50px;
            margin-bottom: 20px;
            margin-left: 0;
            margin-right: 0;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin: 0;
            color: #000;
        }

        /* === Header === */
        .header-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            display: flex;
            align-items: center;
            z-index: 1000;
        }

        .header-orange {
            width: 100px;
            height: 60px;
            background-color: #ff7f00;
        }

        .header-logo {
            padding: 0 30px;

        }

        .header-logo img {
            height: 50px;
        }

        .header-line {
            background-color: #007793;
            height: 60px;
            flex: 1;
        }

        /* === Content Area with Side Margins Only === */
        .content {
            padding-left: 70px;
            padding-right: 70px;
            padding-top: 80px;
            /* Enough to clear header */
            padding-bottom: 80px;
            /* Enough to clear footer */
        }

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

        /* === Footer === */
        .footer {
            position: fixed;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }

        .footer strong {
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print()">

    <!-- Full-width fixed header -->
    <div class="header-wrapper">
        <div class="header-orange"></div>
        <div class="header-logo">
            <img src="{{ asset('frontend/assets/images/webceylon.png') }}" alt="Webceylon Logo">
        </div>
        <div class="header-line"></div>
    </div>

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

    <!-- Footer -->
    <div class="footer">
        <strong>webceylon Software Solutions</strong><br>
        No 156/1/A, Kaduwela Road, Athurugiriya, Sri Lanka<br>
        www.webceylon.com / info@webceylon.com<br>
        0771788080
    </div>

    <script>
        window.onafterprint = function() {
            window.location.href = "{{ route('dashboard') }}";
        };
    </script>
</body>

</html>