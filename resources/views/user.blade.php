<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- AOS CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

  <style>
    /* Custom styles for navbar + footer */
    .glass-nav { background: rgba(15,15,15,0.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
   
    .footer-link { color:#bbb; text-decoration:none; transition:color .3s; }
    .footer-link:hover { color:#0dcaf0; }
    .social-link { color:#fff; margin:0 8px; font-size:1.3rem; transition:all .3s; }
    .social-link:hover { color:#0dcaf0; transform:scale(1.2); }
    .text-greeny{
      color: #198754 !important;
    }
    .btn-greeny{
      background-color: #198754 !important;
      color: white !important;
    }
    .btn-greeny:hover{
      background-color: #13633eff !important;
      color: white !important;
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">

  @include('layout.header')

  <main class="flex-grow-1 greenymain-bg">
      @yield('content')
  </main>

  @include('layout.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,   // animation duration
    once: true        // animation happens only once
  });
</script>

</body>
</html>
