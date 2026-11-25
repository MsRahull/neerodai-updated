@extends('user')

@section('title', __('Videos') . ' - ' . __('Neerodai Trust'))
@section('meta_description', __('Watch videos of Neerodai Trust\'s work serving meals and care to elderly people.'))

@section('content')

@php
    $channelUrl = 'https://www.youtube.com/@NithiyamTv';

    // Pull the 11-character video ID out of any YouTube link (embed, watch, youtu.be, shorts).
    $ytId = function ($url) {
        if (preg_match('~(?:youtube(?:-nocookie)?\.com/(?:embed/|watch\?(?:.*&)?v=|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})~', (string) $url, $m)) {
            return $m[1];
        }
        return null;
    };

    $uploadedCount = $uploadedVideos->count();
    $youtubeCount  = $youtubeVideos->count();

    // Open the tab that actually has videos.
    $startTab = ($uploadedCount === 0 && $youtubeCount > 0) ? 'youtube' : 'uploaded';

    $leaf = '<path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/>';
@endphp

<div class="vd">

{{-- ================= BANNER ================= --}}
<section class="vd-banner">
    <div class="vd-banner-overlay"></div>
    <svg class="vd-banner-leaf vd-bl-1" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
    <svg class="vd-banner-leaf vd-bl-2" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
    <div class="container vd-banner-content">
        <nav aria-label="breadcrumb" class="vd-crumb">
            <a href="{{ url('/') }}">{{ __('Home') }}</a> <i class="bi bi-chevron-right"></i> <span>{{ __('Videos') }}</span>
        </nav>
        <h1>{{ __('Our Videos') }}</h1>
        <p>{{ __('Watch the moments of care, kindness and community') }}</p>
        <span class="vd-gold-bar"></span>
    </div>
    <svg class="vd-banner-wave" viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true">
        <path class="w1" d="M0 30 C 400 0, 1000 60, 1440 10 L1440 60 L0 60 Z"/>
        <path class="w2" d="M0 42 C 420 10, 1000 70, 1440 25 L1440 60 L0 60 Z"/>
    </svg>
</section>

