{{-- LAYOUT – resources/views/admin/dashboard.blade.php (pages use @extends('admin.dashboard')) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Neerodai Admin')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Dancing+Script:wght@600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/css/admin.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    @stack('styles')
</head>
<body class="sb-nav-fixed na-admin">

    @include('admin.adminlayout.navbar')

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('admin.adminlayout.sidebar')
        </div>

        <div id="layoutSidenav_content">
            <main class="flex-grow-1 d-flex flex-column admin-background">
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>

            @include('admin.adminlayout.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('admin/js/datatables-simple-demo.js') }}"></script>

    @stack('scripts')
</body>
</html>