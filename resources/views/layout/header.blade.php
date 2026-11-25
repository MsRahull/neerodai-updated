@php
    $locale = app()->getLocale();
    $regNo  = 'TN/123/NGO/2020'; // TODO: replace with your real registration number
    $phone  = '+918110079041';
    $phoneLabel = '+91 81100 79041';
@endphp

<header class="nh">

    {{-- ================= TOP BAR ================= --}}
    <div class="nh-top">
        <div class="container d-flex justify-content-between align-items-center gap-3">
            <span class="nh-reg d-none d-sm-inline"><i class="bi bi-patch-check-fill"></i> Reg. No: {{ $regNo }}</span>
            <div class="nh-top-right">
                <a href="tel:{{ $phone }}"><i class="bi bi-telephone-fill"></i> {{ $phoneLabel }}</a>
                <span class="nh-sep">|</span>
                <a href="{{ url('lang/en') }}" class="nh-lang-link {{ $locale === 'en' ? 'is-active' : '' }}">English</a>
                <span>/</span>
                <a href="{{ url('lang/ta') }}" class="nh-lang-link {{ $locale === 'ta' ? 'is-active' : '' }}">தமிழ்</a>
            </div>
        </div>
    </div>

    {{-- ================= NAVBAR ================= --}}
    <nav class="navbar navbar-expand-lg nh-nav" aria-label="Main navigation">
        <div class="container">

            <a class="nh-brand" href="{{ url('/') }}">
                <span class="nh-logo" aria-hidden="true">
                    {{-- If you have a logo image, replace this <svg> with:
                         <img src="{{ asset('logo.png') }}" alt="" width="46" height="46"> --}}
                    <svg viewBox="0 0 48 48">
                        <circle cx="24" cy="11" r="5" fill="#f4b63f"/>
                        <path d="M24 44 C 24 34, 24 26, 24 19" stroke="#12823f" stroke-width="3" fill="none" stroke-linecap="round"/>
                        <path d="M24 30 C 14 30, 6 22, 5 13 C 15 13, 23 20, 24 30 Z" fill="#12823f"/>
                        <path d="M24 30 C 34 30, 42 22, 43 13 C 33 13, 25 20, 24 30 Z" fill="#6fbf73"/>
                        <path d="M10 36 C 16 42, 32 42, 38 36" stroke="#12823f" stroke-width="3" fill="none" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="nh-brand-text">
                    <strong>Neerodai</strong>
                    <small>Trust</small>
                </span>
            </a>

            <div class="d-flex align-items-center gap-2 d-lg-none">
                <a href="{{ url('/pay') }}" class="nh-donate nh-donate-sm"><i class="bi bi-heart-fill"></i> Donate</a>
                <button class="nh-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                        aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span><span></span><span></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">About</a></li>

                    <li class="nav-item"><a class="nav-link {{ request()->is('gallery*') ? 'active' : '' }}" href="{{ url('/gallery') }}">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('blogs*') ? 'active' : '' }}" href="{{ url('/blogs') }}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('videos*') ? 'active' : '' }}" href="{{ url('/videos') }}">Videos</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact</a></li>
                </ul>

                <div class="nh-actions">
                    <div class="nh-lang" role="group" aria-label="Language">
                        <a href="{{ url('lang/en') }}" class="{{ $locale === 'en' ? 'is-active' : '' }}">English</a>
                        <a href="{{ url('lang/ta') }}" class="{{ $locale === 'ta' ? 'is-active' : '' }}">தமிழ்</a>
                    </div>
                    <a href="{{ url('/pay') }}" class="nh-donate d-none d-lg-inline-flex"><i class="bi bi-heart-fill"></i> Donate</a>
                </div>
            </div>
        </div>
    </nav>
</header>

{{-- Floating WhatsApp (mobile) --}}
<a href="https://wa.me/918110079041?text=Hello%20Neerodai%20Team,%0A%0AI%20would%20like%20to%20support%20your%20mission%20of%20providing%20daily%20meals%20to%20elderly%20people.%20Please%20share%20the%20donation%20details.%20Thank%20you!%0A%0Aவணக்கம்%20நீரோடை%20குழுவினருக்கு,%0Aமுதியோருக்கு%20தினமும்%20உணவு%20வழங்கும்%20உங்கள்%20சேவையை%20ஆதரிக்க%20நான்%20நன்கொடை%20வழங்க%20விரும்புகிறேன்.%20தயவுசெய்து%20நன்கொடை%20செலுத்தும்%20விவரங்களை%20பகிரவும்.%20நன்றி!."
   target="_blank" rel="noopener" class="nh-whatsapp" aria-label="Chat with us on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<style>
.nh, .nh-whatsapp {
    --nh-green: #12823f;
    --nh-green-dark: #0b5e2d;
    --nh-green-deep: #0a4a26;
    --nh-green-soft: #eaf6ee;
    --nh-gold: #ffc61a;
    --nh-ink: #1d2b24;
}
.nh {
    position: sticky; top: 0; z-index: 1030;
    font-family: 'Poppins', 'Noto Sans Tamil', system-ui, sans-serif;
}
.nh a { text-decoration: none; }

