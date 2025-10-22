<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title', 'Dashboard')</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('assets/admin/fonts/SansPro/SansPro.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/custom_rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/admin/css/mycustomstyle.css') }}?v={{ filemtime(public_path('assets/admin/css/mycustomstyle.css')) }}">

    <style>
        /* Hide everything by default when printing */
        @media print {
            body * {
                visibility: hidden;
            }

            /* Show only the content wrapper */
            .printer,
            .printer * {
                visibility: visible;
            }

            /* Position the content at the top-left corner */
            .printer {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* Show logo only during printing and make it full width */
            .printer .print-logo {
                display: block;
                width: 100%;
                height: auto;
                margin-top: 30px;
                /* فاصلة بسيطة بين التاريخ واللوجو */
                margin-bottom: 5px;
            }

            /* Show date only during printing */
            .print-date {
                display: block;
                text-align: right;
                /* على اليمين */
                margin-bottom: 0;
                font-weight: bold;
                font-size: 16px;
            }
        }

        /* Hide logo and date on screen */
        .print-logo,
        .print-date {
            display: none;
        }
    </style>

    @yield('css')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.includes.navbar')
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="printer">
            <!-- Date for printing only -->
            <div class="print-date">
                {{ \Carbon\Carbon::now()->format('Y-m-d') }}
            </div>

            <!-- Logo for printing only -->
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="print-logo">

            @include('admin.includes.content')
        </div>
        <!-- /.printer -->

        <!-- Main Footer -->
        @include('admin.includes.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <script>
        setTimeout(function() {
            let messages = document.querySelectorAll('.msg');
            messages.forEach(function(msg) {
                msg.style.transition = "opacity 1s ease-out";
                msg.style.opacity = 0;
                setTimeout(() => {
                    msg.style.display = 'none';
                }, 1000);
            });
        }, 5000);
    </script>

    @yield('script')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>

</html>
