<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Link ke CSS NiceAdmin -->
    <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/css/style.css') }}" rel="stylesheet">

    @stack('styles') <!-- Untuk custom CSS di halaman lain -->
</head>
<body>

    <!-- Include Navbar -->
    @include('layouts.navbar')

    <main class="container">
        @yield('content') <!-- Tempat konten halaman lain -->
    </main>

    <!-- Include Footer -->
    @include('layouts.footer')

    <!-- Script JS -->
    <script src="{{ asset('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/js/main.js') }}"></script>

    @stack('scripts') <!-- Untuk custom JS di halaman lain -->
</body>
</html>
