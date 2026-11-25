@extends('user')

@section('title', __('Gallery') . ' - ' . __('Neerodai Trust'))
@section('meta_description', __('Photos from Neerodai Trust\'s meal distributions, events and everyday care for elderly people.'))

@section('content')

@php
    // Optional banner photo. Leave null for the green leafy gradient.
    $bannerImage = null; // e.g. 'gallery-banner.jpg' inside public/user/frontend/

    // Filter buttons are built from the `category` column, if your galleries table has one.
    $categories = collect($galleries->items())
        ->pluck('category')
        ->filter()
        ->unique()
        ->values();

    $icons = ['bi-people-fill', 'bi-heart-fill'];
@endphp

<div class="gl">

{{-- ================= BANNER ================= --}}
<section class="gl-banner" @if($bannerImage) style="background-image:url('{{ asset('user/frontend/' . $bannerImage) }}')" @endif>
    <div class="gl-banner-overlay"></div>
    <svg class="gl-banner-leaf gl-bl-1" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>
    <svg class="gl-banner-leaf gl-bl-2" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>

    <div class="container gl-banner-content">
        <nav aria-label="breadcrumb" class="gl-crumb">
            <a href="{{ url('/') }}">{{ __('Home') }}</a> <i class="bi bi-chevron-right"></i> <span>{{ __('Gallery') }}</span>
        </nav>
        <h1>{{ __('Our Gallery') }}</h1>
        <p>{{ __('Moments of Care, Compassion and Community') }}</p>
        <span class="gl-gold-bar"></span>
    </div>

    <svg class="gl-banner-wave" viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true">
        <path class="w1" d="M0 30 C 400 0, 1000 60, 1440 10 L1440 60 L0 60 Z"/>
        <path class="w2" d="M0 42 C 420 10, 1000 70, 1440 25 L1440 60 L0 60 Z"/>
    </svg>
</section>

