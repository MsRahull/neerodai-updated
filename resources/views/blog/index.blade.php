@extends('user')

@section('title', __('Blog') . ' - ' . __('Neerodai Trust'))

@section('content')

@php
    // Optional banner photo. Leave null for the green leafy gradient.
    $bannerImage = null; // e.g. 'blog-banner.jpg' inside public/user/frontend/

    $leaf = '<path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/>';
@endphp

<div class="bl">

{{-- ================= BANNER ================= --}}
<section class="bl-banner" @if($bannerImage) style="background-image:url('{{ asset('user/frontend/' . $bannerImage) }}')" @endif>
    <div class="bl-banner-overlay"></div>
    <svg class="bl-banner-leaf bl-bl-1" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
    <svg class="bl-banner-leaf bl-bl-2" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>

    <div class="container bl-banner-content">
        <nav aria-label="breadcrumb" class="bl-crumb">
            <a href="{{ url('/') }}">{{ __('Home') }}</a> <i class="bi bi-chevron-right"></i> <span>{{ __('Blog') }}</span>
        </nav>
        <h1>{{ __('Our Blogs') }}</h1>
        <p>{{ __('Stories, Updates and Impact') }}</p>
        <span class="bl-gold-bar"></span>
    </div>

    <svg class="bl-banner-wave" viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true">
        <path class="w1" d="M0 30 C 400 0, 1000 60, 1440 10 L1440 60 L0 60 Z"/>
        <path class="w2" d="M0 42 C 420 10, 1000 70, 1440 25 L1440 60 L0 60 Z"/>
    </svg>
</section>

