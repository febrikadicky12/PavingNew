<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <title>@yield('title', default: 'Dashboard')</title>

    <!-- Link ke Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Nunito:wght@300;400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Link ke CSS NiceAdmin -->
    <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/css/style.css') }}" rel="stylesheet">

    @stack('styles') <!-- Untuk custom CSS di halaman lain -->
</head>
<body>
    <div class="container">
        <!-- Include Sidebar -->
        @include('layouts.sidebar')

        <main class="container">
            @yield('content') <!-- Tempat konten halaman lain -->
        </main>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


        <!-- Include Footer -->
        @include('layouts.footer')
    </div>

    <!-- Script JS -->
    <script src="{{ asset('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/js/main.js') }}"></script>

    @stack('scripts') <!-- Untuk custom JS di halaman lain -->
</body>
</html>