{{-- ================= GALLERY ================= --}}
<section class="gl-section">
    <div class="container">

        <div class="gl-head">
            <div class="gl-head-mark">
                <span></span>
                <svg viewBox="0 0 48 48" aria-hidden="true">
                    <circle cx="24" cy="10" r="5" fill="#ffc61a"/>
                    <path d="M24 44 C 24 34, 24 26, 24 18" stroke="#12823f" stroke-width="3" fill="none" stroke-linecap="round"/>
                    <path d="M24 30 C 14 30, 6 22, 5 13 C 15 13, 23 20, 24 30 Z" fill="#12823f"/>
                    <path d="M24 30 C 34 30, 42 22, 43 13 C 33 13, 25 20, 24 30 Z" fill="#6fbf73"/>
                </svg>
                <span></span>
            </div>
            <h2>{{ __('Our Gallery') }}</h2>
            <p>{{ __('A glimpse of our work and the lives we touch') }}</p>
        </div>

        @if($categories->count() > 1)
            <div class="gl-filters" role="group" aria-label="{{ __('Filter photos') }}">
                <button type="button" class="is-active" data-filter="all">{{ __('All') }}</button>
                @foreach($categories as $cat)
                    <button type="button" data-filter="{{ \Illuminate\Support\Str::slug($cat) }}">{{ __($cat) }}</button>
                @endforeach
            </div>
        @endif

        <div class="row g-4" id="glGrid">
            @forelse($galleries as $i => $gallery)
                @php
                    $src   = asset('uploads/gallery/' . $gallery->image);
                    $title = $gallery->title ?? null;
                    $cat   = $gallery->category ?? null;
                @endphp
                <div class="col-6 col-lg-4 gl-col" data-cat="{{ $cat ? \Illuminate\Support\Str::slug($cat) : '' }}">
                    <figure class="gl-card">
                        <a href="{{ $src }}" class="gl-thumb" data-index="{{ $loop->index }}"
                           data-caption="{{ $title ?? '' }}" aria-label="{{ __('Open photo') }} {{ $loop->iteration }}">
                            <img src="{{ $src }}" alt="{{ filled($title) ? $title : __('Neerodai Trust gallery photo') }}" loading="lazy">
                            <span class="gl-zoom"><i class="bi bi-arrows-angle-expand"></i></span>
                        </a>
                        @if($title)
                            <figcaption>
                                <i class="bi {{ $icons[$loop->index % 2] }}"></i> {{ $title }}
                            </figcaption>
                        @endif
                    </figure>
                </div>
            @empty
                <div class="col-12">
                    <div class="gl-empty">
                        <i class="bi bi-images"></i>
                        <p>{{ __('Photos will be shared here soon.') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        <p class="gl-no-match" id="glNoMatch" hidden>{{ __('No photos in this category on this page.') }}</p>

        @if($galleries->hasPages())
            <div class="gl-pagination">
                {{ $galleries->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</section>

{{-- ================= CTA ================= --}}
<section class="gl-cta-wrap">
    <div class="container-fluid px-3 px-lg-4">
        <div class="gl-cta">
            <svg class="gl-cta-leaf gl-cl-1" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>
            <svg class="gl-cta-leaf gl-cl-2" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>
            <span class="gl-cta-icon" aria-hidden="true">
                <svg viewBox="0 0 64 64">
                    <path d="M32 26 C 32 26, 22 19, 22 13 C 22 9, 25 7, 28 7 C 30 7, 31.5 8.5, 32 10 C 32.5 8.5, 34 7, 36 7 C 39 7, 42 9, 42 13 C 42 19, 32 26, 32 26 Z" fill="#12823f"/>
                    <path d="M6 30 L 14 46 C 16 50, 20 54, 26 54 L 30 54 L 30 44 C 30 41, 28 38, 25 36 L 17 30 C 15 29, 13 30, 14 32 L 19 39" fill="none" stroke="#0b5e2d" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M58 30 L 50 46 C 48 50, 44 54, 38 54 L 34 54 L 34 44 C 34 41, 36 38, 39 36 L 47 30 C 49 29, 51 30, 50 32 L 45 39" fill="none" stroke="#0b5e2d" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <span class="gl-cta-divider d-none d-md-block"></span>
            <div class="gl-cta-copy">
                <h2>{{ __('Together for a Better Tomorrow') }}</h2>
                <p>{{ __('Your support helps us continue our mission of care and compassion.') }}</p>
            </div>
            <a href="{{ url('/pay') }}" class="gl-btn-gold"><i class="bi bi-heart-fill"></i> {{ __('Donate Now') }} <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>

{{-- ================= LIGHTBOX ================= --}}
<div class="gl-lightbox" id="glLightbox" role="dialog" aria-modal="true" aria-label="{{ __('Photo viewer') }}" hidden>
    <button type="button" class="gl-lb-btn gl-lb-close" aria-label="{{ __('Close') }}"><i class="bi bi-x-lg"></i></button>
    <button type="button" class="gl-lb-btn gl-lb-prev" aria-label="{{ __('Previous') }}"><i class="bi bi-chevron-left"></i></button>
    <figure>
        <img src="" alt="{{ __('Neerodai Trust gallery photo') }}">
        <figcaption></figcaption>
    </figure>
    <button type="button" class="gl-lb-btn gl-lb-next" aria-label="{{ __('Next') }}"><i class="bi bi-chevron-right"></i></button>
</div>

</div>

<script>
(function () {
    var grid = document.getElementById('glGrid');
    if (!grid) return;

    /* ---------- Filters ---------- */
    var buttons = document.querySelectorAll('.gl-filters button');
    var cols = grid.querySelectorAll('.gl-col');
    var noMatch = document.getElementById('glNoMatch');

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            buttons.forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
            var f = btn.dataset.filter, shown = 0;
            cols.forEach(function (c) {
                var show = f === 'all' || c.dataset.cat === f;
                c.hidden = !show;
                if (show) shown++;
            });
            noMatch.hidden = shown !== 0;
        });
    });

    /* ---------- Lightbox ---------- */
    var lb = document.getElementById('glLightbox');
    var img = lb.querySelector('img');
    var cap = lb.querySelector('figcaption');
    var current = 0, lastFocus = null;

    function visibleThumbs() {
        return Array.prototype.filter.call(grid.querySelectorAll('.gl-thumb'), function (t) {
            return !t.closest('.gl-col').hidden;
        });
    }
    function show(i) {
        var list = visibleThumbs();
        if (!list.length) return;
        current = (i + list.length) % list.length;
        var t = list[current];
        img.src = t.getAttribute('href');
        img.alt = t.querySelector('img').alt;
        cap.textContent = t.dataset.caption || '';
        cap.hidden = !t.dataset.caption;
    }
    function open(i) {
        lastFocus = document.activeElement;
        show(i);
        lb.hidden = false;
        document.body.style.overflow = 'hidden';
        lb.querySelector('.gl-lb-close').focus();
    }
    function close() {
        lb.hidden = true;
        document.body.style.overflow = '';
        img.src = '';
        if (lastFocus) lastFocus.focus();
    }

    grid.addEventListener('click', function (e) {
        var t = e.target.closest('.gl-thumb');
        if (!t) return;
        e.preventDefault();
        open(visibleThumbs().indexOf(t));
    });
    lb.querySelector('.gl-lb-close').addEventListener('click', close);
    lb.querySelector('.gl-lb-prev').addEventListener('click', function () { show(current - 1); });
    lb.querySelector('.gl-lb-next').addEventListener('click', function () { show(current + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
    document.addEventListener('keydown', function (e) {
        if (lb.hidden) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') show(current - 1);
        if (e.key === 'ArrowRight') show(current + 1);
    });

    // Swipe on mobile
    var sx = null;
    lb.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) {
        if (sx === null) return;
        var dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 50) show(current + (dx < 0 ? 1 : -1));
        sx = null;
    });
})();
</script>