{{-- ================= VIDEOS ================= --}}
<section class="vd-section">
    <div class="container">

        <div class="vd-head">
            <div class="vd-head-mark">
                <span></span>
                <i class="bi bi-play-circle-fill"></i>
                <span></span>
            </div>
            <h2>{{ __('Stories in Motion') }}</h2>
            <p>{{ __('See how your support brings meals, care and smiles to our elders.') }}</p>
        </div>

        {{-- Tabs --}}
        <ul class="nav vd-tabs" id="videoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $startTab === 'uploaded' ? 'active' : '' }}" id="uploaded-tab" data-bs-toggle="tab" data-bs-target="#uploaded"
                        type="button" role="tab" aria-controls="uploaded" aria-selected="{{ $startTab === 'uploaded' ? 'true' : 'false' }}">
                    <i class="bi bi-camera-video-fill"></i> {{ __('Videos') }}
                    <span class="vd-count">{{ $uploadedCount }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $startTab === 'youtube' ? 'active' : '' }}" id="youtube-tab" data-bs-toggle="tab" data-bs-target="#youtube"
                        type="button" role="tab" aria-controls="youtube" aria-selected="{{ $startTab === 'youtube' ? 'true' : 'false' }}">
                    <i class="bi bi-youtube"></i> {{ __('YouTube Videos') }}
                    <span class="vd-count">{{ $youtubeCount }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="videoTabsContent">

            {{-- Uploaded videos --}}
            <div class="tab-pane fade {{ $startTab === 'uploaded' ? 'show active' : '' }}" id="uploaded" role="tabpanel" aria-labelledby="uploaded-tab">
                @if($uploadedCount)
                    <div class="row g-4">
                        @foreach($uploadedVideos as $video)
                            <div class="col-md-6 col-lg-4">
                                <article class="vd-card">
                                    <div class="vd-media">
                                        <video controls preload="metadata" playsinline>
                                            <source src="{{ asset('uploads/videos/' . $video->video) }}#t=0.5" type="video/mp4">
                                            {{ __('Your browser does not support the video tag.') }}
                                        </video>
                                    </div>
                                    @if(!empty($video->title) || $video->created_at)
                                        <div class="vd-card-body">
                                            @if(!empty($video->title))
                                                <h3>{{ $video->title }}</h3>
                                            @endif
                                            @if($video->created_at)
                                                <span class="vd-date"><i class="bi bi-calendar3"></i> {{ $video->created_at->format('M d, Y') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </article>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="vd-empty">
                        <span class="vd-empty-icon"><i class="bi bi-camera-reels"></i></span>
                        <h3>{{ __('No uploaded videos yet') }}</h3>
                        <p>{{ __('New videos will be shared here soon. Meanwhile, watch us on YouTube.') }}</p>
                        @if($youtubeCount)
                            <button type="button" class="vd-btn vd-btn-green" onclick="bootstrap.Tab.getOrCreateInstance(document.getElementById('youtube-tab')).show()">
                                <i class="bi bi-youtube"></i> {{ __('See YouTube Videos') }}
                            </button>
                        @else
                            <a href="{{ $channelUrl }}" target="_blank" rel="noopener" class="vd-btn vd-btn-green"><i class="bi bi-youtube"></i> {{ __('Visit Our Channel') }}</a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- YouTube videos --}}
            <div class="tab-pane fade {{ $startTab === 'youtube' ? 'show active' : '' }}" id="youtube" role="tabpanel" aria-labelledby="youtube-tab">
                @if($youtubeCount)
                    <div class="row g-4">
                        @foreach($youtubeVideos as $video)
                            @php $id = $ytId($video->youtube_url); @endphp
                            <div class="col-md-6 col-lg-4">
                                <article class="vd-card">
                                    <div class="vd-media">
                                        @if($id)
                                            {{-- Light preview: the real player loads only on click (much faster page) --}}
                                            <button type="button" class="vd-yt" data-yt="{{ $id }}" aria-label="{{ __('Play video') }} {{ $video->title ?? '' }}">
                                                <img src="https://i.ytimg.com/vi/{{ $id }}/hqdefault.jpg" alt="{{ filled($video->title ?? null) ? $video->title : __('Neerodai Trust video') }}" loading="lazy">
                                                <span class="vd-play"><i class="bi bi-play-fill"></i></span>
                                            </button>
                                        @else
                                            <iframe src="{{ $video->youtube_url }}" title="{{ $video->title ?? 'YouTube video' }}" loading="lazy"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                        @endif
                                    </div>
                                    @if(!empty($video->title) || $video->created_at)
                                        <div class="vd-card-body">
                                            @if(!empty($video->title))
                                                <h3>{{ $video->title }}</h3>
                                            @endif
                                            @if($video->created_at)
                                                <span class="vd-date"><i class="bi bi-calendar3"></i> {{ $video->created_at->format('M d, Y') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </article>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="vd-empty">
                        <span class="vd-empty-icon"><i class="bi bi-youtube"></i></span>
                        <h3>{{ __('No YouTube videos yet') }}</h3>
                        <p>{{ __('Visit our channel to watch our latest videos.') }}</p>
                        <a href="{{ $channelUrl }}" target="_blank" rel="noopener" class="vd-btn vd-btn-green"><i class="bi bi-youtube"></i> {{ __('Visit Our Channel') }}</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Subscribe strip --}}
        <div class="vd-subscribe">
            <span class="vd-sub-icon"><i class="bi bi-youtube"></i></span>
            <div class="flex-grow-1">
                <h3>{{ __('Watch more on YouTube') }}</h3>
                <p>{{ __('Subscribe to our channel and share our videos with your friends and family.') }}</p>
            </div>
            <a href="{{ $channelUrl }}?sub_confirmation=1" target="_blank" rel="noopener" class="vd-btn vd-btn-red">
                <i class="bi bi-youtube"></i> {{ __('Subscribe') }}
            </a>
        </div>
    </div>
</section>

{{-- ================= CTA ================= --}}
<section class="vd-cta-wrap">
    <div class="container-fluid px-3 px-lg-4">
        <div class="vd-cta">
            <svg class="vd-cta-leaf vd-cl-1" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
            <svg class="vd-cta-leaf vd-cl-2" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
            <span class="vd-cta-icon"><i class="bi bi-heart-fill"></i></span>
            <span class="vd-cta-divider d-none d-md-block"></span>
            <div class="vd-cta-copy">
                <h2>{{ __('Together for a Better Tomorrow') }}</h2>
                <p>{{ __('Your support helps us bring hope, care and dignity to the elderly.') }}</p>
            </div>
            <a href="{{ url('/pay') }}" class="vd-btn-gold"><i class="bi bi-heart-fill"></i> {{ __('Donate Now') }} <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Load the YouTube player only when a preview is clicked
    document.querySelectorAll('.vd-yt').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var media = btn.parentElement;
            media.innerHTML = '<iframe src="https://www.youtube-nocookie.com/embed/' + btn.dataset.yt +
                '?autoplay=1&rel=0" title="YouTube video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
        });
    });

    // Pause everything that's playing when switching tabs
    document.querySelectorAll('#videoTabs button').forEach(function (tab) {
        tab.addEventListener('hide.bs.tab', function () {
            document.querySelectorAll('.vd video').forEach(function (v) { v.pause(); });
        });
    });

    // Only one uploaded video plays at a time
    document.querySelectorAll('.vd video').forEach(function (v) {
        v.addEventListener('play', function () {
            document.querySelectorAll('.vd video').forEach(function (o) { if (o !== v) o.pause(); });
        });
    });
});
</script>

