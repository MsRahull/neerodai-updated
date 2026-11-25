@extends('user')

@section('title', __('Contact Us') . ' - ' . __('Neerodai Trust'))
@section('meta_description', __('Contact Neerodai Trust by phone, WhatsApp, email or the contact form to volunteer, donate or ask a question.'))

@section('content')

@php
    // Optional banner photo. Leave null for the green leafy gradient.
    $bannerImage = null; // e.g. 'contact-banner.jpg' inside public/user/frontend/

    $leaf = '<path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/>';
    $hands = '<path d="M32 26 C 32 26, 22 19, 22 13 C 22 9, 25 7, 28 7 C 30 7, 31.5 8.5, 32 10 C 32.5 8.5, 34 7, 36 7 C 39 7, 42 9, 42 13 C 42 19, 32 26, 32 26 Z" fill="currentColor"/><path d="M6 30 L 14 46 C 16 50, 20 54, 26 54 L 30 54 L 30 44 C 30 41, 28 38, 25 36 L 17 30 C 15 29, 13 30, 14 32 L 19 39" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M58 30 L 50 46 C 48 50, 44 54, 38 54 L 34 54 L 34 44 C 34 41, 36 38, 39 36 L 47 30 C 49 29, 51 30, 50 32 L 45 39" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>';
@endphp

<div class="ct">

{{-- ================= BANNER ================= --}}
<section class="ct-banner" @if($bannerImage) style="background-image:url('{{ asset('user/frontend/' . $bannerImage) }}')" @endif>
    <div class="ct-banner-overlay"></div>
    <svg class="ct-banner-leaf ct-bl-1" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
    <svg class="ct-banner-leaf ct-bl-2" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>

    <div class="container ct-banner-content">
        <nav aria-label="breadcrumb" class="ct-crumb">
            <a href="{{ url('/') }}">{{ __('Home') }}</a> <i class="bi bi-chevron-right"></i> <span>{{ __('Contact') }}</span>
        </nav>
        <h1>{{ __('Contact Us') }}</h1>
        <p>{{ __("Have questions or need assistance? Get in touch with us, and we'll be happy to help.") }}</p>
        <span class="ct-gold-bar"></span>
    </div>

    <svg class="ct-banner-wave" viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true">
        <path class="w1" d="M0 30 C 400 0, 1000 60, 1440 10 L1440 60 L0 60 Z"/>
        <path class="w2" d="M0 42 C 420 10, 1000 70, 1440 25 L1440 60 L0 60 Z"/>
    </svg>
</section>

