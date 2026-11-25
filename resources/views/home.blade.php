@extends('user')

@section('title', __('Neerodai Trust') . ' | ' . __('Care. Dignity. Hope.'))

@section('content')

@php
    /* ---------- EDIT THESE ---------- */
    // Hero slides: wide, bright photos work best (main subject on the right side).
    $heroSlides = [
        [
            'image'  => 'SLIDER1.jpg',
            'kicker' => __('Neerodai Trust'),
            'title'  => __('Care. Dignity. Hope.'),
            'desc'   => __('Supporting our elders with love and compassion every day.'),
            'btn1'   => ['label' => __('Donate Now'), 'url' => url('/pay')],
            'btn2'   => ['label' => __('Our Activities'), 'url' => '#activities'],
        ],
        [
            'image'  => 'SLIDER2.jpg',
            'kicker' => __('Together We Can'),
            'title'  => __('Make a Difference.'),
            'desc'   => __('Every act of kindness creates a safer, happier life for our elders.'),
            'btn1'   => ['label' => __('Donate Now'), 'url' => url('/pay')],
            'btn2'   => ['label' => __('View Gallery'), 'url' => url('/gallery')],
        ],
        [
            'image'  => 'SLIDER3.jpg',
            'kicker' => __('A Little Care'),
            'title'  => __('Means a Lot.'),
            'desc'   => __('Join our community in sharing food, care and companionship.'),
            'btn1'   => ['label' => __('Donate Now'), 'url' => url('/pay')],
            'btn2'   => ['label' => __('Contact Us'), 'url' => url('/contact')],
        ],
    ];

    // Use your REAL numbers here.
    $stats = [
        ['icon' => 'bi-people-fill',        'value' => '15+',     'label' => __('Years of Service')],
        ['icon' => 'bi-person-hearts',      'value' => '1000+',   'label' => __('Elderly People Supported')],
        ['icon' => 'bi-egg-fried',          'value' => '50,000+', 'label' => __('Meals Served')],
        ['icon' => 'bi-hand-thumbs-up-fill','value' => __('Many'), 'label' => __('Community Activities')],
    ];

    $activities = [
        ['title' => __('Food Support'), 'desc' => __('Nutritious meals for a healthy life'),  'image' => 'happymoment1.jpg', 'icon' => 'bi-basket2-fill'],
        ['title' => __('Medical Care'), 'desc' => __('Healthcare support & counselling'),     'image' => 'happymoment2.jpg', 'icon' => 'bi-plus-circle-fill'],
        ['title' => __('Emotional Support'), 'desc' => __('Companionship & care'),                 'image' => 'happymoment3.jpg', 'icon' => 'bi-heart-fill'],
        ['title' => __('Community Assistance'), 'desc' => __('Shelter and basic needs'),              'image' => 'SLIDER2.jpg',      'icon' => 'bi-people-fill'],
    ];

    $youtubeId = 'NWney1SCKwE';
@endphp

<div class="nt">

