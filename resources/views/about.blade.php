@extends('user')

@section('title', __('About Us') . ' - ' . __('Neerodai Trust'))

@section('content')

@php
    // Optional banner photo (e.g. hands holding a plant). Leave null for the green leafy gradient.
    $bannerImage = null; // e.g. 'about-banner.jpg' inside public/user/frontend/
@endphp

<div class="ab">

{{-- ================= PAGE BANNER ================= --}}
<section class="ab-banner" @if($bannerImage) style="background-image:url('{{ asset('user/frontend/' . $bannerImage) }}')" @endif>
    <div class="ab-banner-overlay"></div>
    <svg class="ab-banner-leaf ab-bl-1" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>
    <svg class="ab-banner-leaf ab-bl-2" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>

    <div class="container ab-banner-content">
        <nav aria-label="breadcrumb" class="ab-crumb">
            <a href="{{ url('/') }}">{{ __('Home') }}</a> <i class="bi bi-chevron-right"></i> <span>{{ __('About Us') }}</span>
        </nav>
        <h1>{{ __('About Us') }}</h1>
        <p>{{ __('Together for a Better Tomorrow') }}</p>
        <span class="ab-gold-bar"></span>
    </div>

    <svg class="ab-banner-wave" viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 40 C 400 0, 1000 70, 1440 20 L1440 60 L0 60 Z"/>
    </svg>
</section>

{{-- ================= FOUNDER ================= --}}
<section class="ab-section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <div class="ab-founder-img">
                    <img src="{{ asset('user/frontend/about1.jpg') }}" alt="{{ __('messages.name') }}">
                    <svg class="ab-founder-leaf" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z"/></svg>
                </div>
            </div>
            <div class="col-lg-7">
                <span class="ab-label">{{ __('messages.our_founder') }} <span class="ab-line"></span></span>
                <h2 class="ab-title">{{ __('messages.name') }}</h2>
                <p class="ab-lead">{{ __('messages.intro') }}</p>

                <ul class="ab-checks">
                    <li><i class="bi bi-check-circle-fill"></i> {{ __('messages.roles.pastor') }}</li>
                    <li><i class="bi bi-check-circle-fill"></i> {{ __('messages.roles.leader') }}</li>
                    <li><i class="bi bi-check-circle-fill"></i> {{ __('messages.roles.security') }}</li>
                </ul>

                <p class="ab-text mb-0">{{ __('messages.closing') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ================= MISSION ================= --}}
<section class="ab-section pt-0">
    <div class="container">
        <div class="ab-mission">
            <svg class="ab-mission-leaf" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>
            <div class="row g-4 g-lg-5 align-items-center">
                <div class="col-lg-6 order-2 order-lg-1">
                    <span class="ab-label">{{ __('messages.our_mission') }} <span class="ab-line"></span></span>
                    <h2 class="ab-title">{{ __('Serving with Compassion') }}</h2>
                    <p class="ab-lead">{{ __('messages.our_mission_content') }}</p>
                    <a href="{{ url('/pay') }}" class="ab-btn ab-btn-green">{{ __('Support Our Work') }} <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="ab-photo">
                        <img src="{{ asset('user/frontend/about2.jpg') }}" alt="{{ __('Elderly food distribution') }}" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= VISION ================= --}}
<section class="ab-section pt-0">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="col-lg-6">
                <div class="ab-photo">
                    <img src="{{ asset('user/frontend/about3.jpg') }}" alt="{{ __('Caring for elders') }}" loading="lazy">
                </div>
            </div>
            <div class="col-lg-6">
                <span class="ab-label">{{ __('messages.our_vision') }} <span class="ab-line"></span></span>
                <h2 class="ab-title">{{ __('A Caring Community') }}</h2>
                <p class="ab-lead">{{ __('messages.our_vision_content') }}</p>
                <ul class="ab-checks">
                    <li><i class="bi bi-check-circle-fill"></i> {{ __('Sustainable support for elders') }}</li>
                    <li><i class="bi bi-check-circle-fill"></i> {{ __('Creating loving communities') }}</li>
                    <li><i class="bi bi-check-circle-fill"></i> {{ __('Empowering volunteers to serve') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ================= CTA BAND ================= --}}
