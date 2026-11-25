<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Neerodai Trust')</title>

    {{-- SEO + social sharing previews (WhatsApp, Facebook, X). Pages override with
         @section('meta_description'), @section('og_image') and @section('og_type').
         Section values arrive already HTML-escaped by Blade, so they are printed with {!! !!} (not escaped twice). --}}
    @php
        $metaTitle = trim($__env->yieldContent('title', 'Neerodai Trust'));
        $metaDesc  = trim($__env->yieldContent('meta_description', __('Neerodai Trust provides daily meals, care and dignity to elderly people in need. Support our mission with a donation.')));
        $metaImage = trim($__env->yieldContent('og_image', asset('user/frontend/SLIDER2.jpg')));
        $canonical = url()->current();
    @endphp
    <meta name="description" content="{!! $metaDesc !!}">
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:site_name" content="Neerodai Trust">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="{!! $metaTitle !!}">
    <meta property="og:description" content="{!! $metaDesc !!}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{!! $metaImage !!}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'ta' ? 'ta_IN' : 'en_IN' }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{!! $metaTitle !!}">
    <meta name="twitter:description" content="{!! $metaDesc !!}">
    <meta name="twitter:image" content="{!! $metaImage !!}">
    <meta name="theme-color" content="#12823f">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

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