@php
    $email = 'neerodaitrust@gmail.com';
    $phone = '+918110079041';
    $phoneLabel = '+91 81100 79041';
@endphp

<footer class="nf">
    <svg class="nf-leaf nf-leaf-l" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>
    <svg class="nf-leaf nf-leaf-r" viewBox="0 0 100 160" aria-hidden="true"><path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/></svg>

    <div class="container nf-main">
        <div class="row g-4 g-lg-5">

            {{-- Brand --}}
            <div class="col-lg-4 col-md-6">
                <a href="{{ url('/') }}" class="nf-brand">
                    <span class="nf-logo" aria-hidden="true">
                        <svg viewBox="0 0 48 48">
                            <circle cx="24" cy="11" r="5" fill="#ffc61a"/>
                            <path d="M24 44 C 24 34, 24 26, 24 19" stroke="#fff" stroke-width="3" fill="none" stroke-linecap="round"/>
                            <path d="M24 30 C 14 30, 6 22, 5 13 C 15 13, 23 20, 24 30 Z" fill="#6fbf73"/>
                            <path d="M24 30 C 34 30, 42 22, 43 13 C 33 13, 25 20, 24 30 Z" fill="#a8dcaa"/>
                            <path d="M10 36 C 16 42, 32 42, 38 36" stroke="#fff" stroke-width="3" fill="none" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span>
                        <strong>Neerodai</strong>
                        <small>Trust</small>
                    </span>
                </a>
                <p class="nf-tag">Care. Dignity. Hope.</p>
                <p class="nf-about">Supporting elders who are alone and in need with food, care and companionship for over 15 years.</p>
                <a href="{{ url('/pay') }}" class="nf-donate"><i class="bi bi-heart-fill"></i> Donate Now</a>
            </div>

            {{-- Quick links --}}
            <div class="col-lg-2 col-md-6 col-6">
                <h5 class="nf-h">Quick Links</h5>
                <ul class="nf-links">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/about') }}">About Us</a></li>
                    <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                    <li><a href="{{ url('/blogs') }}">Blogs</a></li>
                    <li><a href="{{ url('/videos') }}">Videos</a></li>
                    <li><a href="{{ url('/pay') }}">Donate</a></li>
                    <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-3 col-md-6 col-6">
                <h5 class="nf-h">Contact Us</h5>
                <ul class="nf-contact">
                    <li>
                        <i class="bi bi-telephone-fill"></i>
                        <a href="tel:{{ $phone }}">{{ $phoneLabel }}</a>
                    </li>
                    <li>
                        <i class="bi bi-envelope-fill"></i>
                        <a href="mailto:{{ $email }}">{{ $email }}</a>
                    </li>
                    <li>
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>South Street, Thatchamozhi,<br>Sathankulam, Tamil Nadu 628704</span>
                    </li>
                </ul>
            </div>

            {{-- Social --}}
            <div class="col-lg-3 col-md-6">
                <h5 class="nf-h">Connect With Us</h5>
                <p class="nf-about mb-3">Follow our work and share it with your friends and family.</p>
                <div class="nf-social">
                    <a href="https://facebook.com/" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@NithiyamTv" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://wa.me/918110079041?text=hi-Neerodaitrust" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

        </div>
    </div>

    <div class="nf-bottom">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <span>&copy; {{ date('Y') }} Neerodai Trust. All Rights Reserved.</span>
            <span>
                <a href="{{ url('/privacy') }}">Privacy Policy</a>
                <span class="nf-dot">•</span>
                <a href="{{ url('/terms') }}">Terms &amp; Conditions</a>
            </span>
        </div>
    </div>
</footer>

