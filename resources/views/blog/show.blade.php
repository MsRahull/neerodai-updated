@extends('user')

@section('title', $blog->display_title . ' - ' . __('Neerodai Trust'))

@php
    // Split on blank lines into paragraphs; single line breaks are kept inside a paragraph.
    $paragraphs = preg_split('/\R{2,}/', trim($blog->display_content)) ?: [];
    $otherLang  = $blog->shown_locale === 'ta' ? 'en' : 'ta';
    $hasOther   = $otherLang === 'ta' ? $blog->hasTamil() : $blog->hasEnglish();
@endphp

@section('content')
<div class="bs" lang="{{ $blog->shown_locale }}">
<section class="bs-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">

                <a href="{{ route('blogs.index') }}" class="bs-back">
                    <i class="bi bi-arrow-left"></i> {{ __('Back to Blogs') }}
                </a>

                <article class="bs-card">
                    @if($blog->image_url)
                        <img src="{{ $blog->image_url }}" class="bs-hero" alt="{{ $blog->display_title }}">
                    @endif

                    <div class="bs-body">
                        <div class="bs-meta">
                            <span><i class="bi bi-calendar3"></i> {{ $blog->created_at->translatedFormat('F d, Y') }}</span>

                            @if($hasOther)
                                <a href="{{ url('lang/' . $otherLang) }}" class="bs-lang-switch">
                                    <i class="bi bi-translate"></i>
                                    {{ $otherLang === 'ta' ? 'தமிழில் படிக்க' : 'Read in English' }}
                                </a>
                            @elseif($blog->is_fallback)
                                <span class="bs-lang-note">
                                    <i class="bi bi-translate"></i>
                                    {{ $blog->shown_locale === 'ta' ? __('Available in Tamil only') : __('Available in English only') }}
                                </span>
                            @endif
                        </div>

                        <h1 class="bs-title">{{ $blog->display_title }}</h1>

                        @if($blog->display_short_description)
                            <p class="bs-lead">{{ $blog->display_short_description }}</p>
                        @endif

                        <div class="bs-content">
                            @foreach($paragraphs as $p)
                                <p>{!! nl2br(e($p)) !!}</p>
                            @endforeach
                        </div>
                    </div>
                </article>

                @if($related->isNotEmpty())
                    <h2 class="bs-related-title">{{ __('More Stories') }}</h2>
                    <div class="row g-3">
                        @foreach($related as $r)
                            <div class="col-sm-6 col-md-4">
                                <a href="{{ route('blogs.show', $r->slug) }}" class="bs-related" lang="{{ $r->shown_locale }}">
                                    @if($r->image_url)
                                        <img src="{{ $r->image_url }}" alt="" loading="lazy">
                                    @endif
                                    <span>{{ $r->display_title }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil:wght@400;600;700&display=swap" rel="stylesheet">
<style>
.bs {
    --g: #12823f; --g-dark: #0b5e2d; --g-soft: #eaf6ee; --ink: #1d2b24; --muted: #55635c;
    font-family: 'Poppins', 'Noto Sans Tamil', system-ui, sans-serif;
    color: var(--ink); background: #f6faf7; overflow-x: hidden;
}
.bs[lang="ta"], .bs [lang="ta"] { font-family: 'Noto Sans Tamil', 'Poppins', system-ui, sans-serif; }
.bs a { text-decoration: none; }
.bs-section { padding: 40px 0 70px; }
.bs-back { display: inline-flex; align-items: center; gap: .4rem; color: var(--g-dark); font-weight: 600; margin-bottom: 1rem; }
.bs-back:hover { color: var(--g); }
.bs-card { background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 10px 30px rgba(10,74,38,.08); }
.bs-hero { width: 100%; aspect-ratio: 16 / 9; max-height: 460px; object-fit: cover; display: block; }
.bs-body { padding: 2rem 2.5rem 2.5rem; }
.bs-meta { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: .6rem; color: var(--muted); font-size: .9rem; margin-bottom: 1rem; }
.bs-lang-switch, .bs-lang-note {
    display: inline-flex; align-items: center; gap: .35rem; font-size: .85rem; font-weight: 600;
    color: var(--g-dark); background: var(--g-soft); padding: .3rem .8rem; border-radius: 50px;
}
.bs-lang-switch:hover { background: var(--g); color: #fff; }
.bs-title { font-size: clamp(1.6rem, 4vw, 2.4rem); font-weight: 800; color: var(--g-dark); line-height: 1.3; margin-bottom: 1rem; overflow-wrap: anywhere; }
.bs-lead { font-size: 1.12rem; color: var(--muted); border-left: 4px solid var(--g); padding-left: 1rem; margin-bottom: 1.6rem; }
.bs-content { font-size: 1.05rem; line-height: 1.9; overflow-wrap: anywhere; }
.bs-content p { margin-bottom: 1.1rem; }
.bs-related-title { font-size: 1.4rem; font-weight: 700; color: var(--g-dark); margin: 2.5rem 0 1rem; }
.bs-related { display: block; height: 100%; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 18px rgba(10,74,38,.07); color: var(--ink); transition: transform .25s ease; }
.bs-related:hover { transform: translateY(-4px); color: var(--g-dark); }
.bs-related img { width: 100%; aspect-ratio: 3 / 2; object-fit: cover; display: block; }
.bs-related span { display: block; padding: .8rem 1rem; font-weight: 600; line-height: 1.4; }
@media (max-width: 575.98px) {
    .bs-section { padding: 20px 0 50px; }
    .bs-body { padding: 1.25rem 1.1rem 1.6rem; }
    .bs-card { border-radius: 14px; }
    .bs-content { font-size: 1rem; line-height: 1.8; }
}
</style>
@endpush
