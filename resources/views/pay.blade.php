@extends('user')

@section('title', 'Donate - Neerodai')

@section('content')
<section class="donate-page py-5" style="background: linear-gradient(135deg, #eafaf1, #ffffff);">
  <div class="container">
    <div class="row align-items-center justify-content-center">

      <!-- Left: Image -->
      <div class="col-lg-6 mb-4 mb-lg-0 text-center">
        <img src="http://localhost/dow-img/donatelady2.jpg" 
             class="img-fluid donate-img" 
             alt="Donate Image">
      </div>

      <!-- Right: Form -->
      <div class="col-lg-6">
        <div class="donation-form glass-card p-4 p-lg-5 rounded-4 shadow-lg">
          <h2 class="text-center mb-3 fw-bold gradient-text">Donate to Neerodai</h2>
          <p class="text-center text-muted mb-4">
            Support our mission to provide meals and care to elderly people in need.  
            Every contribution counts 💚
          </p>

           <div class="d-flex flex-wrap gap-2 justify-content-center mb-3">
            <button type="button" class="amount-btn btn-amount" data-amount="300">₹300</button>
            <button type="button" class="amount-btn btn-amount" data-amount="500">₹500</button>
            <button type="button" class="amount-btn btn-amount" data-amount="1000">₹1000</button>
          </div>

          <!-- Custom Amount -->
          <input id="custom-amount" type="number" min="1" class="form-control form-control-lg mb-3" placeholder="Other amount (₹)">

          <!-- Donor Details -->
          <div class="mb-3">
            <input type="text" id="donor-name" class="form-control form-control-lg" placeholder="Full Name" required>
          </div>
          <div class="mb-3">
            <input type="email" id="donor-email" class="form-control form-control-lg" placeholder="Email" required>
          </div>
          <div class="mb-3">
            <input type="tel" id="donor-phone" class="form-control form-control-lg" placeholder="Phone" required>
          </div>
          <div class="mb-3">
            <input type="text" id="donor-address" class="form-control form-control-lg" placeholder="Address" required>
          </div>
          <div class="mb-3">
            <input type="number" id="donor-pincode" class="form-control form-control-lg" placeholder="Pincode" required>
          </div>

          <!-- Amount Buttons -->
         
          <!-- Donate Button -->
          <button id="rzp-button" class="btn-donate w-100 py-2 fw-bold">Donate Now</button>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Razorpay Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  let selectedAmount = null;

  document.querySelectorAll('.amount-btn').forEach(btn => {
    btn.addEventListener('click', function(){
      selectedAmount = parseFloat(this.getAttribute('data-amount'));
      document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      document.getElementById('custom-amount').value = '';
    });
  });

  document.getElementById('custom-amount').addEventListener('input', function(){
    selectedAmount = parseFloat(this.value) || null;
    document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
  });

  document.getElementById('rzp-button').addEventListener('click', async function(e){
    e.preventDefault();

    let name = document.getElementById('donor-name').value.trim();
    let email = document.getElementById('donor-email').value.trim();
    let phone = document.getElementById('donor-phone').value.trim();
    let address = document.getElementById('donor-address').value.trim();
    let pincode = document.getElementById('donor-pincode').value.trim();

    let amount = selectedAmount;

    if (!amount || amount < 1 || !name || !email || !phone|| !pincode) {
      alert('Please fill all required fields with valid data.');
      return;
    }

    try {
      const res = await fetch("{{ route('create.order') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ amount, name, email, phone, pincode, address })
      });
      const json = await res.json();
      if (!json.orderId) throw new Error('Order ID not received');

      const options = {
        key: "{{ $razorpayKey }}",
        amount: Math.round(amount*100),
        currency: json.currency,
        name: "Neerodai Donation",
        description: `Donation ₹${amount}`,
        order_id: json.orderId,
        prefill: { name, email, pincode, contact: phone },
        handler: async function(response) {
          const verifyRes = await fetch("{{ route('payment.success') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ...response, name, email, phone, address, amount }),
          });
          const verifyJson = await verifyRes.json();
          alert(verifyJson.message || 'Payment processed');
        }
      };

      new Razorpay(options).open();
    } catch (err) {
      alert('Error: ' + err.message);
      console.error(err);
    }
  });
</script>

<!-- Styles -->
<style>
.donate-img {
  border-radius: 20px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.1);
  transition: transform 0.4s ease;
}
.donate-img:hover { transform: scale(1.05); }

.glass-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(25, 135, 84, 0.2);
}

.gradient-text {
  background: linear-gradient(90deg, #198754, #28a745);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.form-control-lg {
  border-radius: 10px;
  padding: 0.7rem 1rem;
  font-size: 1rem;
}

.btn-amount {
  border: 2px solid #198754;
  background: white;
  color: #198754;
  font-weight: 600;
  border-radius: 30px;
  padding: 0.4rem 1.2rem;
  transition: all 0.3s ease;
}
.btn-amount:hover,
.btn-amount.active {
  background: #198754;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
}

.btn-donate {
  background: linear-gradient(90deg, #198754, #28a745);
  color: white;
  border: none;
  border-radius: 30px;
  font-size: 1rem;
  transition: all 0.3s ease;
}
.btn-donate:hover {
  transform: translateY(-2px) scale(1.02);
  box-shadow: 0 6px 16px rgba(25, 135, 84, 0.4);
}

@media(max-width:991px){
  .donate-page .row { flex-direction: column-reverse; }
  .donation-form { margin-top: 20px; }
}
</style>
@endsection