{{-- ================= BLOG LIST ================= --}}
<section class="bl-section">
    <div class="container">

        <div class="bl-head">
            <div class="bl-head-mark">
                <span></span>
                <svg viewBox="0 0 48 48" aria-hidden="true">
                    <circle cx="24" cy="10" r="5" fill="#12823f"/>
                    <path d="M24 44 C 24 34, 24 26, 24 18" stroke="#12823f" stroke-width="3" fill="none" stroke-linecap="round"/>
                    <path d="M24 30 C 14 30, 6 22, 5 13 C 15 13, 23 20, 24 30 Z" fill="#12823f"/>
                    <path d="M24 30 C 34 30, 42 22, 43 13 C 33 13, 25 20, 24 30 Z" fill="#12823f"/>
                </svg>
                <span></span>
            </div>
            <h2>{{ __('Latest Blogs') }}</h2>
            <p>{{ __('Read our latest stories and see the impact of our work in the community.') }}</p>
        </div>

        <div class="row g-4">
            @forelse($blogs as $blog)
                @php
                    $url     = route('blogs.show', $blog->slug);
                    $excerpt = \Illuminate\Support\Str::limit(trim(strip_tags($blog->display_short_description ?: $blog->display_content)), 120);
                @endphp
                <div class="col-sm-6 col-lg-4">
                    <article class="bl-card" lang="{{ $blog->shown_locale }}">
                        <a href="{{ $url }}" class="bl-card-img">
                            @if($blog->image_url)
                                <img src="{{ $blog->image_url }}" alt="{{ $blog->display_title }}" loading="lazy">
                            @else
                                <span class="bl-card-ph"><i class="bi bi-journal-heart"></i></span>
                            @endif
                            @if($blog->created_at)
                                <time class="bl-date" datetime="{{ $blog->created_at->toDateString() }}">
                                    <i class="bi bi-calendar3"></i> {{ $blog->created_at->format('M d, Y') }}
                                </time>
                            @endif
                        </a>
                        <div class="bl-card-body">
                            @if($blog->is_fallback)
                                <span class="bl-lang-note">
                                    <i class="bi bi-translate"></i>
                                    {{ $blog->shown_locale === 'ta' ? __('Available in Tamil only') : __('Available in English only') }}
                                </span>
                            @endif
                            <h3><a href="{{ $url }}">{{ $blog->display_title }}</a></h3>
                            @if($excerpt)
                                <p>{{ $excerpt }}</p>
                            @endif
                            <a href="{{ $url }}" class="bl-more">
                                <span class="bl-more-dot"><i class="bi bi-arrow-right"></i></span>
                                {{ __('Read More') }} <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="bl-empty">
                        <i class="bi bi-journal-heart"></i>
                        <p>{{ __('New stories will be shared here soon.') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($blogs->hasPages())
            <div class="bl-pagination">
                {{ $blogs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</section>

{{-- ================= CTA ================= --}}
<section class="bl-cta-wrap">
    <div class="container-fluid px-3 px-lg-4">
        <div class="bl-cta">
            <svg class="bl-cta-leaf bl-cl-1" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
            <svg class="bl-cta-leaf bl-cl-2" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
            <span class="bl-cta-icon" aria-hidden="true">
                <svg viewBox="0 0 64 64">
                    <path d="M32 26 C 32 26, 22 19, 22 13 C 22 9, 25 7, 28 7 C 30 7, 31.5 8.5, 32 10 C 32.5 8.5, 34 7, 36 7 C 39 7, 42 9, 42 13 C 42 19, 32 26, 32 26 Z" fill="#12823f"/>
                    <path d="M6 30 L 14 46 C 16 50, 20 54, 26 54 L 30 54 L 30 44 C 30 41, 28 38, 25 36 L 17 30 C 15 29, 13 30, 14 32 L 19 39" fill="none" stroke="#0b5e2d" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M58 30 L 50 46 C 48 50, 44 54, 38 54 L 34 54 L 34 44 C 34 41, 36 38, 39 36 L 47 30 C 49 29, 51 30, 50 32 L 45 39" fill="none" stroke="#0b5e2d" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <span class="bl-cta-divider d-none d-md-block"></span>
            <div class="bl-cta-copy">
                <h2>{{ __('Together for a Better Tomorrow') }}</h2>
                <p>{{ __('Your support helps us bring hope, care and dignity to the elderly.') }}</p>
            </div>
            <a href="{{ url('/pay') }}" class="bl-btn-gold"><i class="bi bi-heart-fill"></i> {{ __('Donate Now') }} <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>

</div>
@endsection

@push('styles')
<style>
.bl {
    --g: #12823f;
    --g-dark: #0b5e2d;
    --g-soft: #eaf6ee;
    --ink: #1d2b24;
    --muted: #55635c;
    --gold: #ffc61a;
    font-family: 'Poppins', 'Noto Sans Tamil', system-ui, sans-serif;
    color: var(--ink);
    background: #fff;
    overflow-x: hidden;
}
.bl a { text-decoration: none; }
.bl h1, .bl h2, .bl h3 { font-family: inherit; }

/* Banner */
.bl-banner {
    position: relative; overflow: hidden; padding: 80px 0 110px;
    background: radial-gradient(circle at 80% 30%, #3fa45b 0%, #12823f 35%, #0a4a26 100%);
    background-size: cover; background-position: center;
}
.bl-banner-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(8,59,31,.85) 0%, rgba(8,59,31,.55) 50%, rgba(8,59,31,.1) 100%); }
.bl-banner-content { position: relative; z-index: 2; }
.bl-crumb { font-size: .88rem; color: rgba(255,255,255,.8); margin-bottom: .8rem; }
.bl-crumb a { color: #fff; }
.bl-crumb a:hover { color: var(--gold); }
.bl-crumb i { font-size: .7rem; margin: 0 .35rem; }
.bl-banner h1 { color: #fff; font-size: clamp(2.6rem, 6vw, 4rem); font-weight: 800; margin-bottom: .4rem; }
.bl-banner p { color: rgba(255,255,255,.92); font-size: clamp(1.05rem, 2vw, 1.35rem); font-weight: 500; margin-bottom: 1rem; }
.bl-gold-bar { display: block; width: 80px; height: 5px; border-radius: 5px; background: var(--gold); }
.bl-banner-leaf { position: absolute; z-index: 1; }
.bl-banner-leaf path { fill: rgba(255,255,255,.1); stroke: rgba(255,255,255,.15); stroke-width: 2; }
.bl-bl-1 { right: 8%; top: 10px; width: 150px; transform: rotate(25deg); }
.bl-bl-2 { right: 24%; bottom: 20px; width: 80px; transform: rotate(-20deg); }
.bl-banner-wave { position: absolute; left: 0; bottom: -1px; width: 100%; height: 60px; z-index: 2; }
.bl-banner-wave .w1 { fill: #bfe3c7; }
.bl-banner-wave .w2 { fill: #fff; }

/* Section head */
.bl-section { padding: 50px 0 70px; }
.bl-head { text-align: center; margin-bottom: 2.6rem; }
.bl-head-mark { display: flex; align-items: center; justify-content: center; gap: .6rem; margin-bottom: .3rem; }
.bl-head-mark span { width: 150px; height: 3px; border-radius: 3px; background: #bfe0c8; }
.bl-head-mark svg { width: 46px; height: 46px; }
.bl-head h2 { font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 700; color: var(--g-dark); margin-bottom: .3rem; }
.bl-head p { color: var(--muted); font-size: 1.1rem; margin: 0; }

/* Cards */
.bl-card {
    height: 100%; display: flex; flex-direction: column; background: #fff; border-radius: 14px; overflow: hidden;
    border: 1px solid #e6efe8; box-shadow: 0 8px 26px rgba(10,74,38,.09); transition: transform .3s ease, box-shadow .3s ease;
}
.bl-card:hover { transform: translateY(-7px); box-shadow: 0 18px 40px rgba(10,74,38,.15); }
.bl-card-img { position: relative; display: block; aspect-ratio: 3 / 2; overflow: hidden; background: var(--g-soft); }
.bl-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
.bl-card:hover .bl-card-img img { transform: scale(1.06); }
.bl-card-ph { display: grid; place-items: center; height: 100%; font-size: 3rem; color: var(--g); }
.bl-date {
    position: absolute; top: 14px; left: 14px; display: inline-flex; align-items: center; gap: .4rem;
    background: var(--g-dark); color: #fff; font-size: .8rem; font-weight: 600; padding: .4rem .8rem; border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,.2);
}
.bl-card-body { padding: 1.4rem 1.4rem 1.5rem; display: flex; flex-direction: column; flex: 1; }
.bl-card-body h3 { font-size: 1.25rem; font-weight: 700; line-height: 1.35; margin-bottom: .7rem; }
.bl-card-body h3 a { color: var(--g-dark); }
.bl-card-body h3 a:hover { color: var(--g); }
.bl-card-body p { color: var(--muted); font-size: .95rem; line-height: 1.65; margin-bottom: 1.2rem; flex: 1; }
.bl-more { display: inline-flex; align-items: center; gap: .55rem; color: var(--g-dark); font-weight: 700; align-self: flex-start; }
.bl-more-dot { width: 24px; height: 24px; display: grid; place-items: center; border-radius: 50%; background: var(--g-dark); color: #fff; font-size: .8rem; }
.bl-more > .bi-arrow-right { transition: transform .2s ease; }
.bl-more:hover { color: var(--g); }
.bl-more:hover > .bi-arrow-right { transform: translateX(4px); }

.bl-card-body h3 { overflow-wrap: anywhere; }
.bl-lang-note {
    display: inline-flex; align-items: center; gap: .35rem; align-self: flex-start; margin-bottom: .6rem;
    font-size: .75rem; font-weight: 600; color: var(--g-dark); background: var(--g-soft); padding: .2rem .6rem; border-radius: 50px;
}
.bl [lang="ta"] h3, .bl [lang="ta"] p { line-height: 1.6; }
.bl-empty { text-align: center; color: var(--muted); padding: 3rem 1rem; }
.bl-empty i { font-size: 3rem; color: var(--g); }

/* Pagination */
.bl-pagination { display: flex; justify-content: center; margin-top: 2.8rem; }
.bl-pagination .pagination { gap: .4rem; margin: 0; flex-wrap: wrap; justify-content: center; }
.bl-pagination .page-link {
    min-width: 42px; height: 42px; display: grid; place-items: center; border-radius: 50% !important;
    border: 1.5px solid #cfe8d5; color: var(--g-dark); font-weight: 600;
}
.bl-pagination .page-link:hover { background: var(--g-soft); border-color: var(--g); color: var(--g-dark); }
.bl-pagination .page-item.active .page-link { background: var(--g); border-color: var(--g); color: #fff; }

/* CTA */
.bl-cta {
    position: relative; overflow: hidden; display: flex; align-items: center; gap: 1.8rem;
    padding: 2rem 3rem; border-radius: 28px 28px 0 0;
    background: linear-gradient(100deg, #eaf6ee 0%, #dcefd9 60%, #e8f5e0 100%);
}
.bl-cta > *:not(.bl-cta-leaf) { position: relative; z-index: 1; }
.bl-cta-icon { width: 74px; height: 74px; flex: 0 0 74px; display: block; }
.bl-cta-icon svg { width: 100%; height: 100%; }
.bl-cta-divider { width: 2px; align-self: stretch; background: var(--g); opacity: .5; }
.bl-cta-copy { flex: 1; }
.bl-cta h2 { color: var(--g-dark); font-size: clamp(1.4rem, 2.6vw, 1.9rem); font-weight: 700; margin-bottom: .25rem; }
.bl-cta p { color: var(--muted); margin: 0; }
.bl-btn-gold {
    display: inline-flex; align-items: center; gap: .5rem; white-space: nowrap; background: var(--gold); color: var(--ink);
    font-weight: 700; padding: .85rem 1.7rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,.12); transition: all .25s ease;
}
.bl-btn-gold:hover { background: #ffd34d; color: var(--ink); transform: translateY(-2px); }
.bl-cta-leaf { position: absolute; width: 90px; z-index: 0; }
.bl-cta-leaf path { fill: rgba(18,130,63,.15); stroke: rgba(18,130,63,.25); stroke-width: 2; }
.bl-cl-1 { left: -10px; bottom: -20px; transform: rotate(-30deg); }
.bl-cl-2 { right: -10px; top: -20px; transform: rotate(30deg); }

/* Responsive */
@media (max-width: 767.98px) {
    .bl-banner { padding: 56px 0 90px; }
    .bl-section { padding: 36px 0 50px; }
    .bl-btn-gold { width: 100%; justify-content: center; white-space: normal; }
    .bl-cta-icon { width: 56px; height: 56px; flex-basis: 56px; }
    .bl-bl-2 { display: none; }
    .bl-bl-1 { width: 100px; right: -10px; }
    .bl-head-mark span { width: 60px; }
    .bl-cta { flex-direction: column; align-items: flex-start; gap: 1rem; padding: 1.8rem 1.4rem; }
}
@media (prefers-reduced-motion: reduce) { .bl * { transition: none !important; } }
</style>
@endpush