<section class="ab-cta-wrap">
    <div class="container-fluid px-3 px-lg-4">
        <div class="ab-cta">
            <span class="ab-cta-icon"><i class="bi bi-heart-pulse"></i></span>
            <span class="ab-cta-divider d-none d-md-block"></span>
            <div class="ab-cta-copy">
                <h2>{{ __('Be a Part of Our Mission') }}</h2>
                <p>{{ __('Your support helps us bring hope, care and dignity to the elderly.') }}</p>
            </div>
            <a href="{{ url('/pay') }}" class="ab-btn ab-btn-gold"><i class="bi bi-heart-fill"></i> {{ __('Donate Now') }} <i class="bi bi-arrow-right"></i></a>
            <svg class="ab-cta-hills" viewBox="0 0 600 80" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0 80 C 120 30, 220 60, 320 40 C 420 20, 500 50, 600 30 L600 80 Z"/>
            </svg>
        </div>
    </div>
</section>

</div>
@endsection

@push('styles')
<style>
.ab {
    --g: #12823f;
    --g-dark: #0b5e2d;
    --g-deep: #0a4a26;
    --g-soft: #eaf6ee;
    --ink: #1d2b24;
    --muted: #55635c;
    --gold: #ffc61a;
    font-family: 'Poppins', 'Noto Sans Tamil', system-ui, sans-serif;
    color: var(--ink);
    overflow-x: hidden;
}
.ab a { text-decoration: none; }
.ab h1, .ab h2, .ab h3 { font-family: inherit; }

/* Shared */
.ab-section { padding: 70px 0; }
.ab-label { display: inline-flex; align-items: center; gap: .8rem; color: var(--g); font-weight: 700; font-size: 1rem; letter-spacing: .04em; text-transform: uppercase; margin-bottom: .4rem; }
.ab-line { display: inline-block; width: 56px; height: 2px; background: var(--gold); }
.ab-title { font-size: clamp(1.8rem, 3.2vw, 2.4rem); font-weight: 700; color: var(--ink); margin-bottom: 1rem; }
.ab-lead { color: var(--muted); font-size: 1.05rem; line-height: 1.8; margin-bottom: 1.4rem; }
.ab-text { color: var(--muted); font-size: .95rem; line-height: 1.8; }
.ab-checks { list-style: none; padding: 0; margin: 0 0 1.4rem; display: grid; gap: .7rem; }
.ab-checks li { display: flex; align-items: flex-start; gap: .65rem; font-weight: 500; font-size: .98rem; }
.ab-checks i { color: var(--g); font-size: 1.15rem; line-height: 1.4; }

