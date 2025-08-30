<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Vaishvik Welfare Foundation</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}" sizes="16x16" />
    <!-- Remix icon font css -->
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}" />
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/apexcharts.css') }}" />
    <!-- Data Table css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/dataTables.min.css') }}" />
    <!-- Text Editor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor-katex.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor.atom-one-dark.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor.quill.snow.css') }}" />
    <!-- Date picker css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}" />
    <!-- Calendar css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/full-calendar.css') }}" />
    <!-- Vector Map css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/jquery-jvectormap-2.0.5.css') }}" />
    <!-- Popup css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/magnific-popup.css') }}" />
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/slick.css') }}" />
    <!-- Prism css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/prism.css') }}" />
    <!-- File upload css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/file-upload.css') }}" />
    <!-- Audioplayer css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/audioplayer.css') }}" />
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    @stack('css')
</head>
<body>
    @include('master.sidebar')
    <main class="dashboard-main">
        @include('master.header')
        <div class="dashboard-content-wrapper">
            <div class="dashboard-main-body">
                @yield('content')
            </div>
            @include('master.footer')
        </div>
    </main>
    <!-- jQuery library js -->
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- Apex Chart js -->
    <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>
    <!-- Data Table js -->
    <script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>
    <!-- Iconify Font js -->
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
    <!-- jQuery UI js -->
    <script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
    <!-- Vector Map js -->
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Popup js -->
    <script src="{{ asset('assets/js/lib/magnifc-popup.min.js') }}"></script>
    <!-- Slick Slider js -->
    <script src="{{ asset('assets/js/lib/slick.min.js') }}"></script>
    <!-- Prism js -->
    <script src="{{ asset('assets/js/lib/prism.js') }}"></script>
    <!-- File upload js -->
    <script src="{{ asset('assets/js/lib/file-upload.js') }}"></script>
    <!-- Audioplayer js -->
    <script src="{{ asset('assets/js/lib/audioplayer.js') }}"></script>
    <!-- Main js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/homeOneChart.js') }}"></script>
    @stack('js')
</body>
</html>