{{-- ================= FORM + LOCATION ================= --}}
<section class="ct-section">
    <div class="container">

        @if(session('success'))
            <div class="ct-alert ct-alert-success" role="status">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="ct-alert ct-alert-error" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>
                    <strong>{{ __('Please check the form:') }}</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="row g-4">

            {{-- Form --}}
            <div class="col-lg-6">
                <div class="ct-card h-100">
                    <svg class="ct-card-leaf" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>

                    <div class="ct-card-head">
                        <span class="ct-card-icon"><i class="bi bi-envelope-fill"></i></span>
                        <div>
                            <h2>{{ __('Send Us a Message') }}</h2>
                            <p>{{ __("We'd love to hear from you. Please fill out the form below.") }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('contact.submit') }}" class="ct-form">
                        @csrf
                        {{-- Honeypot: hidden from people, filled in by spam bots --}}
                        <div style="position:absolute;left:-9999px;" aria-hidden="true">
                            <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                        </div>

                        <div class="ct-field">
                            <label for="name">{{ __('Your Name') }} <span>*</span></label>
                            <div class="ct-input @error('name') is-invalid @enderror">
                                <i class="bi bi-person-fill"></i>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{ __('Your full name') }}" autocomplete="name" required>
                            </div>
                        </div>

                        <div class="ct-field">
                            <label for="email">{{ __('Your Email') }} <span>*</span></label>
                            <div class="ct-input @error('email') is-invalid @enderror">
                                <i class="bi bi-envelope-fill"></i>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="example@email.com" autocomplete="email" required>
                            </div>
                        </div>

                        <div class="ct-field">
                            <label for="mobile">{{ __('Mobile Number') }} <span>*</span></label>
                            <div class="ct-input @error('mobile') is-invalid @enderror">
                                <i class="bi bi-telephone-fill"></i>
                                <input type="tel" name="mobile" id="mobile" value="{{ old('mobile') }}" placeholder="+91 98765 43210" autocomplete="tel" required>
                            </div>
                        </div>

                        <div class="ct-field">
                            <label for="address">{{ __('Your Address') }} <span>*</span></label>
                            <div class="ct-input @error('address') is-invalid @enderror">
                                <i class="bi bi-geo-alt-fill"></i>
                                <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="{{ __('Street, City, State') }}" autocomplete="street-address" required>
                            </div>
                        </div>

                        <div class="ct-field">
                            <label for="message">{{ __('Message') }} <span>*</span></label>
                            <div class="ct-input ct-textarea @error('message') is-invalid @enderror">
                                <i class="bi bi-pencil-fill"></i>
                                <textarea name="message" id="message" rows="4" placeholder="{{ __('Write your message...') }}" required>{{ old('message') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="ct-submit">
                            <i class="bi bi-send-fill"></i> {{ __('Send Message') }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Location + difference card --}}
            <div class="col-lg-6 d-flex flex-column gap-4">
                <div class="ct-card">
                    <div class="ct-card-head">
                        <span class="ct-card-icon"><i class="bi bi-geo-alt-fill"></i></span>
                        <div>
                            <h2>{{ __('Our Location') }}</h2>
                            <p>{{ __('Visit us at our office or reach out via phone or email.') }}</p>
                        </div>
                    </div>

                    <ul class="ct-info">
                        <li>
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>{{ __('Neerodai Trust') }}, {!! nl2br(e(__("South Street, Thatchamozhi,\nSathankulam, Tamil Nadu 628704"))) !!}</span>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <a href="mailto:neerodaitrust@gmail.com">neerodaitrust@gmail.com</a>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <a href="tel:+918110079041">+91 81100 79041</a>
                        </li>
                    </ul>

                    <div class="ct-map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d855.4673227155677!2d77.91618540520516!3d8.441295481579415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b0479a0f554ee17%3A0xdd3b7808c128a7d1!2sNeerodai%20Trust!5e0!3m2!1sen!2sin!4v1780842897715!5m2!1sen!2sin"
                            title="{{ __('Neerodai Trust location map') }}"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query=Neerodai+Trust+Sathankulam" target="_blank" rel="noopener" class="ct-directions">
                        <i class="bi bi-sign-turn-right-fill"></i> {{ __('Get Directions') }}
                    </a>
                </div>

                <div class="ct-diff">
                    <svg class="ct-diff-leaf" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
                    <svg class="ct-diff-icon" viewBox="0 0 64 64" aria-hidden="true">{!! $hands !!}</svg>
                    <span class="ct-divider"></span>
                    <div>
                        <h3>{{ __("Let's Make a Difference") }}</h3>
                        <p>{{ __('Together we can build a kinder, healthier, and more hopeful community.') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ================= CTA ================= --}}
<section class="ct-cta">
    <svg class="ct-cta-leaf" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
    <div class="container ct-cta-inner">
        <svg class="ct-cta-icon" viewBox="0 0 64 64" aria-hidden="true">{!! $hands !!}</svg>
        <span class="ct-cta-divider d-none d-md-block"></span>
        <div class="flex-grow-1">
            <h2>{{ __('Together for a Better Tomorrow') }}</h2>
            <p>{{ __('Your support helps us bring hope, care and dignity to the elderly.') }}</p>
        </div>
        <a href="{{ url('/pay') }}" class="ct-btn-gold"><i class="bi bi-heart-fill"></i> {{ __('Donate Now') }} <i class="bi bi-arrow-right"></i></a>
    </div>
</section>

</div>
@endsection

@push('styles')
<style>
.ct {
    --g: #12823f;
    --g-dark: #0b5e2d;
    --g-soft: #eaf6ee;
    --ink: #1d2b24;
    --muted: #55635c;
    --gold: #ffc61a;
    --line: #dfe8e2;
    font-family: 'Poppins', 'Noto Sans Tamil', system-ui, sans-serif;
    color: var(--ink);
    background: #fff;
    overflow-x: hidden;
}
.ct a { text-decoration: none; }
.ct h1, .ct h2, .ct h3 { font-family: inherit; }

/* Banner */
.ct-banner {
    position: relative; overflow: hidden; padding: 80px 0 110px;
    background: radial-gradient(circle at 80% 30%, #3fa45b 0%, #12823f 35%, #0a4a26 100%);
    background-size: cover; background-position: center;
}
.ct-banner-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(8,59,31,.85) 0%, rgba(8,59,31,.55) 50%, rgba(8,59,31,.1) 100%); }
.ct-banner-content { position: relative; z-index: 2; }
.ct-crumb { font-size: .88rem; color: rgba(255,255,255,.8); margin-bottom: .8rem; }
.ct-crumb a { color: #fff; }
.ct-crumb a:hover { color: var(--gold); }
.ct-crumb i { font-size: .7rem; margin: 0 .35rem; }
.ct-banner h1 { color: #fff; font-size: clamp(2.6rem, 6vw, 4rem); font-weight: 800; margin-bottom: .5rem; }
.ct-banner p { color: rgba(255,255,255,.92); font-size: clamp(1rem, 1.8vw, 1.2rem); font-weight: 500; max-width: 560px; margin-bottom: 1rem; }
.ct-gold-bar { display: block; width: 80px; height: 5px; border-radius: 5px; background: var(--gold); }
.ct-banner-leaf { position: absolute; z-index: 1; }
.ct-banner-leaf path { fill: rgba(255,255,255,.1); stroke: rgba(255,255,255,.15); stroke-width: 2; }
.ct-bl-1 { right: 8%; top: 10px; width: 150px; transform: rotate(25deg); }
.ct-bl-2 { right: 24%; bottom: 20px; width: 80px; transform: rotate(-20deg); }
.ct-banner-wave { position: absolute; left: 0; bottom: -1px; width: 100%; height: 60px; z-index: 2; }
.ct-banner-wave .w1 { fill: #bfe3c7; }
.ct-banner-wave .w2 { fill: #fff; }

/* Section */
.ct-section { padding: 40px 0 60px; }

/* Alerts */
.ct-alert { display: flex; gap: .8rem; align-items: flex-start; padding: 1rem 1.2rem; border-radius: 14px; margin-bottom: 1.6rem; font-weight: 500; }
.ct-alert i { font-size: 1.3rem; line-height: 1.2; }
.ct-alert ul { margin: .3rem 0 0; padding-left: 1.1rem; font-weight: 400; }
.ct-alert-success { background: var(--g-soft); color: var(--g-dark); border: 1px solid #bfe0c8; }
.ct-alert-error { background: #fdeeee; color: #a12a2a; border: 1px solid #f5c6c6; }

/* Cards */
.ct-card {
    position: relative; overflow: hidden; background: #fff; border-radius: 16px; padding: 1.8rem;
    border: 1px solid #eef3ef; box-shadow: 0 10px 30px rgba(10,74,38,.09);
}
.ct-card-head { display: flex; gap: 1rem; align-items: center; padding-bottom: 1.1rem; margin-bottom: 1.3rem; position: relative; }
.ct-card-head::after { content: ""; position: absolute; left: 0; bottom: 0; width: 55%; height: 2px; background: linear-gradient(90deg, var(--g), rgba(18,130,63,0)); }
.ct-card-icon { width: 56px; height: 56px; flex: 0 0 56px; border-radius: 50%; display: grid; place-items: center; background: var(--g); color: #fff; font-size: 1.45rem; box-shadow: 0 8px 18px rgba(18,130,63,.3); }
.ct-card-head h2 { font-size: 1.55rem; font-weight: 700; color: var(--g-dark); margin: 0 0 .15rem; }
.ct-card-head p { color: var(--muted); font-size: .9rem; margin: 0; }
.ct-card-leaf { position: absolute; left: -20px; bottom: -20px; width: 90px; transform: rotate(-20deg); pointer-events: none; }
.ct-card-leaf path { fill: rgba(18,130,63,.08); stroke: rgba(18,130,63,.15); stroke-width: 2; }

/* Form */
.ct-form { position: relative; z-index: 1; }
.ct-field { margin-bottom: 1rem; }
.ct-field label { display: block; font-weight: 600; font-size: .93rem; margin-bottom: .4rem; }
.ct-field label span { color: #d64534; }
.ct-input { position: relative; display: flex; align-items: center; border: 1.5px solid var(--line); border-radius: 10px; background: #fff; transition: border-color .2s, box-shadow .2s; }
.ct-input i { position: absolute; left: 14px; color: var(--g-dark); font-size: 1rem; pointer-events: none; }
.ct-input input, .ct-input textarea { width: 100%; border: 0; outline: 0; background: transparent; padding: .8rem .9rem .8rem 2.7rem; font-size: .97rem; color: var(--ink); border-radius: 10px; }
.ct-textarea { align-items: flex-start; }
.ct-textarea i { top: 14px; }
.ct-input textarea { resize: vertical; min-height: 100px; }
.ct-input:focus-within { border-color: var(--g); box-shadow: 0 0 0 4px rgba(18,130,63,.12); }
.ct-input.is-invalid { border-color: #d64534; }
.ct-input ::placeholder { color: #9aa59f; }
.ct-submit {
    width: 100%; margin-top: .6rem; display: flex; align-items: center; justify-content: center; gap: .6rem;
    background: var(--g); color: #fff; border: 0; border-radius: 10px; padding: .95rem; font-weight: 600; font-size: 1.05rem;
    box-shadow: 0 8px 20px rgba(18,130,63,.25); transition: background .2s, transform .2s;
}
.ct-submit:hover { background: var(--g-dark); transform: translateY(-2px); }

/* Location info */
.ct-info { list-style: none; padding: 0; margin: 0 0 1.3rem; display: grid; gap: .8rem; }
.ct-info li { display: flex; gap: .9rem; align-items: flex-start; font-size: .97rem; }
.ct-info i { color: var(--g-dark); font-size: 1.1rem; line-height: 1.5; }
.ct-info a { color: var(--ink); }
.ct-info a:hover { color: var(--g); }
.ct-map { position: relative; border-radius: 14px; overflow: hidden; aspect-ratio: 16 / 9; box-shadow: 0 6px 18px rgba(0,0,0,.08); background: var(--g-soft); }
.ct-map iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
.ct-directions { display: inline-flex; align-items: center; gap: .45rem; margin-top: 1rem; color: var(--g-dark); font-weight: 600; font-size: .92rem; }
.ct-directions:hover { color: var(--g); }

/* Difference card */
.ct-diff {
    position: relative; overflow: hidden; flex: 1; display: flex; align-items: center; gap: 1.3rem;
    padding: 1.8rem 2rem; border-radius: 16px; background: linear-gradient(120deg, #e9f6ec, #dcefdf);
}
.ct-diff-icon { width: 64px; height: 64px; flex: 0 0 64px; color: var(--g-dark); }
.ct-divider { width: 2px; align-self: stretch; background: var(--g); opacity: .5; }
.ct-diff h3 { font-size: 1.3rem; font-weight: 700; color: var(--g-dark); margin-bottom: .25rem; }
.ct-diff p { margin: 0; color: var(--muted); font-size: .95rem; }
.ct-diff > *:not(.ct-diff-leaf) { position: relative; z-index: 1; }
.ct-diff-leaf { position: absolute; right: -10px; bottom: -25px; width: 90px; transform: rotate(20deg); }
.ct-diff-leaf path { fill: rgba(18,130,63,.12); stroke: rgba(18,130,63,.2); stroke-width: 2; }

/* CTA */
.ct-cta { position: relative; overflow: hidden; padding: 34px 0; background: linear-gradient(100deg, #0b5e2d 0%, #12823f 55%, #4fa83d 100%); border-top: 5px solid #cfe8d5; }
.ct-cta-inner { position: relative; z-index: 1; display: flex; align-items: center; gap: 1.8rem; }
.ct-cta-icon { width: 76px; height: 76px; flex: 0 0 76px; color: #fff; }
.ct-cta-divider { width: 2px; align-self: stretch; background: rgba(255,255,255,.45); }
.ct-cta h2 { color: #fff; font-size: clamp(1.4rem, 2.6vw, 1.9rem); font-weight: 700; margin-bottom: .2rem; }
.ct-cta p { color: rgba(255,255,255,.9); margin: 0; }
.ct-btn-gold {
    display: inline-flex; align-items: center; gap: .5rem; white-space: nowrap; background: var(--gold); color: var(--ink);
    font-weight: 700; padding: .9rem 1.8rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,.18); transition: all .25s ease;
}
.ct-btn-gold:hover { background: #ffd34d; color: var(--ink); transform: translateY(-2px); }
.ct-cta-leaf { position: absolute; right: 20%; bottom: -30px; width: 110px; transform: rotate(15deg); }
.ct-cta-leaf path { fill: rgba(255,255,255,.1); stroke: rgba(255,255,255,.15); stroke-width: 2; }

/* Responsive */
@media (max-width: 767.98px) {
    .ct-banner { padding: 56px 0 90px; }
    .ct-bl-2 { display: none; }
    .ct-bl-1 { width: 100px; right: -10px; }
    .ct-card { padding: 1.4rem 1.2rem; }
    .ct-card-head h2 { font-size: 1.3rem; }
    .ct-card-icon { width: 48px; height: 48px; flex-basis: 48px; font-size: 1.2rem; }
    .ct-diff { padding: 1.5rem 1.2rem; gap: 1rem; }
    .ct-diff-icon { width: 52px; height: 52px; flex-basis: 52px; }
    .ct-cta-inner { flex-direction: column; align-items: flex-start; gap: 1rem; }
    .ct-cta-leaf { display: none; }
}
@media (prefers-reduced-motion: reduce) { .ct * { transition: none !important; } }
</style>
@endpush
