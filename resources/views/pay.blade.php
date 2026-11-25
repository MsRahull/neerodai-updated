@extends('user')

@section('title', __('Donate') . ' - ' . __('Neerodai Trust'))

@section('content')

@php
    // Read from config/services.php instead of env() so it still works after `php artisan config:cache`.
    // Add to config/services.php:  'ngo' => ['gstin' => env('NGO_GSTIN')],
    $gstin = config('services.ngo.gstin');

    // Texts used by the payment script below (English / Tamil)
    $jsText = [
    'select'      => __('Select an amount to continue'),
    'donateBtn'   => __('Donate ₹:amount Now'),
    'needAmount'  => __('Please select or enter a donation amount.'),
    'needName'    => __('Full name is required.'),
    'needEmail'   => __('Please enter a valid email address.'),
    'needPhone'   => __('Phone must be exactly 10 digits.'),
    'needPincode' => __('Pincode must be exactly 6 digits.'),
    'badPan'      => __('PAN format is invalid. Example: ABCDE1234F'),
    'needGstin'   => __('Please enter a valid 15-character GSTIN.'),
    'needCompany' => __('Company / entity name is required for GST invoice.'),
    'creating'    => __('Creating order…'),
    'noOrder'     => __('Order ID not received.'),
    'verifying'   => __('Verifying payment…'),
    'verifyFail'  => __('Verification failed.'),
    'savePayId'   => __('Please save your Payment ID: :id and contact us.'),
    'panOk'       => __('Valid PAN format'),
    'panHint'     => __('5 letters · 4 digits · 1 letter (e.g. ABCDE1234F)'),
    'gstinOk'     => __('GSTIN length valid'),
    'gstinCount'  => __(':count / 15 characters'),
    'donor'       => __('Donor'),
    'thanks'      => __('Thank you, :name!'),
    'received'    => __('Your donation of :amount has been received.'),
    'paymentId'   => __('Payment ID'),
    'donation'    => __('Donation'),
    'gst'         => __('GST (18%)'),
    'totalPaid'   => __('Total Paid'),
    'deduction'   => __('Your 80G Deduction'),
    'certSent'    => __('80G certificate sent to your email. Keep it for your income tax filing.'),
    'certGstSent' => __('80G certificate + GST invoice sent to your email. Keep it for your income tax filing.'),
    'backHome'    => __('Back to Home'),
    'share'       => __('Share'),
    'shareText'   => __('I just donated to Neerodai Trust to support elders 💚'),
  ];

    $amounts = [
        ['value' => 300,  'label' => 'Feeds 3 elders',   'icon' => 'bi-egg-fried'],
        ['value' => 500,  'label' => 'Feeds 5 elders',   'icon' => 'bi-basket2'],
        ['value' => 1000, 'label' => '10 elders / day',  'icon' => 'bi-people'],
        ['value' => 2000, 'label' => 'Sponsor a week',   'icon' => 'bi-calendar-heart'],
    ];

    $leaf = '<path d="M50 158 C50 110 50 70 50 40 M50 40 C20 40 5 15 5 2 C30 2 50 20 50 40 Z M50 85 C80 85 95 60 95 45 C70 45 50 65 50 85 Z M50 120 C22 120 8 98 8 85 C32 85 50 102 50 120 Z"/>';
@endphp

<div class="dn">

{{-- ================= BANNER ================= --}}
<section class="dn-banner">
    <div class="dn-banner-overlay"></div>
    <svg class="dn-banner-leaf dn-bl-1" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
    <svg class="dn-banner-leaf dn-bl-2" viewBox="0 0 100 160" aria-hidden="true">{!! $leaf !!}</svg>
    <div class="container dn-banner-content">
        <nav aria-label="breadcrumb" class="dn-crumb">
            <a href="{{ url('/') }}">{{ __('Home') }}</a> <i class="bi bi-chevron-right"></i> <span>{{ __('Donate') }}</span>
        </nav>
        <span class="dn-pill"><i class="bi bi-bank2"></i> {{ __('Registered NGO · Tamil Nadu') }}</span>
        <h1>{{ __('Help us feed') }} <span>{{ __('elderly lives.') }}</span></h1>
        <p>{{ __('Every donation provides daily meals and care to elders who have no one. Your support reaches them directly.') }}</p>
        <span class="dn-gold-bar"></span>
    </div>
    <svg class="dn-banner-wave" viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true">
        <path class="w1" d="M0 30 C 400 0, 1000 60, 1440 10 L1440 60 L0 60 Z"/>
        <path class="w2" d="M0 42 C 420 10, 1000 70, 1440 25 L1440 60 L0 60 Z"/>
    </svg>
</section>

