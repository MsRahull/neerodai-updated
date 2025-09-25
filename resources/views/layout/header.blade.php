<!-- Topbar -->
<div class="topbar bg-dark text-white py-1 small text-center text-md-start">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
    <div>Reg. No: TN/123/NGO/2020</div>
    <div>
      📞 <a href="tel:+918870657823" class="text-white text-decoration-none">+91 88706 57823</a>
      &nbsp;|&nbsp; 
      🌐 <a href="{{ url('lang/en') }}" class="text-warning text-decoration-none">English</a> /
      <a href="{{ url('lang/ta') }}" class="text-warning text-decoration-none">தமிழ்</a>
    </div>
  </div>
</div>

<header class="hero-header">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand fw-bold fs-4 text-success" href="#">🌿 Neerodai</a>

      <!-- Mobile Toggle -->
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Nav Links -->
      <div class="collapse navbar-collapse" id="mainNavbar">
       <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="/about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('gallery') ? 'active' : '' }}" href="/gallery">Gallery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('blog') ? 'active' : '' }}" href="/blog">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('videos') ? 'active' : '' }}" href="/videos">Videos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="/contact">Contact</a>
        </li>

          <!-- Language -->
          <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
            <a href="{{ url('lang/en') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 w-100">English</a>
          </li>
          <li class="nav-item ms-2 mt-2 mt-lg-0">
            <a href="{{ url('lang/ta') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 w-100">தமிழ்</a>
          </li>

          <!-- Donate (hidden on mobile) -->
          <li class="nav-item ms-lg-3 mt-2 mt-lg-0 d-none d-md-block">
            <a href="/pay" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold shadow donate-desktop">Donate</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


</header>

<a href="/pay" class="btn btn-success fixed-donate shadow-sm fw-semibold">
  💚 Donate
</a>


<style>
.topbar {
  font-size: 0.85rem;
}

.hero-header {
  background: url('/images/elders-banner.jpg') center/cover no-repeat;
  position: relative;
}
.hero-header::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.5);
}

.navbar .nav-link {
  color: #555;
  margin-left: 12px;
  position: relative;
  padding: 8px 14px;
  border-radius: 20px;
  transition: all .3s ease;
  font-weight: 500;
}

.navbar .nav-link::after {
  content: '';
  position: absolute;
  bottom: 6px;
  left: 14px;
  width: 0;
  height: 2px;
  background: #198754;
  transition: width .3s ease;
  border-radius: 1px;
}

.navbar .nav-link:hover::after {
  width: calc(100% - 28px);
}

.navbar .nav-link.active::after {
  display: none;
}

.navbar .nav-link.active {
  background-color: #198754 !important;
  color: #fff !important;
  font-weight: 600;
  box-shadow: 0 2px 6px rgba(25,135,84,0.3);
}
 .navbar-brand:hover { color:#0d6efd!important; }
 
    .navbar .nav-link.active:hover {
  background-color: #198754 !important;
  color: #fff !important;
}

.fixed-donate {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 999;
  display: none;
  color: #fff;         
  font-size: 1rem;
  border-radius: 50px;
  padding: 10px 20px;
}

@media (max-width: 767.98px) {
  .fixed-donate {
    display: inline-flex;
  }
}

</style>