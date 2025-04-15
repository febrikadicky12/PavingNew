<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Nunito:wght@300;400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- NiceAdmin CSS -->
    <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/css/style.css') }}" rel="stylesheet">

    @stack('styles') <!-- Custom CSS dari halaman lain -->
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        @includeIf('layoutskaryawanbulanan.sidebar', ['karyawan' => Auth::user()]) <!-- opsional bisa dikasih data -->

        <!-- Main Content -->
        <main class="container py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        @includeIf('layoutskaryawanbulanan.footer')
    </div>

    <!-- JS Vendor -->
    <script src="{{ asset('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/js/main.js') }}"></script>

    @stack('scripts') <!-- Custom JS dari halaman lain -->
</body>
</html>
