<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('frontend/assets/images/wcicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/wcicon.png') }}" type="image/x-icon">
    <title>@yield('title', 'Document')</title>
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

    @yield('content')

    <!-- Footer -->
    <div class="footer">
        <strong>webceylon Software Solutions</strong><br>
        No 156/1/A, Kaduwela Road, Athurugiriya, Sri Lanka<br>
        www.webceylon.com / info@webceylon.com<br>
        0771788080
    </div>

    @yield('scripts')
</body>

</html>