<style>
.nf {
    --nf-green: #12823f;
    --nf-gold: #ffc61a;
    position: relative; overflow: hidden; color: rgba(255,255,255,.82);
    background: linear-gradient(160deg, #0b5e2d 0%, #0a4a26 55%, #083b1f 100%);
    font-family: 'Poppins', 'Noto Sans Tamil', system-ui, sans-serif;
}
.nf a { text-decoration: none; color: rgba(255,255,255,.82); transition: color .2s ease; }
.nf a:hover { color: var(--nf-gold); }
.nf-main { position: relative; z-index: 1; padding-top: 64px; padding-bottom: 44px; }

.nf-brand { display: inline-flex; align-items: center; gap: .7rem; margin-bottom: .6rem; }
.nf-logo { width: 54px; height: 54px; display: block; }
.nf-logo svg { width: 100%; height: 100%; }
.nf-brand strong { display: block; color: #fff; font-size: 1.6rem; font-weight: 700; line-height: 1; }
.nf-brand small { display: block; color: #a8dcaa; font-size: 1rem; letter-spacing: .25em; margin-top: 3px; }
.nf-tag { color: var(--nf-gold); font-weight: 600; margin-bottom: .5rem; }
.nf-about { font-size: .9rem; line-height: 1.7; margin-bottom: 1.2rem; }

.nf-donate {
    display: inline-flex; align-items: center; gap: .45rem; background: var(--nf-gold); color: #1d2b24 !important;
    padding: .6rem 1.4rem; border-radius: 50px; font-weight: 700; font-size: .92rem; transition: transform .2s ease;
}
.nf-donate:hover { transform: translateY(-2px); color: #1d2b24 !important; }

.nf-h { color: #fff; font-size: 1.08rem; font-weight: 600; margin-bottom: 1.2rem; position: relative; padding-bottom: .6rem; }
.nf-h::after { content: ""; position: absolute; left: 0; bottom: 0; width: 34px; height: 3px; border-radius: 3px; background: var(--nf-gold); }

.nf-links { list-style: none; padding: 0; margin: 0; display: grid; gap: .55rem; }
.nf-links a { font-size: .92rem; display: inline-flex; align-items: center; gap: .45rem; }
.nf-links a::before { content: "\F285"; font-family: "bootstrap-icons"; font-size: .7rem; color: #a8dcaa; transition: transform .2s; }
.nf-links a:hover::before { transform: translateX(3px); color: var(--nf-gold); }

.nf-contact { list-style: none; padding: 0; margin: 0; display: grid; gap: .9rem; font-size: .9rem; }
.nf-contact li { display: flex; gap: .75rem; align-items: flex-start; }
.nf-contact i { width: 34px; height: 34px; flex: 0 0 34px; display: grid; place-items: center; border-radius: 10px; background: rgba(255,255,255,.1); color: var(--nf-gold); }
.nf-contact a, .nf-contact span { padding-top: 6px; word-break: break-word; }

.nf-social { display: flex; gap: .7rem; }
.nf-social a {
    width: 42px; height: 42px; border-radius: 50%; display: grid; place-items: center; font-size: 1.1rem;
    background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); color: #fff; transition: all .25s ease;
}
.nf-social a:hover { background: var(--nf-gold); border-color: var(--nf-gold); color: #0a4a26; transform: translateY(-3px); }

.nf-bottom { position: relative; z-index: 1; border-top: 1px solid rgba(255,255,255,.12); padding: 18px 0; font-size: .85rem; }
.nf-dot { margin: 0 .5rem; opacity: .5; }

.nf-leaf { position: absolute; width: 110px; z-index: 0; }
.nf-leaf path { fill: rgba(255,255,255,.06); stroke: rgba(255,255,255,.08); stroke-width: 2; }
.nf-leaf-l { left: -20px; bottom: 40px; transform: rotate(-20deg); }
.nf-leaf-r { right: -10px; top: 30px; transform: rotate(20deg) scaleX(-1); }

@media (max-width: 767.98px) {
    .nf-main { padding-top: 48px; padding-bottom: 32px; }
    .nf-bottom { text-align: center; padding-bottom: 90px; } /* room for floating WhatsApp */
}
</style>