/* Top bar */
.nh-top { background: var(--nh-green-deep); color: #fff; font-size: .82rem; padding: 6px 0; }
.nh-top a { color: #fff; }
.nh-top a:hover { color: var(--nh-gold); }
.nh-reg i { color: var(--nh-gold); margin-right: 4px; }
.nh-top-right { display: flex; align-items: center; gap: .5rem; margin-left: auto; }
.nh-top-right .bi-telephone-fill { margin-right: 4px; }
.nh-sep { opacity: .4; margin: 0 .2rem; }
.nh-lang-link.is-active { color: var(--nh-gold); font-weight: 600; }

/* Navbar */
.nh-nav { background: #fff; padding: 10px 0; box-shadow: 0 4px 18px rgba(0,0,0,.06); transition: padding .25s ease; }
.nh.is-scrolled .nh-nav { padding: 5px 0; }

.nh-brand { display: flex; align-items: center; gap: .6rem; margin-right: 1rem; }
.nh-logo { width: 46px; height: 46px; display: block; flex: 0 0 46px; }
.nh-logo svg, .nh-logo img { width: 100%; height: 100%; object-fit: contain; }
.nh-brand-text { display: flex; flex-direction: column; line-height: 1; }
.nh-brand-text strong { color: var(--nh-green-dark); font-size: 1.45rem; font-weight: 700; }
.nh-brand-text small { color: var(--nh-green); font-size: .95rem; letter-spacing: .25em; font-weight: 500; margin-top: 2px; }

.nh-nav .nav-link {
    color: #3c4a43; font-weight: 500; font-size: .95rem;
    padding: .5rem 1rem !important; margin: 0 2px; border-radius: 50px; transition: all .25s ease;
}
.nh-nav .nav-link:hover { color: var(--nh-green); background: var(--nh-green-soft); }
.nh-nav .nav-link.active { background: var(--nh-green); color: #fff; font-weight: 600; box-shadow: 0 4px 12px rgba(18,130,63,.3); }
.nh-nav .dropdown-toggle::after { vertical-align: .15em; margin-left: .35em; border-top-width: .32em; }

.nh-dropdown { border: 0; border-radius: 14px; padding: .5rem; box-shadow: 0 14px 34px rgba(0,0,0,.12); margin-top: 8px !important; min-width: 230px; }
.nh-dropdown .dropdown-item { border-radius: 10px; padding: .6rem .9rem; font-size: .92rem; color: var(--nh-ink); display: flex; align-items: center; gap: .6rem; }
.nh-dropdown .dropdown-item i { color: var(--nh-green); }
.nh-dropdown .dropdown-item:hover, .nh-dropdown .dropdown-item:focus { background: var(--nh-green-soft); color: var(--nh-green-dark); }

.nh-actions { display: flex; align-items: center; gap: .8rem; }
.nh-lang { display: inline-flex; border: 1.5px solid var(--nh-green); border-radius: 50px; padding: 2px; }
.nh-lang a { padding: .3rem .85rem; border-radius: 50px; font-size: .85rem; font-weight: 500; color: var(--nh-green-dark); transition: .2s; }
.nh-lang a.is-active { background: var(--nh-green); color: #fff; }
.nh-lang a:not(.is-active):hover { background: var(--nh-green-soft); }

.nh-donate {
    display: inline-flex; align-items: center; gap: .45rem; background: var(--nh-green); color: #fff !important;
    padding: .6rem 1.4rem; border-radius: 50px; font-weight: 600; font-size: .95rem;
    box-shadow: 0 6px 16px rgba(18,130,63,.3); transition: all .25s ease;
}
.nh-donate:hover { background: var(--nh-green-dark); transform: translateY(-2px); }
.nh-donate i { animation: nh-beat 1.6s ease-in-out infinite; }
.nh-donate-sm { padding: .45rem .95rem; font-size: .85rem; }
@keyframes nh-beat { 0%, 100% { transform: scale(1); } 15% { transform: scale(1.2); } 30% { transform: scale(1); } }

/* Hamburger */
.nh-toggler { width: 42px; height: 42px; border: 0; border-radius: 12px; background: var(--nh-green-soft); display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 5px; }
.nh-toggler span { width: 20px; height: 2px; background: var(--nh-green-dark); border-radius: 2px; transition: .3s; }
.nh-toggler[aria-expanded="true"] span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.nh-toggler[aria-expanded="true"] span:nth-child(2) { opacity: 0; }
.nh-toggler[aria-expanded="true"] span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* Mobile menu */
@media (max-width: 991.98px) {
    .nh-nav .navbar-collapse { margin-top: .8rem; padding: .8rem; background: #fff; border-top: 1px solid #eef2ef; }
    .nh-nav .nav-link { margin: 2px 0; }
    .nh-dropdown { box-shadow: none; background: var(--nh-green-soft); margin: 4px 0 !important; }
    .nh-actions { margin-top: .8rem; padding-top: .8rem; border-top: 1px solid #eef2ef; }
    .nh-brand-text strong { font-size: 1.25rem; }
    .nh-logo { width: 40px; height: 40px; flex-basis: 40px; }
}
@media (max-width: 575.98px) {
    .nh-top-right { margin: 0 auto; }
}

/* Floating WhatsApp */
.nh-whatsapp {
    position: fixed; right: 18px; bottom: 24px; z-index: 1040; width: 56px; height: 56px; border-radius: 50%;
    background: #25d366; color: #fff; display: grid; place-items: center; font-size: 1.9rem;
    box-shadow: 0 8px 22px rgba(37,211,102,.45); transition: transform .25s ease;
}
.nh-whatsapp:hover { color: #fff; transform: scale(1.08); }
.nh-whatsapp::before {
    content: ""; position: absolute; inset: 0; border-radius: 50%; background: #25d366; z-index: -1;
    animation: nh-ping 2.2s ease-out infinite;
}
@keyframes nh-ping { 0% { transform: scale(1); opacity: .6; } 100% { transform: scale(1.7); opacity: 0; } }

@media (prefers-reduced-motion: reduce) {
    .nh-donate i, .nh-whatsapp::before { animation: none; }
}
</style>

<script>
(function () {
    var h = document.querySelector('.nh');
    if (!h) return;
    function onScroll() { h.classList.toggle('is-scrolled', window.scrollY > 40); }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();
</script>