@endsection

@push('styles')
<style>
.gl {
    --g: #12823f;
    --g-dark: #0b5e2d;
    --g-deep: #0a4a26;
    --g-soft: #eaf6ee;
    --ink: #1d2b24;
    --muted: #55635c;
    --gold: #ffc61a;
    font-family: 'Poppins', 'Noto Sans Tamil', system-ui, sans-serif;
    color: var(--ink);
    background: #fff;
    overflow-x: hidden;
}
.gl a { text-decoration: none; }
.gl h1, .gl h2 { font-family: inherit; }

/* Banner */
.gl-banner {
    position: relative; overflow: hidden; padding: 80px 0 110px;
    background: radial-gradient(circle at 80% 30%, #3fa45b 0%, #12823f 35%, #0a4a26 100%);
    background-size: cover; background-position: center;
}
.gl-banner-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(8,59,31,.85) 0%, rgba(8,59,31,.55) 50%, rgba(8,59,31,.1) 100%); }
.gl-banner-content { position: relative; z-index: 2; }
.gl-crumb { font-size: .88rem; color: rgba(255,255,255,.8); margin-bottom: .8rem; }
.gl-crumb a { color: #fff; }
.gl-crumb a:hover { color: var(--gold); }
.gl-crumb i { font-size: .7rem; margin: 0 .35rem; }
.gl-banner h1 { color: #fff; font-size: clamp(2.6rem, 6vw, 4rem); font-weight: 800; margin-bottom: .4rem; }
.gl-banner p { color: rgba(255,255,255,.92); font-size: clamp(1.05rem, 2vw, 1.35rem); font-weight: 500; margin-bottom: 1rem; }
.gl-gold-bar { display: block; width: 80px; height: 5px; border-radius: 5px; background: var(--gold); }
.gl-banner-leaf { position: absolute; z-index: 1; }
.gl-banner-leaf path { fill: rgba(255,255,255,.1); stroke: rgba(255,255,255,.15); stroke-width: 2; }
.gl-bl-1 { right: 8%; top: 10px; width: 150px; transform: rotate(25deg); }
.gl-bl-2 { right: 24%; bottom: 20px; width: 80px; transform: rotate(-20deg); }
.gl-banner-wave { position: absolute; left: 0; bottom: -1px; width: 100%; height: 60px; z-index: 2; }
.gl-banner-wave .w1 { fill: #bfe3c7; }
.gl-banner-wave .w2 { fill: #fff; }

/* Section head */
.gl-section { padding: 50px 0 70px; }
.gl-head { text-align: center; margin-bottom: 1.8rem; }
.gl-head-mark { display: flex; align-items: center; justify-content: center; gap: .6rem; margin-bottom: .3rem; }
.gl-head-mark span { width: 120px; height: 3px; border-radius: 3px; background: #cfe8d5; }
.gl-head-mark svg { width: 46px; height: 46px; }
.gl-head h2 { font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 700; color: var(--g-dark); margin-bottom: .2rem; }
.gl-head p { color: var(--muted); font-size: 1.15rem; margin: 0; }

/* Filters */
.gl-filters { display: flex; flex-wrap: wrap; justify-content: center; gap: .7rem; margin-bottom: 2.2rem; }
.gl-filters button {
    border: 1.5px solid #bfe0c8; background: #fff; color: var(--g-dark); font-weight: 600; font-size: .92rem;
    padding: .5rem 1.4rem; border-radius: 50px; transition: all .2s ease;
}
.gl-filters button:hover { border-color: var(--g); background: var(--g-soft); }
.gl-filters button.is-active { background: var(--g); border-color: var(--g); color: #fff; box-shadow: 0 6px 14px rgba(18,130,63,.25); }

/* Cards */
.gl-card {
    margin: 0; height: 100%; background: #fff; border-radius: 14px; padding: 6px;
    box-shadow: 0 6px 22px rgba(10,74,38,.1); transition: transform .3s ease, box-shadow .3s ease;
}
.gl-card:hover { transform: translateY(-6px); box-shadow: 0 16px 34px rgba(10,74,38,.16); }
.gl-thumb { position: relative; display: block; overflow: hidden; border-radius: 10px; aspect-ratio: 4 / 3; background: var(--g-soft); }
.gl-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
.gl-card:hover .gl-thumb img { transform: scale(1.07); }
.gl-zoom {
    position: absolute; inset: 0; display: grid; place-items: center; color: #fff; font-size: 1.6rem;
    background: rgba(10,74,38,.35); opacity: 0; transition: opacity .3s ease;
}
.gl-thumb:hover .gl-zoom, .gl-thumb:focus-visible .gl-zoom { opacity: 1; }
.gl-card figcaption { display: flex; align-items: center; gap: .55rem; padding: .8rem .5rem .4rem; font-weight: 600; font-size: .95rem; }
.gl-card figcaption i { color: var(--g); font-size: 1.05rem; }

.gl-empty, .gl-no-match { text-align: center; color: var(--muted); padding: 3rem 1rem; }
.gl-empty i { font-size: 3rem; color: var(--g); }

/* Pagination */
.gl-pagination { display: flex; justify-content: center; margin-top: 2.8rem; }
.gl-pagination .pagination { gap: .4rem; margin: 0; flex-wrap: wrap; justify-content: center; }
.gl-pagination .page-link {
    min-width: 42px; height: 42px; display: grid; place-items: center; border-radius: 50% !important;
    border: 1.5px solid #cfe8d5; color: var(--g-dark); font-weight: 600; transition: all .2s ease;
}
.gl-pagination .page-link:hover { background: var(--g-soft); border-color: var(--g); color: var(--g-dark); }
.gl-pagination .page-item.active .page-link { background: var(--g); border-color: var(--g); color: #fff; }
.gl-pagination .page-item.disabled .page-link { opacity: .45; }
.gl-pagination .page-link:focus { box-shadow: 0 0 0 .2rem rgba(18,130,63,.25); }

/* CTA */
.gl-cta-wrap { padding: 0; }
.gl-cta {
    position: relative; overflow: hidden; display: flex; align-items: center; gap: 1.8rem;
    padding: 2rem 3rem; border-radius: 28px 28px 0 0;
    background: linear-gradient(100deg, #eaf6ee 0%, #dcefd9 60%, #e8f5e0 100%);
}
.gl-cta > *:not(.gl-cta-leaf) { position: relative; z-index: 1; }
.gl-cta-icon { width: 74px; height: 74px; flex: 0 0 74px; display: block; }
.gl-cta-icon svg { width: 100%; height: 100%; }
.gl-cta-divider { width: 2px; align-self: stretch; background: var(--g); opacity: .5; }
.gl-cta-copy { flex: 1; }
.gl-cta h2 { color: var(--g-dark); font-size: clamp(1.4rem, 2.6vw, 1.9rem); font-weight: 700; margin-bottom: .25rem; }
.gl-cta p { color: var(--muted); margin: 0; }
.gl-btn-gold {
    display: inline-flex; align-items: center; gap: .5rem; white-space: nowrap; background: var(--gold); color: var(--ink);
    font-weight: 700; padding: .85rem 1.7rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,.12); transition: all .25s ease;
}
.gl-btn-gold:hover { background: #ffd34d; color: var(--ink); transform: translateY(-2px); }
.gl-cta-leaf { position: absolute; width: 90px; z-index: 0; }
.gl-cta-leaf path { fill: rgba(18,130,63,.15); stroke: rgba(18,130,63,.25); stroke-width: 2; }
.gl-cl-1 { left: -10px; bottom: -20px; transform: rotate(-30deg); }
.gl-cl-2 { right: -10px; top: -20px; transform: rotate(30deg); }

/* Lightbox */
.gl-lightbox {
    position: fixed; inset: 0; z-index: 2000; display: flex; align-items: center; justify-content: center;
    background: rgba(5,25,15,.92); padding: 60px 70px;
}
.gl-lightbox[hidden] { display: none; }
.gl-lightbox figure { margin: 0; max-width: 100%; max-height: 100%; text-align: center; }
.gl-lightbox img { max-width: 100%; max-height: calc(100vh - 160px); border-radius: 10px; box-shadow: 0 20px 60px rgba(0,0,0,.5); animation: gl-in .3s ease; }
.gl-lightbox figcaption { color: #fff; margin-top: 1rem; font-weight: 500; }
@keyframes gl-in { from { opacity: 0; transform: scale(.96); } to { opacity: 1; transform: none; } }
.gl-lb-btn {
    position: absolute; width: 48px; height: 48px; border-radius: 50%; border: 0; background: rgba(255,255,255,.12);
    color: #fff; font-size: 1.3rem; display: grid; place-items: center; transition: background .2s;
}
.gl-lb-btn:hover, .gl-lb-btn:focus-visible { background: var(--g); }
.gl-lb-close { top: 16px; right: 16px; }
.gl-lb-prev { left: 14px; top: 50%; transform: translateY(-50%); }
.gl-lb-next { right: 14px; top: 50%; transform: translateY(-50%); }

/* Responsive */
@media (max-width: 767.98px) {
    .gl-banner { padding: 56px 0 90px; }
    .gl-bl-2 { display: none; }
    .gl-bl-1 { width: 100px; right: -10px; }
    .gl-head-mark span { width: 60px; }
    .gl-filters { justify-content: flex-start; flex-wrap: nowrap; overflow-x: auto; padding-bottom: .4rem; scrollbar-width: none; }
    .gl-filters::-webkit-scrollbar { display: none; }
    .gl-filters button { flex: 0 0 auto; }
    .gl-cta { flex-direction: column; align-items: flex-start; gap: 1rem; padding: 1.8rem 1.4rem; }
    .gl-lightbox { padding: 60px 12px; }
    .gl-lb-prev, .gl-lb-next { top: auto; bottom: 14px; transform: none; }
    .gl-lb-prev { left: calc(50% - 60px); }
    .gl-lb-next { right: calc(50% - 60px); }
}
@media (max-width: 575.98px) {
    .gl-section .row { --bs-gutter-x: .8rem; --bs-gutter-y: .8rem; }
    .gl-card { padding: 4px; }
    .gl-card figcaption { font-size: .8rem; padding: .55rem .3rem .25rem; }
}
@media (prefers-reduced-motion: reduce) { .gl * { transition: none !important; animation: none !important; } }
</style>
@endpush
