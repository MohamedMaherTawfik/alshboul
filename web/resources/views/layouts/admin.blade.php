<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title', 'Dashboard')</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }} ">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/adminlte.min.css') }} ">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('assets/admin/fonts/SansPro/SansPro.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/custom_rtl.css') }} ">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/mycustomstyle.css') }}?v={{ filemtime(public_path('assets/admin/css/mycustomstyle.css')) }}">

    @yield('css')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.includes.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->


        <!-- Content Wrapper. Contains page content -->
        @include('admin.includes.content')
        <!-- /.content-wrapper -->



        <!-- Main Footer -->
        @include('admin.includes.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    {{-- <script src="{{ asset('assets/admin/js/jquery-3.7.1.js')}}"></script> --}}
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
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
</body>

</html>
