<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning | {{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
        integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
        crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('template-admin/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template-admin/vendor/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('template-admin/vendor/perfect-scrollbar/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- CSS for this page only -->
    <link rel="stylesheet" href="{{ asset('template-admin/vendor/chart.js/Chart.min.css') }}">
    <!-- End CSS  -->

       <!-- CSS for this page only -->
    <link href="{{ asset('template-admin/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('template-admin/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" />


    <link rel="stylesheet" href="{{ asset('template-admin/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template-admin/assets/css/bootstrap-override.min.css') }}">
    <link rel="stylesheet" id="theme-color" href="{{ asset('template-admin/assets/css/dark.min.css') }}">
</head>

<body>
    <div id="app">
        <div class="shadow-header"></div>

        @include('master.layouts.header')

        @include('master.layouts.sidebar')
        <div class="main-content">

            @yield('content')
        </div>

        @include('master.layouts.settingan')

        <footer>
            SMA Budi Luhur Yogyakarta <span>&#169; {{ now()->year }}</span>
        </footer>
        <div class="overlay action-toggle">
        </div>
    </div>

     {{-- SweatAlert --}}
    @include('sweetalert::alert')

    <script src="{{ asset('template-admin/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('template-admin/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <!-- js for this page only -->
    <script src="{{ asset('template-admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('template-admin/assets/js/pages/index.min.js') }}"></script>

     @stack('scripts')

    <script src="{{ asset('template-admin/assets/js/main.min.js') }}"></script>
    <script>
        Main.init()
    </script>
</body>

</html>