{{-- ================= MAIN ================= --}}
<section class="dn-section">
    <div class="container">
        <div class="row g-4 g-xl-5 align-items-start">

            {{-- ---------- FORM (first on mobile) ---------- --}}
            <div class="col-lg-7 order-1 order-lg-2">
                <div class="dn-card" id="donation-card">

                    <div class="dn-card-head">
                        <span class="dn-card-icon"><i class="bi bi-heart-fill"></i></span>
                        <div>
                            <h2>{{ __('Make a Donation') }}</h2>
                            <p>{{ __('80G receipt will be emailed to you instantly') }}</p>
                        </div>
                    </div>

                    {{-- STEP 1: AMOUNT --}}
                    <div class="dn-step">
                        <div class="dn-step-title"><span>1</span> {{ __('Choose Amount') }}</div>

                        <div class="dn-amounts">
                            @foreach($amounts as $a)
                                <button type="button" class="amount-btn" data-amount="{{ $a['value'] }}" aria-pressed="false">
                                    <i class="bi {{ $a['icon'] }}"></i>
                                    <strong>₹{{ number_format($a['value']) }}</strong>
                                    <span>{{ __($a['label']) }}</span>
                                </button>
                            @endforeach
                        </div>

                        <label class="dn-custom">
                            <span class="dn-rupee">₹</span>
                            <input id="custom-amount" type="number" min="1" step="1" inputmode="numeric"
                                   placeholder="{{ __('Or enter custom amount') }}" aria-label="{{ __('Custom amount') }}">
                        </label>
                    </div>

                    {{-- STEP 2: DETAILS --}}
                    <div class="dn-step">
                        <div class="dn-step-title"><span>2</span> {{ __('Your Details') }}</div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="dn-input"><i class="bi bi-person-fill"></i>
                                    <input type="text" id="donor-name" placeholder="{{ __('Full Name') }} *" autocomplete="name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="dn-input"><i class="bi bi-envelope-fill"></i>
                                    <input type="email" id="donor-email" placeholder="{{ __('Email') }} *" autocomplete="email" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="dn-input"><i class="bi bi-telephone-fill"></i>
                                    <input type="tel" id="donor-phone" placeholder="{{ __('Phone (10 digits)') }} *" maxlength="10" inputmode="numeric" autocomplete="tel-national" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="dn-input"><i class="bi bi-mailbox"></i>
                                    <input type="text" id="donor-pincode" placeholder="{{ __('Pincode') }} *" maxlength="6" inputmode="numeric" autocomplete="postal-code" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="dn-input"><i class="bi bi-geo-alt-fill"></i>
                                    <input type="text" id="donor-address" placeholder="{{ __('Address (optional)') }}" autocomplete="street-address">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 3: TAX --}}
                    <div class="dn-step">
                        <div class="dn-step-title"><span>3</span> {{ __('Tax Benefits') }}</div>

                        <div class="dn-box">
                            <div class="dn-box-head">
                                <span class="dn-box-icon"><i class="bi bi-person-vcard"></i></span>
                                <div>
                                    <strong>{{ __('PAN Number') }}</strong>
                                    <small>{{ __('Needed for your 80G tax certificate') }}</small>
                                </div>
                            </div>
                            <input type="text" id="donor-pan" class="dn-pan" placeholder="ABCDE1234F" maxlength="10" autocomplete="off" aria-describedby="pan-hint">
                            <div class="pan-hint" id="pan-hint" aria-live="polite"></div>
                        </div>

                        <div class="dn-box">
                            <label class="dn-toggle-label">
                                <input type="checkbox" id="gst-toggle">
                                <span class="toggle-track"><span class="toggle-thumb"></span></span>
                                <span>
                                    <strong>{{ __('I need a GST Invoice') }}</strong>
                                    <small>{{ __('18% GST will be added to your donation') }}</small>
                                </span>
                            </label>

                            <div id="gst-fields" class="gst-fields" style="display:none;">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="dn-mini" for="gst-number">GSTIN *</label>
                                        <input type="text" id="gst-number" class="dn-plain dn-upper" placeholder="29AABCT1332L1ZD" maxlength="15">
                                        <div class="gstin-hint" id="gstin-hint"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="dn-mini" for="company-name">{{ __('Company / Entity Name') }} *</label>
                                        <input type="text" id="company-name" class="dn-plain" placeholder="{{ __('As per GST registration') }}">
                                    </div>
                                </div>
                                <p class="dn-note"><i class="bi bi-envelope-check"></i> {{ __('GST invoice will be emailed along with your 80G receipt.') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- SUMMARY --}}
                    <div id="amount-summary" class="dn-summary" style="display:none;">
                        <div class="sum-row"><span>{{ __('Donation Amount') }}</span><span id="sum-base">₹0</span></div>
                        <div class="sum-row" id="sum-gst-row" style="display:none;"><span>{{ __('GST (18%)') }}</span><span id="sum-gst">₹0</span></div>
                        <div class="sum-row sum-total"><span>{{ __('Total Payable') }}</span><span id="sum-total">₹0</span></div>
                        <div class="sum-row sum-deduction"><span><i class="bi bi-receipt"></i> {{ __('80G deduction (50% of donation)') }}</span><span id="sum-deduction">₹0</span></div>
                    </div>

                    <div class="dn-error" id="form-error" role="alert" hidden></div>

                    <button id="rzp-button" class="dn-donate-btn" disabled>
                        <i class="bi bi-heart-fill"></i>
                        <span id="btn-text">{{ __('Select an amount to continue') }}</span>
                    </button>

                    <p class="dn-secure">
                        <i class="bi bi-shield-lock-fill"></i> {{ __('Secured by Razorpay · PCI-DSS · 256-bit SSL · No card data stored') }}
                    </p>
                </div>
            </div>

            {{-- ---------- LEFT: STORY + TRUST ---------- --}}
            <div class="col-lg-5 order-2 order-lg-1">
                <div class="dn-photo">
                    <img src="{{ asset('user/frontend/donate.jpg') }}" alt="{{ __('An elder supported by Neerodai Trust') }}">
                    <div class="dn-photo-quote">
                        <i class="bi bi-quote"></i>
                        <p>{{ __('Your kindness today is a warm meal for an elder tomorrow.') }}</p>
                    </div>
                </div>

                <div class="dn-certs">
                    <div class="dn-cert">
                        <span><i class="bi bi-file-earmark-check-fill"></i></span>
                        <div><strong>{{ __('80G Certified') }}</strong><small>{{ __('50% tax deduction') }}</small></div>
                    </div>
                    <div class="dn-cert">
                        <span><i class="bi bi-patch-check-fill"></i></span>
                        <div><strong>{{ __('10A / 12A Trust') }}</strong><small>{{ __('Tax exempt NGO') }}</small></div>
                    </div>
                    @if($gstin)
                        <div class="dn-cert">
                            <span><i class="bi bi-receipt-cutoff"></i></span>
                            <div><strong>{{ __('GST Registered') }}</strong><small>GSTIN: {{ $gstin }}</small></div>
                        </div>
                    @endif
                    <div class="dn-cert">
                        <span><i class="bi bi-shield-lock-fill"></i></span>
                        <div><strong>{{ __('Secure Payments') }}</strong><small>Razorpay PCI-DSS</small></div>
                    </div>
                </div>

                <div class="dn-how">
                    <h3>{{ __('How your gift helps') }}</h3>
                    <ol>
                        <li><span><i class="bi bi-credit-card"></i></span><div><strong>{{ __('You donate') }}</strong><small>{{ __('Pay securely by UPI, card or net banking') }}</small></div></li>
                        <li><span><i class="bi bi-basket2"></i></span><div><strong>{{ __('We prepare meals') }}</strong><small>{{ __('Fresh, nutritious food every day') }}</small></div></li>
                        <li><span><i class="bi bi-emoji-smile"></i></span><div><strong>{{ __('An elder is cared for') }}</strong><small>{{ __('Food, care and a friendly face') }}</small></div></li>
                    </ol>
                </div>

                <a href="https://wa.me/918110079041?text=Hello%20Neerodai%20Team%2C%20I%20have%20a%20question%20about%20donating." target="_blank" rel="noopener" class="dn-help">
                    <i class="fab fa-whatsapp"></i>
                    <span><strong>{{ __('Need help donating?') }}</strong><small>{{ __('Chat with us on WhatsApp') }}</small></span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>