{{-- ================= HERO ================= --}}
<section class="nt-hero">
    <div id="ntHero" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000" data-bs-pause="hover">
        <div class="carousel-indicators nt-hero-dots">
            @foreach($heroSlides as $i => $s)
                <button type="button" data-bs-target="#ntHero" data-bs-slide-to="{{ $i }}"
                    class="@if($i === 0) active @endif" @if($i === 0) aria-current="true" @endif
                    aria-label="Slide {{ $i + 1 }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach($heroSlides as $i => $s)
                <div class="carousel-item @if($i === 0) active @endif">
                    <div class="nt-hero-slide">
                        <div class="nt-hero-img" style="background-image:url('{{ asset('user/frontend/' . $s['image']) }}')"></div>
                        <div class="nt-hero-fade"></div>
                        <div class="container nt-hero-content">
                            <div class="col-lg-6 col-xl-5 px-0">
                                @if($i === 0)
                                    <h1><span class="nt-green">{{ $s['kicker'] }}</span>{{ $s['title'] }}</h1>
                                @else
                                    <h2 class="nt-hero-h"><span class="nt-green">{{ $s['kicker'] }}</span>{{ $s['title'] }}</h2>
                                @endif
                                <p>{{ $s['desc'] }}</p>
                                <div class="d-flex flex-wrap gap-3 nt-hero-btns">
                                    <a href="{{ $s['btn1']['url'] }}" class="nt-btn nt-btn-green"><i class="bi bi-heart-fill"></i> {{ $s['btn1']['label'] }}</a>
                                    <a href="{{ $s['btn2']['url'] }}" class="nt-btn nt-btn-outline">{{ $s['btn2']['label'] }} <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev nt-hero-ctrl" type="button" data-bs-target="#ntHero" data-bs-slide="prev" aria-label="Previous slide">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="carousel-control-next nt-hero-ctrl" type="button" data-bs-target="#ntHero" data-bs-slide="next" aria-label="Next slide">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <svg class="nt-leaf nt-leaf-hero" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>

    <svg class="nt-hero-wave" viewBox="0 0 1440 90" preserveAspectRatio="none" aria-hidden="true">
        <path class="w1" d="M0 60 C 360 10, 900 110, 1440 20 L1440 90 L0 90 Z"/>
        <path class="w2" d="M0 75 C 400 35, 950 115, 1440 45 L1440 90 L0 90 Z"/>
    </svg>
</section>

{{-- ================= STATS ================= --}}
<section class="nt-stats">
    <div class="container">
        <div class="row g-0">
            @foreach($stats as $s)
                <div class="col-6 col-lg-3">
                    <div class="nt-stat">
                        <i class="bi {{ $s['icon'] }}"></i>
                        <div>
                            <strong>{{ $s['value'] }}</strong>
                            <span>{{ $s['label'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= ACTIVITIES ================= --}}
<section class="nt-section" id="activities">
    <div class="container">
        <div class="nt-heading">
            <h2><span class="nt-line"></span>{{ __('Our Activities') }}<span class="nt-line"></span></h2>
            <p>{{ __('We are committed to the well-being of our senior citizens') }}</p>
        </div>
        <div class="row g-4">
            @foreach($activities as $a)
                <div class="col-sm-6 col-lg-3">
                    <article class="nt-act">
                        <div class="nt-act-img">
                            <img src="{{ asset('user/frontend/' . $a['image']) }}" alt="{{ $a['title'] }}" loading="lazy">
                            <span class="nt-act-icon"><i class="bi {{ $a['icon'] }}"></i></span>
                        </div>
                        <div class="nt-act-body">
                            <h3>{{ $a['title'] }}</h3>
                            <p>{{ $a['desc'] }}</p>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= ABOUT ================= --}}
<section class="nt-section nt-about pt-0" id="about">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <div class="nt-about-img">
                    <img src="{{ asset('user/frontend/SLIDER2.jpg') }}" alt="{{ __('Neerodai Trust event with elders') }}" loading="lazy">
                </div>
            </div>
            <div class="col-lg-4 col-md-7">
                <span class="nt-label">{{ __('About Neerodai Trust') }} <span class="nt-line"></span></span>
                <h2 class="nt-title">{{ __('A Trust for a Better Tomorrow') }}</h2>
                <p class="nt-text">
                    {{ __('Neerodai Trust is dedicated to improving the lives of elderly people who are alone, vulnerable, and in need of love and care. For over 15 years, we have been providing food, shelter, and emotional support for senior citizens.') }}
                </p>
                <a href="{{ url('/about') }}" class="nt-btn nt-btn-green nt-btn-sm">{{ __('Learn More') }} <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="col-lg-3 col-md-5">
                <div class="nt-quote">
                    <i class="bi bi-quote nt-quote-mark"></i>
                    <p>{{ __('Together, we can bring smiles and hope to our elders.') }}</p>
                    <i class="bi bi-flower3 nt-quote-icon"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= MISSION BANNER ================= --}}
