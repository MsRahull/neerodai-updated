<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Neerodai Trust')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (required by the updated homepage) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Font Awesome (keep for existing header/footer icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- AOS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #20332e;
            background: #fff;
        }

        .glass-nav {
            background: rgba(15, 15, 15, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .footer-link {
            color: #bbb;
            text-decoration: none;
            transition: color .3s;
        }

        .footer-link:hover {
            color: #0dcaf0;
        }

        .social-link {
            color: #fff;
            margin: 0 8px;
            font-size: 1.3rem;
            transition: all .3s;
        }

        .social-link:hover {
            color: #0dcaf0;
            transform: scale(1.2);
        }

        .text-greeny {
            color: #198754 !important;
        }

        .btn-greeny {
            background-color: #198754 !important;
            color: white !important;
        }

        .btn-greeny:hover {
            background-color: #13633e !important;
            color: white !important;
        }
    </style>

    {{-- IMPORTANT: Loads page-specific CSS from @push('styles') --}}
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">

    @include('layout.header')

    <main class="flex-grow-1 greenymain-bg">
        @yield('content')
    </main>

    @include('layout.footer')

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>