</section>

{{-- ================= FAQ ================= --}}
<section class="dn-faq-wrap">
    <div class="container">
        <h2 class="dn-faq-title">{{ __('Frequently Asked Questions') }}</h2>
        <div class="dn-faq">
            <details>
                <summary>{{ __('Is my donation tax-deductible?') }}</summary>
                <p>{{ __('Yes. Donations to Neerodai Trust are eligible for a 50% deduction under Section 80G. Enter your PAN so we can issue your certificate.') }}</p>
            </details>
            <details>
                <summary>{{ __('When will I get my receipt?') }}</summary>
                <p>{{ __('Your 80G receipt is emailed to you as soon as the payment is confirmed. Please check your spam folder if you don\'t see it.') }}</p>
            </details>
            <details>
                <summary>{{ __('Is the payment secure?') }}</summary>
                <p>{{ __('Payments are processed by Razorpay, a PCI-DSS compliant gateway. We never see or store your card details.') }}</p>
            </details>
        </div>
    </div>
</section>

</div>

{{-- ════════════════ RAZORPAY + LOGIC ════════════════ --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
(function () {
  'use strict';

  const RZP_KEY  = "{{ $razorpayKey }}";
  const GST_RATE = 0.18;

  // Texts in the visitor's language (English / Tamil). ":x" parts are filled in below.
  const T = @json($jsText);
  function t(key, vars) {
    var s = T[key] || key;
    Object.keys(vars || {}).forEach(function (k) { s = s.split(':' + k).join(vars[k]); });
    return s;
  }

  let baseAmount = null;
  let wantsGST   = false;

  const amountBtns = document.querySelectorAll('.amount-btn');

  // ── Amount presets ──
  amountBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      amountBtns.forEach(function (b) { b.classList.remove('active'); b.setAttribute('aria-pressed', 'false'); });
      this.classList.add('active');
      this.setAttribute('aria-pressed', 'true');
      document.getElementById('custom-amount').value = '';
      baseAmount = parseFloat(this.dataset.amount);
      clearError();
      refreshSummary();
    });
  });

  // ── Custom amount ──
  document.getElementById('custom-amount').addEventListener('input', function () {
    amountBtns.forEach(function (b) { b.classList.remove('active'); b.setAttribute('aria-pressed', 'false'); });
    var v = parseFloat(this.value);
    baseAmount = (v && v >= 1) ? v : null;
    refreshSummary();
  });

  // ── Digits only for phone & pincode ──
  ['donor-phone', 'donor-pincode'].forEach(function (id) {
    document.getElementById(id).addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '');
    });
  });

  // ── GST toggle ──
  document.getElementById('gst-toggle').addEventListener('change', function () {
    wantsGST = this.checked;
    document.getElementById('gst-fields').style.display  = wantsGST ? 'block' : 'none';
    document.getElementById('sum-gst-row').style.display = wantsGST ? 'flex'  : 'none';
    document.querySelector('.toggle-track').classList.toggle('on', wantsGST);
    refreshSummary();
  });

  // ── PAN hint ──
  document.getElementById('donor-pan').addEventListener('input', function () {
    var v = this.value.toUpperCase();
    this.value = v;
    var hint = document.getElementById('pan-hint');
    if (!v) { hint.textContent = ''; hint.className = 'pan-hint'; return; }
    if (/^[A-Z]{5}[0-9]{4}[A-Z]$/.test(v)) {
      hint.innerHTML = '<i class="bi bi-check-circle-fill"></i> ' + esc(t('panOk'));
      hint.className = 'pan-hint valid';
    } else if (v.length === 10) {
      hint.innerHTML = '<i class="bi bi-x-circle-fill"></i> Invalid PAN — format must be ABCDE1234F';
      hint.className = 'pan-hint invalid';
    } else {
      hint.textContent = t('panHint');
      hint.className = 'pan-hint typing';
    }
  });

  // ── GSTIN hint ──
  document.getElementById('gst-number').addEventListener('input', function () {
    var v = this.value.toUpperCase();
    this.value = v;
    var hint = document.getElementById('gstin-hint');
    if (!v) { hint.textContent = ''; return; }
    if (v.length === 15) {
      hint.innerHTML = '<i class="bi bi-check-circle-fill"></i> ' + esc(t('gstinOk'));
      hint.className = 'gstin-hint valid';
    } else {
      hint.textContent = t('gstinCount', { count: v.length });
      hint.className = 'gstin-hint typing';
    }
  });

  // ── Summary ──
  function refreshSummary() {
    var summaryEl = document.getElementById('amount-summary');
    var btnEl     = document.getElementById('rzp-button');
    var btnText   = document.getElementById('btn-text');

    if (!baseAmount || baseAmount < 1) {
      summaryEl.style.display = 'none';
      btnEl.disabled          = true;
      btnText.textContent     = t('select');
      return;
    }

    var gst    = wantsGST ? Math.round(baseAmount * GST_RATE) : 0;
    var total  = baseAmount + gst;
    var deduct = Math.round(baseAmount * 0.5);

    document.getElementById('sum-base').textContent      = '₹' + inr(baseAmount);
    document.getElementById('sum-gst').textContent       = '₹' + inr(gst);
    document.getElementById('sum-total').textContent     = '₹' + inr(total);
    document.getElementById('sum-deduction').textContent = '₹' + inr(deduct);

    summaryEl.style.display = 'block';
    btnEl.disabled          = false;
    btnText.textContent     = t('donateBtn', { amount: inr(total) });
  }

  function inr(n) { return Number(n).toLocaleString('en-IN'); }

  // ── Validation (inline messages instead of alert boxes) ──
  function validate() {
    var name = g('donor-name'), email = g('donor-email'), phone = g('donor-phone');
    var pincode = g('donor-pincode'), pan = g('donor-pan'), gstin = g('gst-number'), company = g('company-name');

    if (!baseAmount || baseAmount < 1)                         return warn(t('needAmount'), 'custom-amount');
    if (!name)                                                 return warn(t('needName'), 'donor-name');
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))   return warn(t('needEmail'), 'donor-email');
    if (!phone || !/^\d{10}$/.test(phone))                     return warn(t('needPhone'), 'donor-phone');
    if (!pincode || !/^\d{6}$/.test(pincode))                  return warn(t('needPincode'), 'donor-pincode');
    if (pan && !/^[A-Z]{5}[0-9]{4}[A-Z]$/i.test(pan))          return warn(t('badPan'), 'donor-pan');
    if (wantsGST) {
      if (!gstin || gstin.replace(/\s/g, '').length !== 15)    return warn(t('needGstin'), 'gst-number');
      if (!company)                                            return warn(t('needCompany'), 'company-name');
    }
    clearError();
    return true;
  }

  function g(id) { var el = document.getElementById(id); return el ? el.value.trim() : ''; }

  function warn(msg, fieldId) {
    var box = document.getElementById('form-error');
    box.innerHTML = '<i class="bi bi-exclamation-circle-fill"></i> <span>' + esc(msg) + '</span>';
    box.hidden = false;
    document.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
    if (fieldId) {
      var f = document.getElementById(fieldId);
      if (f) {
        (f.closest('.dn-input, .dn-custom') || f).classList.add('is-invalid');
        f.focus();
      }
    }
    return false;
  }
  function clearError() {
    var box = document.getElementById('form-error');
    if (box) { box.hidden = true; box.innerHTML = ''; }
    document.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
  }
  document.querySelectorAll('#donation-card input').forEach(function (i) {
    i.addEventListener('input', function () { (this.closest('.dn-input, .dn-custom') || this).classList.remove('is-invalid'); });
  });

  // ── Razorpay flow ──
  document.getElementById('rzp-button').addEventListener('click', async function (e) {
    e.preventDefault();
    if (!validate()) return;

    var name = g('donor-name'), email = g('donor-email'), phone = g('donor-phone');
    var address = g('donor-address'), pincode = g('donor-pincode'), pan = g('donor-pan');
    var gstNumber = g('gst-number'), companyName = g('company-name');

    var gst   = wantsGST ? Math.round(baseAmount * GST_RATE) : 0;
    var total = baseAmount + gst;

    var btn = document.getElementById('rzp-button');
    var btnTxt = document.getElementById('btn-text');
    btn.disabled = true;
    btn.classList.add('is-loading');
    btnTxt.textContent = t('creating');

    var payload = {
      amount: total, base_amount: baseAmount, gst_amount: gst, wants_gst: wantsGST,
      gst_number: gstNumber, company_name: companyName,
      name: name, email: email, phone: phone, pincode: pincode, address: address, pan: pan
    };

    try {
      var orderRes = await fetch("{{ route('create.order') }}", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify(payload)
      });
      var orderJson = await orderRes.json();
      if (!orderJson.orderId) throw new Error(orderJson.message || t('noOrder'));

      var options = {
        key: RZP_KEY,
        amount: Math.round(total * 100),
        currency: orderJson.currency || 'INR',
        name: 'Neerodai Trust',
        description: 'Donation ₹' + inr(baseAmount) + (wantsGST ? ' + GST ₹' + inr(gst) : '') + ' | 80G',
        order_id: orderJson.orderId,
        prefill: { name: name, email: email, contact: phone },
        notes: { pan: pan, gst_number: gstNumber, pincode: pincode },
        theme: { color: '#12823f' },

        handler: async function (response) {
          btnTxt.textContent = t('verifying');
          try {
            var verifyRes = await fetch("{{ route('payment.success') }}", {
              method: 'POST',
              headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
              body: JSON.stringify(Object.assign({
                razorpay_order_id: response.razorpay_order_id,
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_signature: response.razorpay_signature
              }, payload))
            });
            var verifyJson = await verifyRes.json();
            if (verifyJson.status === 'success') {
              showSuccess(response.razorpay_payment_id, total, baseAmount, gst);
            } else {
              throw new Error(verifyJson.message || t('verifyFail'));
            }
          } catch (err) {
            warn(err.message + ' ' + t('savePayId', { id: response.razorpay_payment_id }));
            resetBtn(total);
          }
        },
        modal: { ondismiss: function () { resetBtn(total); } }
      };

      new Razorpay(options).open();
    } catch (ex) {
      warn(ex.message);
      resetBtn(total);
    }
  });

  function resetBtn(total) {
    var btn = document.getElementById('rzp-button');
    btn.disabled = false;
    btn.classList.remove('is-loading');
    document.getElementById('btn-text').textContent = 'Donate ₹' + inr(total) + ' Now';
  }

  // ── Success screen ──
  function showSuccess(paymentId, total, base, gst) {
    var card = document.getElementById('donation-card');
    var donor = g('donor-name') || t('donor');
    card.innerHTML =
      '<div class="dn-success">' +
        '<div class="dn-success-icon"><i class="bi bi-heart-fill"></i></div>' +
        '<h3>' + esc(t('thanks', { name: donor })) + '</h3>' +
        '<p>' + esc(t('received', { amount: '@@AMT@@' })).replace('@@AMT@@', '<strong>₹' + inr(total) + '</strong>') + '</p>' +
        '<div class="dn-receipt">' +
          '<div class="receipt-row"><span>' + esc(t('paymentId')) + '</span><code>' + esc(paymentId) + '</code></div>' +
          '<div class="receipt-row"><span>' + esc(t('donation')) + '</span><span>₹' + inr(base) + '</span></div>' +
          (gst > 0 ? '<div class="receipt-row"><span>' + esc(t('gst')) + '</span><span>₹' + inr(gst) + '</span></div>' : '') +
          '<div class="receipt-row receipt-total"><span>' + esc(t('totalPaid')) + '</span><span>₹' + inr(total) + '</span></div>' +
          '<div class="receipt-row receipt-deduction"><span>' + esc(t('deduction')) + '</span><span>₹' + inr(Math.round(base * 0.5)) + '</span></div>' +
        '</div>' +
        '<p class="dn-receipt-note"><i class="bi bi-envelope-check"></i> ' + esc(t(gst > 0 ? 'certGstSent' : 'certSent')) + '</p>' +
        '<div class="dn-success-actions">' +
          '<a href="{{ url('/') }}" class="dn-btn-outline"><i class="bi bi-house"></i> ' + esc(t('backHome')) + '</a>' +
          '<a href="https://wa.me/?text=' + encodeURIComponent(t('shareText') + ' ' + '{{ url('/pay') }}') + '" target="_blank" rel="noopener" class="dn-btn-green"><i class="fab fa-whatsapp"></i> ' + esc(t('share')) + '</a>' +
        '</div>' +
      '</div>';
    card.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function esc(s) {
    return String(s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }
})();
</script>

