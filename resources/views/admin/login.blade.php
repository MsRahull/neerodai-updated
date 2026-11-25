<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login - Neerodai Trust</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --g: #12823f; --g-dark: #0b5e2d; --g-deep: #0a4a26; --gold: #ffc61a;
            --ink: #1d2b24; --muted: #64748b; --line: #dbe3ec; --err: #dc2626; --err-bg: #fef2f2;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh; min-height: 100dvh; font-family: 'Poppins', system-ui, sans-serif; color: var(--ink);
            display: flex; align-items: center; justify-content: center; padding: 24px 16px;
            background: radial-gradient(circle at 15% 20%, #e6f4ea 0, transparent 45%),
                        radial-gradient(circle at 85% 80%, #e3f0fb 0, transparent 45%), #f4f7fb;
        }
        .lg-shell {
            width: 100%; max-width: 920px; display: grid; grid-template-columns: 1fr 1fr;
            background: #fff; border-radius: 22px; overflow: hidden; box-shadow: 0 24px 60px rgba(15, 40, 80, .14);
        }

        /* Brand panel */
        .lg-brand {
            position: relative; padding: 48px 40px; color: #fff; display: flex; flex-direction: column; justify-content: space-between;
            background: radial-gradient(circle at 80% 20%, #3fa45b 0%, var(--g) 40%, var(--g-deep) 100%);
        }
        .lg-brand::after {
            content: ""; position: absolute; right: -60px; bottom: -60px; width: 220px; height: 220px; border-radius: 50%;
            background: rgba(255,255,255,.07);
        }
        .lg-logo { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 1.15rem; line-height: 1.15; }
        .lg-logo svg { width: 52px; height: 52px; background: #fff; border-radius: 14px; padding: 6px; }
        .lg-logo small { display: block; font-weight: 500; font-size: .8rem; opacity: .85; letter-spacing: .08em; }
        .lg-brand h1 { font-size: 1.9rem; line-height: 1.25; margin: 40px 0 12px; }
        .lg-brand p { opacity: .88; font-size: .95rem; line-height: 1.6; }
        .lg-brand ul { list-style: none; margin-top: 28px; display: grid; gap: 10px; font-size: .9rem; }
        .lg-brand li i { color: var(--gold); width: 22px; }

        /* Form panel */
        .lg-form { padding: 48px 44px; display: flex; flex-direction: column; justify-content: center; }
        .lg-form h2 { font-size: 1.6rem; margin-bottom: 4px; }
        .lg-sub { color: var(--muted); font-size: .92rem; margin-bottom: 26px; }

        .lg-alert { display: flex; gap: 10px; align-items: flex-start; padding: 12px 14px; border-radius: 12px; font-size: .9rem; margin-bottom: 18px; }
        .lg-alert i { margin-top: 3px; }
        .lg-alert.error { background: var(--err-bg); color: #991b1b; border: 1px solid #fecaca; }
        .lg-alert.ok { background: #ecfdf3; color: #065f46; border: 1px solid #bbf7d0; }

        .lg-field { margin-bottom: 18px; }
        .lg-field label { display: block; font-weight: 600; font-size: .88rem; margin-bottom: 6px; }
        .lg-input { position: relative; }
        .lg-input > i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
        .lg-input input {
            width: 100%; height: 50px; border: 1.5px solid var(--line); border-radius: 12px; padding: 0 46px 0 42px;
            font: inherit; font-size: .95rem; color: var(--ink); background: #fbfdff; transition: border-color .2s, box-shadow .2s;
        }
        .lg-input input:focus { outline: none; border-color: var(--g); box-shadow: 0 0 0 4px rgba(18,130,63,.12); background: #fff; }
        .lg-field.invalid input { border-color: var(--err); background: var(--err-bg); }
        .lg-field.invalid input:focus { box-shadow: 0 0 0 4px rgba(220,38,38,.12); }
        .lg-msg { display: none; color: var(--err); font-size: .82rem; margin-top: 6px; }
        .lg-field.invalid .lg-msg { display: flex; gap: 6px; align-items: center; }
        .lg-eye {
            position: absolute; right: 6px; top: 50%; transform: translateY(-50%); width: 38px; height: 38px;
            border: 0; background: transparent; color: #64748b; border-radius: 8px; cursor: pointer;
        }
        .lg-eye:hover, .lg-eye:focus-visible { background: #eef2f7; outline: none; }
        .lg-caps { display: none; color: #b45309; font-size: .8rem; margin-top: 6px; }

        .lg-btn {
            width: 100%; height: 50px; margin-top: 6px; border: 0; border-radius: 12px; cursor: pointer;
            background: var(--g); color: #fff; font: inherit; font-weight: 600; font-size: 1rem;
            display: inline-flex; align-items: center; justify-content: center; gap: 10px;
            box-shadow: 0 10px 22px rgba(18,130,63,.25); transition: background .2s, transform .1s;
        }
        .lg-btn:hover { background: var(--g-dark); }
        .lg-btn:active { transform: translateY(1px); }
        .lg-btn:disabled { opacity: .7; cursor: not-allowed; }
        .lg-btn .spin { display: none; width: 18px; height: 18px; border: 2.5px solid rgba(255,255,255,.4); border-top-color: #fff; border-radius: 50%; animation: spin .7s linear infinite; }
        .lg-btn.loading .spin { display: inline-block; }
        .lg-btn.loading .txt-icon { display: none; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .lg-foot { margin-top: 22px; text-align: center; font-size: .85rem; color: var(--muted); }
        .lg-foot a { color: var(--g-dark); text-decoration: none; font-weight: 600; }

        @media (max-width: 767.98px) {
            body { align-items: flex-start; padding: 16px; }
            .lg-shell { grid-template-columns: 1fr; border-radius: 18px; }
            .lg-brand { padding: 24px 22px; }
            .lg-brand h1, .lg-brand p, .lg-brand ul { display: none; }
            .lg-form { padding: 28px 22px 30px; }
            .lg-form h2 { font-size: 1.4rem; }
        }
        @media (prefers-reduced-motion: reduce) { * { transition: none !important; animation: none !important; } }
    </style>
</head>
<body>
<main class="lg-shell">
    <section class="lg-brand" aria-hidden="true">
        <div class="lg-logo">
            <svg viewBox="0 0 48 48">
                <circle cx="24" cy="11" r="5" fill="#f4b63f"/>
                <path d="M24 44 C 24 34, 24 26, 24 19" stroke="#12823f" stroke-width="3" fill="none" stroke-linecap="round"/>
                <path d="M24 30 C 14 30, 6 22, 5 13 C 15 13, 23 20, 24 30 Z" fill="#12823f"/>
                <path d="M24 30 C 34 30, 42 22, 43 13 C 33 13, 25 20, 24 30 Z" fill="#6fbf73"/>
                <path d="M10 36 C 16 42, 32 42, 38 36" stroke="#12823f" stroke-width="3" fill="none" stroke-linecap="round"/>
            </svg>
            <span>Neerodai Trust<small>ADMIN PANEL</small></span>
        </div>
        <div>
            <h1>Care. Dignity.<br>Hope.</h1>
            <p>Manage blogs, gallery, videos, donations and messages from one place.</p>
            <ul>
                <li><i class="fas fa-shield-halved"></i> Secure, rate-limited sign in</li>
                <li><i class="fas fa-language"></i> English &amp; Tamil content</li>
                <li><i class="fas fa-hand-holding-heart"></i> Donations &amp; 80G records</li>
            </ul>
        </div>
    </section>

    <section class="lg-form">
        <h2>Welcome back</h2>
        <p class="lg-sub">Sign in to your admin account</p>

        @if (session('status'))
            <div class="lg-alert ok" role="status"><i class="fas fa-circle-check"></i><span>{{ session('status') }}</span></div>
        @endif

        @if (session('lockout_seconds'))
            <div class="lg-alert error" role="alert">
                <i class="fas fa-lock"></i>
                <span>Too many login attempts. Try again in <strong id="lockCount">{{ session('lockout_seconds') }}</strong> seconds.</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm" novalidate>
            @csrf

            <div class="lg-field @error('email') invalid @enderror" data-field>
                <label for="email">Email address</label>
                <div class="lg-input">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="username"
                           maxlength="150" placeholder="admin@example.com" required
                           @if(!session('lockout_seconds')) autofocus @endif
                           aria-describedby="email-msg" @error('email') aria-invalid="true" @enderror>
                </div>
                <div class="lg-msg" id="email-msg" role="alert">
                    <i class="fas fa-circle-exclamation"></i><span>@error('email'){{ session('lockout_seconds') ? 'Account temporarily locked.' : $message }}@enderror</span>
                </div>
            </div>

            <div class="lg-field @error('password') invalid @enderror" data-field>
                <label for="password">Password</label>
                <div class="lg-input">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" autocomplete="current-password"
                           minlength="6" maxlength="200" placeholder="Enter your password" required
                           aria-describedby="password-msg" @error('password') aria-invalid="true" autofocus @enderror>
                    <button type="button" class="lg-eye" id="togglePw" aria-label="Show password" aria-pressed="false">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="lg-caps" id="capsWarn"><i class="fas fa-triangle-exclamation"></i> Caps Lock is on</div>
                <div class="lg-msg" id="password-msg" role="alert">
                    <i class="fas fa-circle-exclamation"></i><span>@error('password'){{ $message }}@enderror</span>
                </div>
            </div>

            <button type="submit" class="lg-btn" id="loginBtn" @if(session('lockout_seconds')) disabled @endif>
                <span class="spin" aria-hidden="true"></span>
                <i class="fas fa-right-to-bracket txt-icon"></i>
                <span id="loginTxt">Sign in</span>
            </button>
        </form>

        <p class="lg-foot"><a href="{{ url('/') }}"><i class="fas fa-arrow-left"></i> Back to website</a></p>
    </section>
</main>

<script>
(function () {
    var form = document.getElementById('loginForm');
    var email = document.getElementById('email');
    var pw = document.getElementById('password');
    var btn = document.getElementById('loginBtn');

    function setError(input, msg) {
        var field = input.closest('[data-field]');
        field.classList.toggle('invalid', !!msg);
        field.querySelector('.lg-msg span').textContent = msg || '';
        if (msg) input.setAttribute('aria-invalid', 'true'); else input.removeAttribute('aria-invalid');
    }
    function checkEmail() {
        var v = email.value.trim();
        if (!v) return 'Please enter your email address.';
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v)) return 'Please enter a valid email address.';
        return '';
    }
    function checkPw() {
        if (!pw.value) return 'Please enter your password.';
        if (pw.value.length < 6) return 'Password must be at least 6 characters.';
        return '';
    }

    // Validate a field when the user leaves it, and clear the error while typing
    email.addEventListener('blur', function () { if (email.value) setError(email, checkEmail()); });
    pw.addEventListener('blur', function () { if (pw.value) setError(pw, checkPw()); });
    [email, pw].forEach(function (i) {
        i.addEventListener('input', function () { if (i.closest('.invalid')) setError(i, i === email ? checkEmail() : checkPw()); });
    });

    form.addEventListener('submit', function (e) {
        var eMsg = checkEmail(), pMsg = checkPw();
        setError(email, eMsg); setError(pw, pMsg);
        if (eMsg || pMsg) {
            e.preventDefault();
            (eMsg ? email : pw).focus();
            return;
        }
        btn.disabled = true;
        btn.classList.add('loading');
        document.getElementById('loginTxt').textContent = 'Signing in…';
    });

    // Show / hide password
    document.getElementById('togglePw').addEventListener('click', function () {
        var show = pw.type === 'password';
        pw.type = show ? 'text' : 'password';
        this.setAttribute('aria-pressed', show);
        this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        this.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        pw.focus();
    });

    // Caps Lock warning
    pw.addEventListener('keyup', function (e) {
        document.getElementById('capsWarn').style.display = e.getModifierState && e.getModifierState('CapsLock') ? 'block' : 'none';
    });

    // Lockout countdown
    var counter = document.getElementById('lockCount');
    if (counter) {
        var left = parseInt(counter.textContent, 10);
        var timer = setInterval(function () {
            left -= 1;
            if (left <= 0) {
                clearInterval(timer);
                counter.closest('.lg-alert').remove();
                btn.disabled = false;
                return;
            }
            counter.textContent = left;
        }, 1000);
    }

    // Page restored from back/forward cache: reset the button
    window.addEventListener('pageshow', function () {
        btn.classList.remove('loading');
        document.getElementById('loginTxt').textContent = 'Sign in';
        if (!document.getElementById('lockCount')) btn.disabled = false;
    });
})();
</script>
</body>
</html>
