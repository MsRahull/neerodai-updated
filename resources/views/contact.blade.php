@extends('user')

@section('title', 'Contact Us - Neerodai')

@section('content')
<section class="container py-5">
  <h1 class="text-center mb-4 fw-bold text-dark">Contact Us</h1>
  <p class="text-center text-muted mb-5">
    Have questions or need assistance? Get in touch with us, and we’ll be happy to help.
  </p>

  @if(session('success'))
    <div class="alert alert-success text-center shadow-sm">
      {{ session('success') }}
    </div>
  @endif

  <div class="row g-4">
    <!-- Contact Form -->
    <div class="col-lg-6">
      <div class="card shadow border-0 rounded-3 h-100">
        <div class="card-body p-4">
          <h5 class="fw-bold mb-3 text-greeny">Send Us a Message</h5>
          <form method="POST" action="{{ route('contact.submit') }}">
            @csrf

            <div class="mb-3">
              <label for="name" class="form-label">Your Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control form-control-lg" id="name" placeholder="John Doe" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Your Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="example@email.com" required>
            </div>

            <div class="mb-3">
              <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
              <input type="tel" name="mobile" class="form-control form-control-lg" id="mobile" placeholder="+91 98765 43210" required>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">Your Address <span class="text-danger">*</span></label>
              <textarea name="address" class="form-control form-control-lg" id="address" rows="2" placeholder="Street, City, State" required></textarea>
            </div>

            <div class="mb-3">
              <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
              <textarea name="message" class="form-control form-control-lg" id="message" rows="3" placeholder="Write your message..." required></textarea>
            </div>

            <button type="submit" class="btn btn-greeny w-100 btn-lg shadow-sm">Send Message</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Contact Details + Map -->
    <div class="col-lg-6">
      <div class="card shadow border-0 rounded-3 h-100">
        <div class="card-body p-4">
          <h5 class="fw-bold mb-3 text-greeny">Our Location</h5>
          <p class="mb-1"><i class="bi bi-geo-alt-fill text-danger me-2"></i>PENIEL TRUTH CHURCH, Tamil Nadu, India</p>
          <p class="mb-1"><i class="bi bi-envelope-fill text-success me-2"></i>support@neerodai.com</p>
          <p class="mb-3"><i class="bi bi-telephone-fill text-primary me-2"></i>+91 98765 43210</p>

          <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.5940830757413!2d77.91431287313667!3d8.44146069791296!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b0479c1cc50e7e5%3A0xc042db26508443bc!2sPENIEL%20TRUTH%20CHURCH!5e0!3m2!1sen!2sin!4v1753472621678!5m2!1sen!2sin" 
              style="border:0;" 
              allowfullscreen 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

<style>
    .greenymain-bg{
        background-color: rgba(25, 135, 84, 0.1);
    }
</style>