{{-- Shared layout for Privacy Policy / Terms pages.
     Params: $heading (string), $intro (string|null), $sections (array of [title, [paragraphs...]]) --}}
<div class="lg">
    <section class="lg-banner">
        <div class="container">
            <nav aria-label="breadcrumb" class="lg-crumb">
                <a href="{{ url('/') }}">{{ __('Home') }}</a> <i class="bi bi-chevron-right"></i> <span>{{ $heading }}</span>
            </nav>
            <h1>{{ $heading }}</h1>
            <span class="lg-bar"></span>
        </div>
    </section>

    <section class="lg-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="lg-card">
                        @if(!empty($intro))
                            <p class="lg-intro">{{ $intro }}</p>
                        @endif
                        <ol class="lg-list">
                            @foreach($sections as [$title, $paragraphs])
                                <li>
                                    <h2>{{ $title }}</h2>
                                    @foreach($paragraphs as $p)
                                        <p>{{ $p }}</p>
                                    @endforeach
                                </li>
                            @endforeach
                        </ol>
                        <div class="lg-contact">
                            <a href="mailto:neerodaitrust@gmail.com"><i class="bi bi-envelope-fill"></i> neerodaitrust@gmail.com</a>
                            <a href="tel:+918110079041"><i class="bi bi-telephone-fill"></i> +91 81100 79041</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
.lg { --g: #12823f; --g-dark: #0b5e2d; --ink: #1d2b24; --muted: #55635c; color: var(--ink);
      font-family: 'Poppins', 'Noto Sans Tamil', system-ui, sans-serif; background: #f6faf7; }
.lg a { text-decoration: none; }
.lg-banner { background: radial-gradient(circle at 80% 30%, #3fa45b 0%, #12823f 35%, #0a4a26 100%); padding: 56px 0 48px; color: #fff; }
.lg-crumb { font-size: .88rem; color: rgba(255,255,255,.8); margin-bottom: .6rem; }
.lg-crumb a { color: #fff; } .lg-crumb i { font-size: .7rem; margin: 0 .35rem; }
.lg-banner h1 { font-size: clamp(1.9rem, 5vw, 3rem); font-weight: 800; margin-bottom: .6rem; }
.lg-bar { display: block; width: 70px; height: 5px; border-radius: 5px; background: #ffc61a; }
.lg-body { padding: 40px 0 70px; }
.lg-card { background: #fff; border-radius: 18px; padding: 2rem 2.4rem; box-shadow: 0 10px 30px rgba(10,74,38,.08); }
.lg-intro { color: var(--muted); font-size: 1.05rem; }
.lg-list { padding-left: 1.3rem; margin: 0; }
.lg-list li { margin-bottom: 1.4rem; }
.lg-list li::marker { color: var(--g); font-weight: 700; }
.lg-list h2 { font-size: 1.15rem; font-weight: 700; color: var(--g-dark); margin-bottom: .4rem; }
.lg-list p { margin-bottom: .35rem; line-height: 1.75; color: #34433c; }
.lg-contact { display: flex; flex-wrap: wrap; gap: .6rem 1.2rem; border-top: 1px solid #e6efe8; padding-top: 1.2rem; margin-top: .6rem; }
.lg-contact a { color: var(--g-dark); font-weight: 600; overflow-wrap: anywhere; }
@media (max-width: 575.98px) {
    .lg-banner { padding: 40px 0 34px; }
    .lg-body { padding: 24px 0 50px; }
    .lg-card { padding: 1.3rem 1.1rem; border-radius: 14px; }
}
</style>
@endpush
