@extends('user')

@section('title', 'Donate - Neerodai')

@section('content')
<div class="container py-5">
  <h2 class="text-center mb-4">Support Neerodai</h2>
  
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4 shadow rounded">
        <h5 class="mb-3">Choose an amount</h5>

        <div class="d-flex justify-content-between mb-3">
          <button class="btn btn-outline-primary w-30 donate-btn" data-amount="100">$100</button>
          <button class="btn btn-outline-primary w-30 donate-btn" data-amount="500">$500</button>
          <button class="btn btn-outline-primary w-30 donate-btn" data-amount="1000">$1000</button>
        </div>

        <div class="mb-3">
          <label for="customAmount" class="form-label">Or enter custom amount:</label>
          <input type="number" class="form-control" id="customAmount" placeholder="Enter amount in USD">
        </div>

        <button class="btn btn-success w-100" onclick="redirectToRazorpay()">Donate Now</button>
      </div>
    </div>
  </div>
</div>

<style>
  .w-30 {
    width: 30%;
  }
</style>

<script>
  let selectedAmount = 0;

  document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.donate-btn');
    buttons.forEach(btn => {
      btn.addEventListener('click', function () {
        selectedAmount = this.dataset.amount;
        document.getElementById('customAmount').value = ''; // Clear custom
        buttons.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
      });
    });
  });

  function redirectToRazorpay() {
    const customAmount = document.getElementById('customAmount').value;
    const amount = customAmount ? parseInt(customAmount) : parseInt(selectedAmount);

    if (!amount || amount <= 0) {
      alert("Please select or enter a valid amount.");
      return;
    }

    // Redirect to your Razorpay.me link with optional query (if you configured to accept)
    window.location.href = `https://razorpay.me/@rahul5023?amount=${amount}`;
  }
</script>
@endsection
