<!DOCTYPE html>
<html lang="{{ __('messages.lang') }}" dir="{{ __('messages.dir') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.title') }} </title>
    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-Dnh8PmVN.css') }}">
    <script src="{{ asset('build/assets/app-BnamtF72.js') }}"></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
  <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @livewireStyles --}}
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <meta name="description" content="{{ __('messages.objective') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: "Cairo", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: auto;
            font-variation-settings:
                "slnt" 0;
        }

        .custom-confirm-button {
            background-color: #C64D58 !important;
            color: white !important;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .custom-cancel-button {
            background-color: #dc3545 !important;
            color: white !important;
            border-radius: 5px;
            padding: 10px 20px;
        }
    </style>
    @yield('html')
</head>

<body class="bg-gray-100">
    <!-- الهيدر -->

    @include('includes.header')
    <!-- السلايدر -->
    @yield('content')

    <!-- الفوتر -->
    @include('includes.footer')

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

    @yield('script')
    <script>
        const toggleBtn = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        toggleBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (Session::has('success'))
                Swal.fire({
                    title: "نجاح!",
                    text: "{{ Session::get('success') }}",
                    icon: "success",
                    color: "#000",
                    confirmButtonText: "حسنًا",
                    timer: 5000,
                    customClass: {
                        confirmButton: 'custom-confirm-button'
                    }

                });
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    title: "خطأ!",
                    text: "{{ Session::get('error') }}",
                    icon: "error",
                    color: "#000",
                    confirmButtonText: "حسنًا",
                    timer: 5000,
                    customClass: {
                        confirmButton: 'custom-cancel-button'
                    }
                });
            @endif
        });
    </script>
    {{-- @livewireScripts --}}
</body>

</html>