<section class="nt-mission" style="background-image:url('{{ asset('user/frontend/SLIDER3.jpg') }}')">
    <div class="nt-mission-overlay"></div>
    <div class="container nt-mission-inner">
        <button type="button" class="nt-play" data-bs-toggle="modal" data-bs-target="#missionVideo" aria-label="{{ __('Play mission video') }}">
            <i class="bi bi-play-fill"></i>
        </button>
        <div class="nt-mission-copy">
            <span class="nt-mission-label">{{ __('Our Mission') }} <span class="nt-line"></span></span>
            <h2>{!! nl2br(e(__("Don't Waste
Food"))) !!}</h2>
            <p>{{ __("Let's share and care for those in need.") }}</p>
        </div>
        <button type="button" class="nt-btn nt-btn-green" data-bs-toggle="modal" data-bs-target="#missionVideo">
            {{ __('Watch Our Mission') }} <i class="bi bi-play-fill"></i>
        </button>
    </div>
</section>

{{-- ================= GALLERY + BLOG ================= --}}
<section class="nt-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 nt-split">
                <div class="nt-row-head">
                    <h2>{{ __('Our Impact Gallery') }}</h2>
                    <a href="{{ url('/gallery') }}" class="nt-pill">{{ __('View All Photos') }} <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="row g-3">
                    @foreach(['happymoment1.jpg', 'happymoment2.jpg', 'happymoment3.jpg'] as $img)
                        <div class="col-4">
                            <a href="{{ url('/gallery') }}" class="nt-gal">
                                <img src="{{ asset('user/frontend/' . $img) }}" alt="{{ __('Neerodai Trust activity') }}" loading="lazy">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-7">
                <div class="nt-row-head">
                    <h2>{{ __('From Our Blog') }}</h2>
                    <a href="{{ route('blogs.index') }}" class="nt-pill">{{ __('View All Blogs') }} <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="row g-3">
                    @forelse($blogs as $b)
                        @if($loop->iteration > 3) @break @endif
                        <div class="col-sm-4">
                            <article class="nt-blog">
                                <a href="{{ route('blogs.show', $b->slug) }}" class="nt-blog-img">
                                    @if($b->image_url)
                                        <img src="{{ $b->image_url }}" alt="{{ $b->display_title }}" loading="lazy">
                                    @else
                                        <span><i class="bi bi-journal-text"></i></span>
                                    @endif
                                </a>
                                <div class="nt-blog-body">
                                    <h3 lang="{{ $b->shown_locale }}"><a href="{{ route('blogs.show', $b->slug) }}">{{ $b->display_title }}</a></h3>
                                    <a href="{{ route('blogs.show', $b->slug) }}" class="nt-more">{{ __('Read More') }} <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12"><p class="nt-text mb-0">{{ __('New stories will be shared here soon.') }}</p></div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= DONATE CTA ================= --}}
<section class="nt-cta">
    <svg class="nt-cta-wave" viewBox="0 0 1440 40" preserveAspectRatio="none" aria-hidden="true"><path d="M0 40 C 480 0, 960 0, 1440 40 Z"/></svg>
    <svg class="nt-leaf nt-leaf-cta" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>
    <div class="container nt-cta-inner">
        <i class="bi bi-heart nt-cta-heart"></i>
        <div class="flex-grow-1">
            <h2>{{ __('Your Kindness Brings Hope') }}</h2>
            <p>{{ __("Together, let's make a difference in the lives of our elders.") }}</p>
        </div>
        <a href="{{ url('/pay') }}" class="nt-btn nt-btn-gold">{{ __('Donate Now') }} <i class="bi bi-arrow-right"></i></a>
    </div>
</section>

{{-- Video modal --}}
<div class="modal fade" id="missionVideo" tabindex="-1" aria-label="Mission video" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-black border-0">
            <button type="button" class="btn-close btn-close-white nt-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="ratio ratio-16x9" id="missionVideoFrame" data-yt="{{ $youtubeId }}"></div>
        </div>
    </div>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('missionVideo');
    var frame = document.getElementById('missionVideoFrame');
    if (!modal || !frame) return;
    modal.addEventListener('shown.bs.modal', function () {
        frame.innerHTML = '<iframe src="https://www.youtube-nocookie.com/embed/' + frame.dataset.yt +
            '?autoplay=1&rel=0" title="Neerodai Trust mission video" allow="autoplay; encrypted-media; picture-in-picture; web-share" allowfullscreen></iframe>';
    });
    modal.addEventListener('hidden.bs.modal', function () { frame.innerHTML = ''; });
});
</script>

@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Tamil:wght@400;600;700&display=swap" rel="stylesheet">
<style>
.nt {
    --green: #12823f;
    --green-dark: #0b5e2d;
    --green-deep: #0a4a26;
    --green-soft: #eaf6ee;
    --ink: #1d2b24;
    --muted: #5d6b64;
    --gold: #ffc61a;
    font-family: 'Poppins', 'Noto Sans Tamil', system-ui, sans-serif;
    color: var(--ink);
    overflow-x: hidden;
}
.nt a { text-decoration: none; }
.nt h1, .nt h2, .nt h3 { font-family: inherit; }
.nt-green { color: var(--green); }
.nt-line { display: inline-block; width: 50px; height: 2px; background: var(--green); vertical-align: middle; }

/* Buttons */
.nt-btn {
    display: inline-flex; align-items: center; gap: .55rem; padding: .85rem 1.7rem; border-radius: 50px;
    font-weight: 600; border: 2px solid transparent; transition: all .25s ease; cursor: pointer;
}
.nt-btn-sm { padding: .65rem 1.3rem; font-size: .92rem; }
.nt-btn-green { background: var(--green); color: #fff; box-shadow: 0 8px 20px rgba(18,130,63,.25); }
.nt-btn-green:hover { background: var(--green-dark); color: #fff; transform: translateY(-2px); }
.nt-btn-outline { border-color: var(--green); color: var(--green-dark); background: rgba(255,255,255,.85); }
.nt-btn-outline:hover { background: var(--green); color: #fff; }
.nt-btn-gold { background: var(--gold); color: var(--ink); font-weight: 700; padding: .95rem 2rem; box-shadow: 0 8px 20px rgba(0,0,0,.15); }
.nt-btn-gold:hover { background: #ffd34d; color: var(--ink); transform: translateY(-2px); }

/* HERO */
.nt-hero { position: relative; overflow: hidden; background: #fff; }
.nt-hero-slide { position: relative; min-height: 560px; display: flex; align-items: center; overflow: hidden; }
.nt-hero-img { position: absolute; top: 0; right: 0; bottom: 0; width: 68%; background-size: cover; background-position: center; transform: scale(1.08); transition: transform 7s ease-out; }
.carousel-item.active .nt-hero-img { transform: scale(1); }
.nt-hero-h { font-size: clamp(2.4rem, 4.6vw, 3.6rem); font-weight: 700; line-height: 1.12; color: var(--ink); margin-bottom: 1rem; }
.nt-hero-h .nt-green { display: block; }

/* text slides up when a slide becomes active */
.nt-hero-content h1, .nt-hero-content .nt-hero-h, .nt-hero-content p, .nt-hero-btns { opacity: 0; transform: translateY(25px); transition: opacity .7s ease, transform .7s ease; }
.carousel-item.active .nt-hero-content h1,
.carousel-item.active .nt-hero-content .nt-hero-h { opacity: 1; transform: none; transition-delay: .2s; }
.carousel-item.active .nt-hero-content p { opacity: 1; transform: none; transition-delay: .4s; }
.carousel-item.active .nt-hero-btns { opacity: 1; transform: none; transition-delay: .6s; }

/* dots + arrows */
.nt-hero-dots { z-index: 4; margin-bottom: 70px; }
.nt-hero-dots [data-bs-target] { width: 12px; height: 12px; border-radius: 50%; border: 2px solid var(--green); background: #fff; opacity: 1; margin: 0 5px; transition: all .3s; }
.nt-hero-dots .active { width: 32px; border-radius: 10px; background: var(--green); }
.nt-hero-ctrl { width: 52px; height: 52px; top: 50%; transform: translateY(-50%); bottom: auto; margin: 0 18px; border-radius: 50%; background: rgba(255,255,255,.9); color: var(--green-dark); font-size: 1.3rem; opacity: 0; box-shadow: 0 6px 18px rgba(0,0,0,.15); transition: opacity .3s, background .3s; z-index: 4; }
.nt-hero:hover .nt-hero-ctrl { opacity: 1; }
.nt-hero-ctrl:hover, .nt-hero-ctrl:focus { background: var(--green); color: #fff; opacity: 1; }
.nt-hero-fade {
    position: absolute; inset: 0;
    background: linear-gradient(90deg, #fff 0%, #fff 32%, rgba(255,255,255,.85) 42%, rgba(255,255,255,0) 62%);
}
.nt-hero-content { position: relative; z-index: 2; padding-top: 60px; padding-bottom: 120px; }
.nt-hero h1 { font-size: clamp(2.4rem, 4.6vw, 3.6rem); font-weight: 700; line-height: 1.12; color: var(--ink); margin-bottom: 1rem; }
.nt-hero h1 .nt-green { display: block; }
.nt-hero p { font-size: 1.2rem; color: #33413a; max-width: 440px; margin-bottom: 1.8rem; }
.nt-hero-wave { position: absolute; left: 0; bottom: -1px; width: 100%; height: 90px; z-index: 3; }
.nt-hero-wave .w1 { fill: var(--green); }
.nt-hero-wave .w2 { fill: var(--green-soft); }
.nt-leaf path { fill: rgba(18,130,63,.12); stroke: rgba(18,130,63,.2); stroke-width: 2; }
.nt-leaf-hero { position: absolute; left: -20px; bottom: 60px; width: 90px; z-index: 1; transform: rotate(-15deg); }

/* STATS */
.nt-stats { background: var(--green-soft); padding: 26px 0 34px; border-radius: 0 0 40px 40px; }
.nt-stat { display: flex; align-items: center; justify-content: center; gap: 1rem; padding: .8rem; }
.nt-col-sep { border-right: 1px solid rgba(18,130,63,.15); }
.nt-stats .col-lg-3:not(:last-child) .nt-stat { border-right: 1px solid rgba(18,130,63,.15); }
.nt-stat i { font-size: 2.6rem; color: var(--green); }
.nt-stat strong { display: block; font-size: 1.8rem; font-weight: 700; color: var(--green-dark); line-height: 1.1; }
.nt-stat span { font-size: .9rem; color: #33413a; }

/* SECTIONS */
.nt-section { padding: 70px 0; }
.nt-heading { text-align: center; margin-bottom: 2.2rem; }
.nt-heading h2 { font-size: 2rem; font-weight: 700; color: var(--green-dark); display: inline-flex; align-items: center; gap: 1rem; margin-bottom: .3rem; }
.nt-heading p { color: #33413a; margin: 0; }
.nt-title { font-size: 1.9rem; font-weight: 700; margin: .3rem 0 1rem; }
.nt-label { color: var(--green); font-weight: 600; font-size: 1.05rem; display: inline-flex; align-items: center; gap: .8rem; }
.nt-text { color: #44524b; font-size: .95rem; line-height: 1.8; margin-bottom: 1.4rem; }

/* ACTIVITIES */
.nt-act { height: 100%; background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 6px 22px rgba(0,0,0,.08); transition: transform .3s, box-shadow .3s; }
.nt-act:hover { transform: translateY(-6px); box-shadow: 0 14px 32px rgba(0,0,0,.12); }
.nt-act-img { position: relative; height: 170px; }
.nt-act-img img { width: 100%; height: 100%; object-fit: cover; }
.nt-act-icon {
    position: absolute; left: 14px; bottom: -24px; width: 50px; height: 50px; border-radius: 50%;
    background: var(--green); color: #fff; display: grid; place-items: center; font-size: 1.3rem;
    border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,.15);
}
.nt-act-body { padding: 2rem 1rem 1.3rem; text-align: center; }
.nt-act-body h3 { font-size: 1.12rem; font-weight: 600; margin-bottom: .3rem; }
.nt-act-body p { color: var(--muted); font-size: .88rem; margin: 0; }

/* ABOUT */
.nt-about-img { background: #fff; padding: 8px; border-radius: 16px; box-shadow: 0 12px 32px rgba(0,0,0,.14); }
.nt-about-img img { width: 100%; height: 300px; object-fit: cover; border-radius: 10px; display: block; }
.nt-quote { background: var(--green-soft); border-radius: 16px; padding: 2rem 1.6rem; text-align: center; height: 100%; }
.nt-quote-mark { font-size: 3.5rem; color: #6fbf73; line-height: 1; display: block; }
.nt-quote p { font-family: Georgia, 'Noto Sans Tamil', serif; font-style: italic; font-size: 1.1rem; line-height: 1.7; color: #2c3a33; margin: .4rem 0 1rem; }
.nt-quote-icon { font-size: 2.2rem; color: var(--green); }

/* MISSION */
.nt-mission { position: relative; background-size: cover; background-position: center; padding: 70px 0; }
.nt-mission-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(20,22,18,.92) 0%, rgba(20,22,18,.75) 45%, rgba(20,22,18,.3) 100%); }
.nt-mission-inner { position: relative; z-index: 1; display: flex; align-items: center; gap: 2.5rem; flex-wrap: wrap; }
.nt-play {
    width: 96px; height: 96px; flex: 0 0 96px; border-radius: 50%; border: 3px solid #fff; background: transparent;
    color: #fff; font-size: 3rem; display: grid; place-items: center; transition: all .25s;
}
.nt-play:hover { background: #fff; color: var(--green-dark); transform: scale(1.06); }
.nt-mission-copy { flex: 1; min-width: 240px; }
.nt-mission-label { color: #8fd694; font-weight: 600; font-size: 1.2rem; display: inline-flex; align-items: center; gap: .8rem; }
.nt-mission-label .nt-line { background: #8fd694; }
.nt-mission h2 { color: #fff; font-size: clamp(2.4rem, 5vw, 3.6rem); font-weight: 800; text-transform: uppercase; line-height: 1; margin: .5rem 0 .7rem; }
.nt-mission p { color: rgba(255,255,255,.9); font-size: 1.1rem; margin: 0; }

/* GALLERY + BLOG */
.nt-split { border-right: 1px solid #e5ebe7; padding-right: 2.5rem; }
.nt-row-head { display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 1.2rem; }
.nt-row-head h2 { font-size: 1.5rem; font-weight: 700; color: var(--green-dark); margin: 0; }
.nt-pill { border: 1.5px solid var(--green); color: var(--green-dark); border-radius: 50px; padding: .35rem .9rem; font-size: .8rem; font-weight: 600; white-space: nowrap; transition: .2s; }
.nt-pill:hover { background: var(--green); color: #fff; }
.nt-gal { display: block; border-radius: 10px; overflow: hidden; aspect-ratio: 1 / .75; box-shadow: 0 6px 16px rgba(0,0,0,.1); }
.nt-gal img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.nt-gal:hover img { transform: scale(1.08); }
.nt-blog { height: 100%; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 6px 18px rgba(0,0,0,.09); display: flex; flex-direction: column; }
.nt-blog-img { display: block; aspect-ratio: 16 / 10; background: var(--green-soft); overflow: hidden; }
.nt-blog-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.nt-blog:hover .nt-blog-img img { transform: scale(1.06); }
.nt-blog-img span { display: grid; place-items: center; height: 100%; font-size: 2rem; color: var(--green); }
.nt-blog-body { padding: .9rem; display: flex; flex-direction: column; flex: 1; }
.nt-blog-body h3 { font-size: .92rem; font-weight: 600; line-height: 1.4; margin-bottom: .8rem; flex: 1; }
.nt-blog-body h3 a { color: var(--ink); }
.nt-blog-body h3 a:hover { color: var(--green); }
.nt-more { color: var(--green); font-size: .82rem; font-weight: 600; }

/* CTA */
.nt-cta { position: relative; background: linear-gradient(100deg, var(--green-dark), var(--green)); padding: 50px 0 45px; overflow: hidden; }
.nt-cta-wave { position: absolute; top: 0; left: 0; width: 100%; height: 30px; }
.nt-cta-wave path { fill: #fff; }
.nt-cta-inner { position: relative; z-index: 1; display: flex; align-items: center; gap: 2rem; flex-wrap: wrap; }
.nt-cta-heart { font-size: 4rem; color: #fff; line-height: 1; }
.nt-cta h2 { color: #fff; font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 700; margin: 0 0 .2rem; }
.nt-cta p { color: rgba(255,255,255,.9); margin: 0; }
.nt-leaf-cta { position: absolute; right: 30px; bottom: -10px; width: 80px; transform: rotate(15deg); }
.nt-leaf-cta path { fill: rgba(255,255,255,.12); stroke: rgba(255,255,255,.18); }

.nt-modal-close { position: absolute; right: 0; top: -40px; z-index: 2; }

/* RESPONSIVE */
@media (max-width: 991.98px) {
    .nt-hero-slide { min-height: 520px; }
    .nt-hero-img { width: 100%; }
    .nt-hero-ctrl { display: none; }
    .nt-hero-fade { background: linear-gradient(90deg, rgba(255,255,255,.97) 0%, rgba(255,255,255,.88) 55%, rgba(255,255,255,.35) 100%); }
    .nt-stats .col-6:nth-child(2) .nt-stat { border-right: 0; }
    .nt-stats .col-6:nth-child(-n+2) .nt-stat { border-bottom: 1px solid rgba(18,130,63,.15); }
    .nt-split { border-right: 0; padding-right: calc(var(--bs-gutter-x) * .5); }
    .nt-about-img img { height: 320px; }
}
@media (max-width: 575.98px) {
    .nt-hero-slide { min-height: 500px; }
    .nt-hero-content { padding-top: 40px; padding-bottom: 100px; }
    .nt-hero-dots { margin-bottom: 45px; }
    .nt-hero p { font-size: 1.02rem; }
    .nt-hero-wave { height: 50px; }
    .nt-stat { flex-direction: column; text-align: center; gap: .3rem; padding: .9rem .4rem; }
    .nt-stat i { font-size: 2rem; }
    .nt-stat strong { font-size: 1.4rem; }
    .nt-stat span { font-size: .78rem; }
    .nt-heading h2 { font-size: 1.6rem; }
    .nt-heading .nt-line { width: 28px; }
    .nt-section { padding: 52px 0; }
    .nt-mission-inner { flex-direction: column; align-items: flex-start; gap: 1.5rem; }
    .nt-play { width: 76px; height: 76px; flex-basis: 76px; font-size: 2.4rem; }
    .nt-row-head h2 { font-size: 1.3rem; }
    .nt-cta-inner { flex-direction: column; align-items: flex-start; gap: 1rem; }
    .nt-cta-heart { font-size: 3rem; }
}
@media (prefers-reduced-motion: reduce) { .nt * { transition: none !important; } }
</style>
@endpush