@endsection

@push('styles')
<style>
.dn {
    --g: #12823f;
    --g-dark: #0b5e2d;
    --g-soft: #eaf6ee;
    --ink: #1d2b24;
    --muted: #5d6b64;
    --line: #dfe8e2;
    --gold: #ffc61a;
    font-family: 'Poppins', 'Noto Sans Tamil', system-ui, sans-serif;
    color: var(--ink);
    background: #fff;
    overflow-x: hidden;
}
.dn a { text-decoration: none; }
.dn h1, .dn h2, .dn h3 { font-family: inherit; }

/* Banner */
.dn-banner {
    position: relative; overflow: hidden; padding: 64px 0 100px;
    background: radial-gradient(circle at 80% 30%, #3fa45b 0%, #12823f 35%, #0a4a26 100%);
}
.dn-banner-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(8,59,31,.8), rgba(8,59,31,.2)); }
.dn-banner-content { position: relative; z-index: 2; max-width: 760px; margin-left: auto; margin-right: auto; text-align: center; }
.dn-crumb { font-size: .88rem; color: rgba(255,255,255,.8); margin-bottom: 1rem; }
.dn-crumb a { color: #fff; }
.dn-crumb a:hover { color: var(--gold); }
.dn-crumb i { font-size: .7rem; margin: 0 .35rem; }
.dn-pill { display: inline-flex; align-items: center; gap: .45rem; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.25); color: #fff; font-size: .78rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; padding: .4rem 1rem; border-radius: 50px; margin-bottom: 1rem; }
.dn-pill i { color: var(--gold); }
.dn-banner h1 { color: #fff; font-size: clamp(2.2rem, 5vw, 3.4rem); font-weight: 800; line-height: 1.15; margin-bottom: .7rem; }
.dn-banner h1 span { color: var(--gold); }
.dn-banner p { color: rgba(255,255,255,.9); font-size: 1.08rem; line-height: 1.7; margin: 0 auto 1rem; max-width: 600px; }
.dn-gold-bar { display: block; width: 80px; height: 5px; border-radius: 5px; background: var(--gold); margin: 0 auto; }
.dn-banner-leaf { position: absolute; z-index: 1; }
.dn-banner-leaf path { fill: rgba(255,255,255,.1); stroke: rgba(255,255,255,.15); stroke-width: 2; }
.dn-bl-1 { right: 6%; top: 10px; width: 150px; transform: rotate(25deg); }
.dn-bl-2 { left: 5%; bottom: 30px; width: 90px; transform: rotate(-25deg); }
.dn-banner-wave { position: absolute; left: 0; bottom: -1px; width: 100%; height: 60px; z-index: 2; }
.dn-banner-wave .w1 { fill: #bfe3c7; }
.dn-banner-wave .w2 { fill: #fff; }

.dn-section { padding: 10px 0 60px; }

/* ---------- Form card ---------- */
.dn-card {
    position: relative; z-index: 3; background: #fff; border-radius: 20px; padding: 2rem;
    border: 1px solid #e8f0ea; box-shadow: 0 18px 50px rgba(10,74,38,.12); margin-top: -40px;
}
.dn-card-head { display: flex; align-items: center; gap: 1rem; padding-bottom: 1.2rem; margin-bottom: 1.4rem; border-bottom: 1px dashed var(--line); }
.dn-card-icon { width: 56px; height: 56px; flex: 0 0 56px; border-radius: 50%; display: grid; place-items: center; background: var(--g); color: #fff; font-size: 1.4rem; box-shadow: 0 8px 18px rgba(18,130,63,.3); }
.dn-card-head h2 { font-size: 1.6rem; font-weight: 700; color: var(--g-dark); margin: 0 0 .1rem; }
.dn-card-head p { color: var(--muted); font-size: .9rem; margin: 0; }

.dn-step { margin-bottom: 1.6rem; }
.dn-step-title { display: flex; align-items: center; gap: .6rem; font-weight: 700; font-size: 1rem; margin-bottom: .9rem; }
.dn-step-title span { width: 28px; height: 28px; display: grid; place-items: center; border-radius: 50%; background: var(--g-soft); color: var(--g-dark); font-size: .85rem; font-weight: 800; }

/* Amount buttons */
.dn-amounts { display: grid; grid-template-columns: repeat(4, 1fr); gap: .7rem; margin-bottom: .8rem; }
.amount-btn {
    position: relative; border: 2px solid var(--line); background: #fff; border-radius: 14px; padding: .9rem .6rem;
    text-align: center; cursor: pointer; transition: all .2s ease; font-family: inherit;
}
.amount-btn i { display: block; font-size: 1.3rem; color: var(--g); margin-bottom: .2rem; }
.amount-btn strong { display: block; font-size: 1.15rem; font-weight: 800; color: var(--ink); }
.amount-btn span { display: block; font-size: .72rem; color: var(--muted); margin-top: 2px; }
.amount-btn:hover { border-color: var(--g); transform: translateY(-2px); }
.amount-btn.active { border-color: var(--g); background: var(--g); box-shadow: 0 8px 18px rgba(18,130,63,.3); }
.amount-btn.active i, .amount-btn.active strong, .amount-btn.active span { color: #fff; }
.amount-btn.active::after { content: "\F26E"; font-family: "bootstrap-icons"; position: absolute; top: 6px; right: 8px; color: var(--gold); font-size: .9rem; }

.dn-custom { display: flex; align-items: center; border: 2px solid var(--line); border-radius: 12px; padding: 0 1rem; transition: border-color .2s, box-shadow .2s; margin: 0; }
.dn-custom:focus-within { border-color: var(--g); box-shadow: 0 0 0 4px rgba(18,130,63,.12); }
.dn-rupee { font-weight: 800; color: var(--g-dark); font-size: 1.1rem; }
.dn-custom input { border: 0; outline: 0; width: 100%; padding: .85rem .5rem; font-size: 1rem; font-weight: 600; background: transparent; }

/* Inputs */
.dn-input { position: relative; display: flex; align-items: center; border: 1.5px solid var(--line); border-radius: 10px; transition: border-color .2s, box-shadow .2s; }
.dn-input i { position: absolute; left: 13px; color: var(--g-dark); font-size: .95rem; pointer-events: none; }
.dn-input input { width: 100%; border: 0; outline: 0; background: transparent; padding: .78rem .9rem .78rem 2.5rem; font-size: .95rem; border-radius: 10px; }
.dn-input:focus-within { border-color: var(--g); box-shadow: 0 0 0 4px rgba(18,130,63,.12); }
.dn-input.is-invalid, .dn-custom.is-invalid, .dn-plain.is-invalid, .dn-pan.is-invalid { border-color: #d64534 !important; }
.dn input::placeholder { color: #a4aea8; }

/* Tax boxes */
.dn-box { background: #f7fbf8; border: 1.5px solid var(--line); border-radius: 14px; padding: 1rem 1.1rem; margin-bottom: .8rem; }
.dn-box-head { display: flex; align-items: center; gap: .8rem; margin-bottom: .7rem; }
.dn-box-icon { width: 40px; height: 40px; flex: 0 0 40px; border-radius: 10px; background: #fff; display: grid; place-items: center; color: var(--g); font-size: 1.2rem; border: 1px solid var(--line); }
.dn-box strong { display: block; font-size: .92rem; font-weight: 700; }
.dn-box small { display: block; font-size: .78rem; color: var(--muted); }
.dn-pan, .dn-plain { width: 100%; border: 1.5px solid var(--line); border-radius: 10px; padding: .75rem .9rem; font-size: .95rem; background: #fff; outline: 0; transition: border-color .2s, box-shadow .2s; }
.dn-pan { font-size: 1.05rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; }
.dn-upper { text-transform: uppercase; letter-spacing: .05em; }
.dn-pan:focus, .dn-plain:focus { border-color: var(--g); box-shadow: 0 0 0 4px rgba(18,130,63,.12); }
.pan-hint, .gstin-hint { font-size: .78rem; margin-top: .35rem; min-height: 1rem; }
.pan-hint.valid, .gstin-hint.valid { color: var(--g); font-weight: 600; }
.pan-hint.invalid { color: #d64534; font-weight: 600; }
.pan-hint.typing, .gstin-hint.typing { color: var(--muted); }

.dn-toggle-label { display: flex; align-items: center; gap: .85rem; cursor: pointer; user-select: none; margin: 0; }
.dn-toggle-label input { position: absolute; opacity: 0; pointer-events: none; }
.toggle-track { position: relative; width: 46px; height: 26px; flex: 0 0 46px; border-radius: 13px; background: #c9d3cd; transition: background .25s; }
.toggle-track.on { background: var(--g); }
.toggle-thumb { position: absolute; top: 3px; left: 3px; width: 20px; height: 20px; border-radius: 50%; background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,.2); transition: left .25s; }
.toggle-track.on .toggle-thumb { left: 23px; }
.dn-toggle-label input:focus-visible + .toggle-track { outline: 3px solid rgba(18,130,63,.35); outline-offset: 2px; }
.gst-fields { margin-top: 1rem; animation: dnDown .2s ease; }
@keyframes dnDown { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: none; } }
.dn-mini { display: block; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); margin-bottom: .3rem; }
.dn-note { background: var(--g-soft); color: var(--g-dark); border-radius: 8px; padding: .55rem .8rem; font-size: .8rem; font-weight: 500; margin: .8rem 0 0; }

/* Summary */
.dn-summary { background: linear-gradient(120deg, #eef8f1, #e2f2e6); border: 1px solid #cfe8d5; border-radius: 14px; padding: 1rem 1.2rem; margin-bottom: 1rem; animation: dnDown .2s ease; }
.sum-row { display: flex; justify-content: space-between; gap: 1rem; font-size: .92rem; color: var(--muted); padding: .2rem 0; }
.sum-total { border-top: 1px dashed #b9dcc2; margin-top: .4rem; padding-top: .6rem; font-weight: 800; font-size: 1.1rem; color: var(--ink); }
.sum-deduction { color: var(--g); font-size: .82rem; font-weight: 500; }

/* Errors */
.dn-error { display: flex; gap: .6rem; align-items: flex-start; background: #fdeeee; color: #a12a2a; border: 1px solid #f5c6c6; border-radius: 12px; padding: .8rem 1rem; font-size: .9rem; font-weight: 500; margin-bottom: 1rem; }
.dn-error[hidden] { display: none; }

/* Donate button */
.dn-donate-btn {
    width: 100%; display: flex; align-items: center; justify-content: center; gap: .6rem;
    background: var(--gold); color: var(--ink); border: 0; border-radius: 50px; padding: 1rem 1.5rem;
    font-family: inherit; font-size: 1.1rem; font-weight: 800; cursor: pointer;
    box-shadow: 0 10px 24px rgba(255,198,26,.4); transition: all .25s ease;
}
.dn-donate-btn i { color: #d64534; }
.dn-donate-btn:hover:not(:disabled) { background: #ffd34d; transform: translateY(-2px); }
.dn-donate-btn:disabled { background: #e5ebe7; color: #8a978f; box-shadow: none; cursor: not-allowed; }
.dn-donate-btn:disabled i { color: #b4beb8; }
.dn-donate-btn.is-loading i { animation: dnBeat 1s ease-in-out infinite; }
@keyframes dnBeat { 50% { transform: scale(1.25); } }
.dn-secure { text-align: center; font-size: .78rem; color: var(--muted); margin: .9rem 0 0; }
.dn-secure i { color: var(--g); }

/* ---------- Left column ---------- */
.dn-photo { position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 16px 40px rgba(10,74,38,.15); }
.dn-photo img { display: block; width: 100%; height: 420px; object-fit: cover; }
.dn-photo-quote {
    position: absolute; left: 16px; right: 16px; bottom: 16px; padding: 1rem 1.2rem; border-radius: 14px;
    background: rgba(11,94,45,.88); backdrop-filter: blur(6px); color: #fff;
}
.dn-photo-quote i { color: var(--gold); font-size: 1.8rem; line-height: 1; }
.dn-photo-quote p { margin: .1rem 0 0; font-size: 1rem; font-weight: 500; line-height: 1.5; }

.dn-certs { display: grid; grid-template-columns: 1fr 1fr; gap: .7rem; margin-top: 1.2rem; }
.dn-cert { display: flex; align-items: center; gap: .7rem; background: #fff; border: 1px solid #e3ede6; border-radius: 12px; padding: .8rem .9rem; box-shadow: 0 4px 12px rgba(10,74,38,.05); }
.dn-cert > span { width: 38px; height: 38px; flex: 0 0 38px; border-radius: 10px; background: var(--g-soft); color: var(--g); display: grid; place-items: center; font-size: 1.15rem; }
.dn-cert strong { display: block; font-size: .85rem; font-weight: 700; }
.dn-cert small { display: block; font-size: .72rem; color: var(--muted); word-break: break-all; }

.dn-how { margin-top: 1.4rem; background: var(--g-soft); border-radius: 16px; padding: 1.3rem 1.3rem 1rem; }
.dn-how h3 { font-size: 1.1rem; font-weight: 700; color: var(--g-dark); margin-bottom: 1rem; }
.dn-how ol { list-style: none; padding: 0; margin: 0; }
.dn-how li { position: relative; display: flex; gap: .8rem; padding-bottom: 1rem; }
.dn-how li:not(:last-child)::before { content: ""; position: absolute; left: 19px; top: 40px; bottom: 4px; width: 2px; background: #b9dcc2; }
.dn-how li > span { width: 40px; height: 40px; flex: 0 0 40px; border-radius: 50%; background: var(--g); color: #fff; display: grid; place-items: center; font-size: 1rem; }
.dn-how strong { display: block; font-size: .92rem; }
.dn-how small { display: block; font-size: .8rem; color: var(--muted); }

.dn-help { display: flex; align-items: center; gap: .9rem; margin-top: 1rem; padding: .9rem 1.1rem; border-radius: 14px; border: 1.5px solid #c5ead1; background: #fff; color: var(--ink); transition: all .2s; }
.dn-help:hover { border-color: #25d366; color: var(--ink); transform: translateY(-2px); }
.dn-help .fa-whatsapp { font-size: 1.8rem; color: #25d366; }
.dn-help span { flex: 1; }
.dn-help strong { display: block; font-size: .92rem; }
.dn-help small { display: block; font-size: .8rem; color: var(--muted); }
.dn-help .bi-arrow-right { color: var(--g); }

/* ---------- Success ---------- */
.dn-success { text-align: center; padding: 1rem 0; animation: dnUp .4s ease; }
@keyframes dnUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
.dn-success-icon { width: 84px; height: 84px; margin: 0 auto 1rem; border-radius: 50%; background: var(--g-soft); color: var(--g); display: grid; place-items: center; font-size: 2.4rem; box-shadow: 0 0 0 10px rgba(18,130,63,.07); }
.dn-success h3 { font-size: 1.7rem; font-weight: 800; color: var(--g-dark); margin-bottom: .4rem; }
.dn-success > p { color: var(--muted); }
.dn-receipt { background: #f7fbf8; border: 1px solid var(--line); border-radius: 14px; padding: 1rem 1.2rem; margin: 1.2rem 0; text-align: left; }
.receipt-row { display: flex; justify-content: space-between; gap: 1rem; font-size: .9rem; color: var(--muted); padding: .4rem 0; border-bottom: 1px dashed var(--line); }
.receipt-row:last-child { border: 0; }
.receipt-row code { font-size: .78rem; color: var(--g-dark); word-break: break-all; text-align: right; }
.receipt-total { font-weight: 800; color: var(--ink); font-size: 1rem; }
.receipt-deduction { color: var(--g); font-weight: 500; }
.dn-receipt-note { font-size: .85rem; color: var(--muted); }
.dn-receipt-note i { color: var(--g); }
.dn-success-actions { display: flex; justify-content: center; flex-wrap: wrap; gap: .7rem; margin-top: 1rem; }
.dn-btn-outline, .dn-btn-green { display: inline-flex; align-items: center; gap: .45rem; padding: .7rem 1.4rem; border-radius: 50px; font-weight: 600; font-size: .92rem; }
.dn-btn-outline { border: 1.5px solid var(--g); color: var(--g-dark); }
.dn-btn-outline:hover { background: var(--g-soft); color: var(--g-dark); }
.dn-btn-green { background: var(--g); color: #fff; }
.dn-btn-green:hover { background: var(--g-dark); color: #fff; }

/* ---------- FAQ ---------- */
.dn-faq-wrap { background: #f6faf7; padding: 60px 0; }
.dn-faq-title { text-align: center; font-size: clamp(1.6rem, 3vw, 2.1rem); font-weight: 700; color: var(--g-dark); margin-bottom: 1.8rem; }
.dn-faq { max-width: 780px; margin: 0 auto; display: grid; gap: .8rem; }
.dn-faq details { background: #fff; border: 1px solid #e3ede6; border-radius: 14px; padding: 0 1.2rem; box-shadow: 0 4px 12px rgba(10,74,38,.04); }
.dn-faq summary { list-style: none; cursor: pointer; padding: 1rem 0; font-weight: 600; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
.dn-faq summary::-webkit-details-marker { display: none; }
.dn-faq summary::after { content: "\F4FE"; font-family: "bootstrap-icons"; color: var(--g); font-size: 1.2rem; transition: transform .2s; }
.dn-faq details[open] summary::after { transform: rotate(45deg); }
.dn-faq details p { color: var(--muted); font-size: .93rem; line-height: 1.7; margin: 0 0 1rem; }

/* ---------- Responsive ---------- */
@media (min-width: 992px) {
    .dn-card { position: sticky; top: 110px; }
}
@media (max-width: 991.98px) {
    .dn-card { margin-top: -50px; }
    .dn-photo img { height: 340px; }
}
@media (max-width: 767.98px) {
    .dn-banner { padding: 48px 0 100px; }
    .dn-bl-2 { display: none; }
    .dn-amounts { grid-template-columns: repeat(2, 1fr); }
    .dn-card { padding: 1.4rem 1.1rem; border-radius: 18px; }
    .dn-card-head h2 { font-size: 1.35rem; }
}
@media (max-width: 420px) {
    .dn-certs { grid-template-columns: 1fr; }
}
@media (prefers-reduced-motion: reduce) { .dn * { transition: none !important; animation: none !important; } }
</style>
@endpush