@endsection

@push('styles')
<style>
.vd {
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
.vd a { text-decoration: none; }
.vd h1, .vd h2, .vd h3 { font-family: inherit; }

/* Banner */
.vd-banner {
    position: relative; overflow: hidden; padding: 80px 0 110px;
    background: radial-gradient(circle at 80% 30%, #3fa45b 0%, #12823f 35%, #0a4a26 100%);
}
.vd-banner-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(8,59,31,.85) 0%, rgba(8,59,31,.55) 50%, rgba(8,59,31,.1) 100%); }
.vd-banner-content { position: relative; z-index: 2; }
.vd-crumb { font-size: .88rem; color: rgba(255,255,255,.8); margin-bottom: .8rem; }
.vd-crumb a { color: #fff; }
.vd-crumb a:hover { color: var(--gold); }
.vd-crumb i { font-size: .7rem; margin: 0 .35rem; }
.vd-banner h1 { color: #fff; font-size: clamp(2.6rem, 6vw, 4rem); font-weight: 800; margin-bottom: .4rem; }
.vd-banner p { color: rgba(255,255,255,.92); font-size: clamp(1.05rem, 2vw, 1.3rem); font-weight: 500; margin-bottom: 1rem; }
.vd-gold-bar { display: block; width: 80px; height: 5px; border-radius: 5px; background: var(--gold); }
.vd-banner-leaf { position: absolute; z-index: 1; }
.vd-banner-leaf path { fill: rgba(255,255,255,.1); stroke: rgba(255,255,255,.15); stroke-width: 2; }
.vd-bl-1 { right: 8%; top: 10px; width: 150px; transform: rotate(25deg); }
.vd-bl-2 { right: 24%; bottom: 20px; width: 80px; transform: rotate(-20deg); }
.vd-banner-wave { position: absolute; left: 0; bottom: -1px; width: 100%; height: 60px; z-index: 2; }
.vd-banner-wave .w1 { fill: #bfe3c7; }
.vd-banner-wave .w2 { fill: #fff; }

/* Head */
.vd-section { padding: 50px 0 60px; }
.vd-head { text-align: center; margin-bottom: 1.8rem; }
.vd-head-mark { display: flex; align-items: center; justify-content: center; gap: .7rem; margin-bottom: .3rem; }
.vd-head-mark span { width: 120px; height: 3px; border-radius: 3px; background: #cfe8d5; }
.vd-head-mark i { font-size: 2.2rem; color: var(--g); }
.vd-head h2 { font-size: clamp(2rem, 4vw, 2.7rem); font-weight: 700; color: var(--g-dark); margin-bottom: .3rem; }
.vd-head p { color: var(--muted); font-size: 1.08rem; margin: 0; }

/* Tabs */
.vd-tabs { justify-content: center; gap: .5rem; padding: 6px; margin: 0 auto 2.4rem; width: fit-content; max-width: 100%; background: var(--g-soft); border-radius: 50px; }
.vd-tabs .nav-link {
    display: inline-flex; align-items: center; gap: .5rem; border: 0; border-radius: 50px; padding: .7rem 1.4rem;
    color: var(--g-dark); font-weight: 600; background: transparent; transition: all .2s ease;
}
.vd-tabs .nav-link:hover { color: var(--g); background: rgba(255,255,255,.7); }
.vd-tabs .nav-link.active { background: var(--g); color: #fff; box-shadow: 0 6px 16px rgba(18,130,63,.3); }
.vd-tabs .bi-youtube { color: #e62117; }
.vd-tabs .nav-link.active .bi-youtube { color: #fff; }
.vd-count { min-width: 24px; height: 24px; padding: 0 6px; display: inline-grid; place-items: center; border-radius: 12px; background: #fff; color: var(--g-dark); font-size: .75rem; font-weight: 700; }
.vd-tabs .nav-link.active .vd-count { background: rgba(255,255,255,.22); color: #fff; }

/* Cards */
.vd-card { height: 100%; background: #fff; border-radius: 16px; overflow: hidden; border: 1px solid #e6efe8; box-shadow: 0 8px 26px rgba(10,74,38,.09); transition: transform .3s ease, box-shadow .3s ease; }
.vd-card:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(10,74,38,.15); }
.vd-media { position: relative; aspect-ratio: 16 / 9; background: #0d1f16; }
.vd-media video, .vd-media iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; object-fit: cover; background: #0d1f16; }
.vd-yt { position: absolute; inset: 0; width: 100%; padding: 0; border: 0; background: none; cursor: pointer; }
.vd-yt img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease, opacity .3s; opacity: .9; }
.vd-yt::after { content: ""; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0) 50%, rgba(0,0,0,.35)); }
.vd-card:hover .vd-yt img { transform: scale(1.05); opacity: 1; }
.vd-play {
    position: absolute; z-index: 1; left: 50%; top: 50%; transform: translate(-50%, -50%); width: 68px; height: 68px; border-radius: 50%;
    background: var(--g); color: #fff; display: grid; place-items: center; font-size: 2rem;
    box-shadow: 0 0 0 10px rgba(255,255,255,.25); transition: transform .25s, background .25s;
}
.vd-yt:hover .vd-play, .vd-yt:focus-visible .vd-play { transform: translate(-50%, -50%) scale(1.1); background: var(--gold); color: var(--ink); }
.vd-card-body { padding: 1rem 1.2rem 1.2rem; }
.vd-card-body h3 { font-size: 1.05rem; font-weight: 600; line-height: 1.4; margin-bottom: .35rem; }
.vd-date { font-size: .8rem; color: var(--muted); display: inline-flex; align-items: center; gap: .35rem; }
.vd-date i { color: var(--g); }

/* Empty */
.vd-empty { max-width: 520px; margin: 0 auto; text-align: center; padding: 3rem 1.5rem; border: 2px dashed #cfe8d5; border-radius: 20px; background: #f8fcf9; }
.vd-empty-icon { width: 80px; height: 80px; margin: 0 auto 1rem; border-radius: 50%; display: grid; place-items: center; background: var(--g-soft); color: var(--g); font-size: 2.2rem; }
.vd-empty h3 { font-size: 1.3rem; font-weight: 700; color: var(--g-dark); margin-bottom: .4rem; }
.vd-empty p { color: var(--muted); margin-bottom: 1.3rem; }

/* Buttons */
.vd-btn { display: inline-flex; align-items: center; gap: .5rem; border: 0; border-radius: 50px; padding: .75rem 1.5rem; font-weight: 600; transition: all .2s ease; white-space: nowrap; }
.vd-btn-green { background: var(--g); color: #fff; box-shadow: 0 8px 18px rgba(18,130,63,.25); }
.vd-btn-green:hover { background: var(--g-dark); color: #fff; transform: translateY(-2px); }
.vd-btn-red { background: #e62117; color: #fff; box-shadow: 0 8px 18px rgba(230,33,23,.25); }
.vd-btn-red:hover { background: #c4170f; color: #fff; transform: translateY(-2px); }

/* Subscribe strip */
.vd-subscribe { display: flex; align-items: center; gap: 1.3rem; margin-top: 3rem; padding: 1.4rem 1.8rem; border-radius: 18px; background: #fff; border: 1px solid #e6efe8; box-shadow: 0 8px 26px rgba(10,74,38,.07); }
.vd-sub-icon { width: 60px; height: 60px; flex: 0 0 60px; border-radius: 16px; background: #fdecea; color: #e62117; display: grid; place-items: center; font-size: 1.9rem; }
.vd-subscribe h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: .2rem; }
.vd-subscribe p { color: var(--muted); margin: 0; font-size: .93rem; }

/* CTA */
.vd-cta {
    position: relative; overflow: hidden; display: flex; align-items: center; gap: 1.8rem;
    padding: 2rem 3rem; border-radius: 28px 28px 0 0;
    background: linear-gradient(100deg, #eaf6ee 0%, #dcefd9 60%, #e8f5e0 100%);
}
.vd-cta > *:not(.vd-cta-leaf) { position: relative; z-index: 1; }
.vd-cta-icon { width: 70px; height: 70px; flex: 0 0 70px; border-radius: 50%; background: #fff; color: var(--g); display: grid; place-items: center; font-size: 2rem; box-shadow: 0 8px 18px rgba(18,130,63,.15); }
.vd-cta-divider { width: 2px; align-self: stretch; background: var(--g); opacity: .5; }
.vd-cta-copy { flex: 1; }
.vd-cta h2 { color: var(--g-dark); font-size: clamp(1.4rem, 2.6vw, 1.9rem); font-weight: 700; margin-bottom: .25rem; }
.vd-cta p { color: var(--muted); margin: 0; }
.vd-btn-gold {
    display: inline-flex; align-items: center; gap: .5rem; white-space: nowrap; background: var(--gold); color: var(--ink);
    font-weight: 700; padding: .85rem 1.7rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,.12); transition: all .25s ease;
}
.vd-btn-gold:hover { background: #ffd34d; color: var(--ink); transform: translateY(-2px); }
.vd-cta-leaf { position: absolute; width: 90px; z-index: 0; }
.vd-cta-leaf path { fill: rgba(18,130,63,.15); stroke: rgba(18,130,63,.25); stroke-width: 2; }
.vd-cl-1 { left: -10px; bottom: -20px; transform: rotate(-30deg); }
.vd-cl-2 { right: -10px; top: -20px; transform: rotate(30deg); }

/* Responsive */
@media (max-width: 767.98px) {
    .vd-banner { padding: 56px 0 90px; }
    .vd-bl-2 { display: none; }
    .vd-bl-1 { width: 100px; right: -10px; }
    .vd-head-mark span { width: 60px; }
    .vd-tabs { width: 100%; flex-wrap: nowrap; }
    .vd-tabs .nav-item { flex: 1; }
    .vd-tabs .nav-link { width: 100%; justify-content: center; padding: .65rem .6rem; font-size: .88rem; }
    .vd-subscribe { flex-direction: column; text-align: center; padding: 1.6rem 1.2rem; }
    .vd-cta { flex-direction: column; align-items: flex-start; gap: 1rem; padding: 1.8rem 1.4rem; }
}
@media (prefers-reduced-motion: reduce) { .vd * { transition: none !important; } }
</style>
@endpush