.ab-btn { display: inline-flex; align-items: center; gap: .55rem; padding: .85rem 1.7rem; border-radius: 50px; font-weight: 600; transition: all .25s ease; }
.ab-btn-green { background: var(--g); color: #fff; box-shadow: 0 8px 20px rgba(18,130,63,.25); }
.ab-btn-green:hover { background: var(--g-dark); color: #fff; transform: translateY(-2px); }
.ab-btn-gold { background: var(--gold); color: var(--ink); font-weight: 700; box-shadow: 0 8px 20px rgba(0,0,0,.15); white-space: nowrap; }
.ab-btn-gold:hover { background: #ffd34d; color: var(--ink); transform: translateY(-2px); }

/* Banner */
.ab-banner {
    position: relative; overflow: hidden; padding: 80px 0 110px;
    background: radial-gradient(circle at 80% 30%, #3fa45b 0%, #12823f 35%, #0a4a26 100%);
    background-size: cover; background-position: center;
}
.ab-banner-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(8,59,31,.85) 0%, rgba(8,59,31,.55) 50%, rgba(8,59,31,.1) 100%); }
.ab-banner-content { position: relative; z-index: 2; }
.ab-crumb { font-size: .88rem; color: rgba(255,255,255,.8); margin-bottom: .8rem; }
.ab-crumb a { color: #fff; }
.ab-crumb a:hover { color: var(--gold); }
.ab-crumb i { font-size: .7rem; margin: 0 .35rem; }
.ab-banner h1 { color: #fff; font-size: clamp(2.6rem, 6vw, 4rem); font-weight: 800; margin-bottom: .4rem; }
.ab-banner p { color: rgba(255,255,255,.92); font-size: clamp(1.1rem, 2vw, 1.4rem); margin-bottom: 1rem; }
.ab-gold-bar { display: block; width: 70px; height: 4px; border-radius: 4px; background: var(--gold); }
.ab-banner-leaf { position: absolute; z-index: 1; }
.ab-banner-leaf path { fill: rgba(255,255,255,.1); stroke: rgba(255,255,255,.15); stroke-width: 2; }
.ab-bl-1 { right: 8%; top: 10px; width: 150px; transform: rotate(25deg); }
.ab-bl-2 { right: 24%; bottom: 20px; width: 80px; transform: rotate(-20deg); }
.ab-banner-wave { position: absolute; left: 0; bottom: -1px; width: 100%; height: 60px; z-index: 2; }
.ab-banner-wave path { fill: #fff; }

/* Founder */
.ab-founder-img {
    position: relative; overflow: hidden; border-radius: 18px; padding: 8px; background: #fff;
    box-shadow: 0 18px 40px rgba(10,74,38,.15);
}
.ab-founder-img img { display: block; width: 100%; height: 400px; object-fit: cover; object-position: top center; border-radius: 12px; background: var(--g-soft); }
.ab-founder-leaf { position: absolute; right: -10px; bottom: 10px; width: 110px; pointer-events: none; }
.ab-founder-leaf path { fill: rgba(111,191,115,.35); }

/* Mission card */
.ab-mission {
    position: relative; overflow: hidden; border-radius: 28px; padding: 3rem;
    background: linear-gradient(120deg, #f2faf4 0%, #e3f3e7 100%); border: 1px solid #d8eedd;
}
.ab-mission-leaf { position: absolute; left: 42%; bottom: -20px; width: 120px; transform: rotate(-25deg); pointer-events: none; }
.ab-mission-leaf path { fill: rgba(18,130,63,.08); stroke: rgba(18,130,63,.12); stroke-width: 2; }
.ab-mission .row { position: relative; z-index: 1; }

/* Photos */
.ab-photo { border-radius: 18px; overflow: hidden; padding: 6px; background: #fff; box-shadow: 0 16px 36px rgba(10,74,38,.14); }
.ab-photo img { display: block; width: 100%; height: 340px; object-fit: cover; border-radius: 13px; transition: transform .5s ease; }
.ab-photo:hover img { transform: scale(1.04); }

/* CTA */
.ab-cta-wrap { padding: 10px 0 0; }
.ab-cta {
    position: relative; overflow: hidden; display: flex; align-items: center; gap: 1.8rem;
    padding: 2rem 2.6rem; border-radius: 20px;
    background: linear-gradient(100deg, #0b5e2d 0%, #12823f 55%, #4fa83d 100%);
}
.ab-cta > *:not(.ab-cta-hills) { position: relative; z-index: 1; }
.ab-cta-icon { width: 72px; height: 72px; flex: 0 0 72px; display: grid; place-items: center; border-radius: 50%; border: 2px solid rgba(255,255,255,.6); color: #fff; font-size: 2.1rem; }
.ab-cta-divider { width: 2px; align-self: stretch; background: rgba(255,255,255,.35); }
.ab-cta-copy { flex: 1; }
.ab-cta h2 { color: #fff; font-size: clamp(1.4rem, 2.6vw, 1.9rem); font-weight: 700; margin-bottom: .25rem; }
.ab-cta p { color: rgba(255,255,255,.9); margin: 0; }
.ab-cta-hills { position: absolute; right: 0; bottom: 0; width: 55%; height: 60px; z-index: 0; }
.ab-cta-hills path { fill: rgba(0,0,0,.1); }

/* Responsive */
@media (max-width: 991.98px) {
    .ab-section { padding: 56px 0; }
    .ab-founder-img img { height: 380px; }
    .ab-mission { padding: 2rem; }
    .ab-mission-leaf { display: none; }
    .ab-photo img { height: 300px; }
}
@media (max-width: 767.98px) {
    .ab-banner { padding: 56px 0 90px; }
    .ab-bl-2 { display: none; }
    .ab-bl-1 { width: 100px; right: -10px; }
    .ab-cta { flex-direction: column; align-items: flex-start; gap: 1rem; padding: 1.8rem 1.4rem; }
    .ab-cta-icon { width: 58px; height: 58px; flex-basis: 58px; font-size: 1.7rem; }
}
@media (max-width: 575.98px) {
    .ab-founder-img img { height: 340px; }
    .ab-mission { padding: 1.5rem; border-radius: 20px; }
    .ab-photo img { height: 240px; }
}
</style>
@endpush