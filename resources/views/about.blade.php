
@extends('user')

@section('title', 'About Us - Neerodai')

@section('content')
<section class="about-founder py-5" style="background:#f8f9fa;">
  <div class="container">
    <h1 class="text-center mb-5 fw-bold gradient-text">About Us</h1>

    <div class="row align-items-center g-4">

      <!-- Founder Image -->
      <div class="col-lg-5 text-center">
        <img src="http://localhost/dow-img/pastor.jpg" 
             alt="Founder Paul Abraham" 
             class="img-fluid rounded shadow-lg founder-img">
      </div>

      <!-- Founder Content -->
      <div class="col-lg-7">
        <h1 class="fw-bold mb-3 text-greeny">{{ __('messages.our_founder') }}</h1>
        <h4 class="fw-bold text-dark">{{ __('messages.name') }}</h4>
        <p class="lead text-muted mb-4">{{ __('messages.intro') }}</p>

        <ul class="list-unstyled">
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ __('messages.roles.pastor') }}</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ __('messages.roles.leader') }}</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ __('messages.roles.security') }}</li>
        </ul>

        <p class="text-muted">{{ __('messages.closing') }}</p>

      </div>

      
    <!-- Why it Matters -->
    <div class="row align-items-center mb-5 about-section">
        <div class="col-md-6 order-md-2">
            <img src="http://localhost/dow-img/about1.jpg" 
                 class="img-fluid rounded shadow-lg hover-zoom" alt="Elderly food distribution">
        </div>
        <div class="col-md-6 order-md-1 mt-4 mt-md-0">
            <h1 class="fw-bold mb-3 text-greeny">{{ __('messages.our_mission') }}</h1>
            <p class="lead text-muted">{{ __('messages.our_mission_content') }}</p>
        </div>
    </div>

    <!-- Our Vision -->
    <div class="row align-items-center mb-5 about-section">
        <div class="col-md-6">
            <img src="http://localhost/dow-img/about3.jpeg" 
                 class="img-fluid rounded shadow-lg hover-zoom" alt="Caring for elders">
        </div>
        <div class="col-md-6 mt-4 mt-md-0">
            <h1 class="fw-bold mb-3 text-greeny">{{ __('messages.our_vision') }}</h1>
            <p class="lead text-muted">{{ __('messages.our_vision_content') }}</p>

            <!-- Feature Points -->
            <ul class="list-unstyled mt-3">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Sustainable support for elders</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Creating loving communities</li>
                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Empowering volunteers to serve</li>
            </ul>
        </div>
    </div>

    <!-- CTA Button -->
    <div class="text-center mt-5">
        <a href="/pay" class="btn btn-lg btn-success px-5 rounded-pill shadow hover-rise">
            <i class="bi bi-gift me-2"></i> Support Our Work
        </a>
    </div>
    </div>
  </div>
</section>
@endsection

<style>
.founder-img {
  border-radius: 16px;
  max-height: 400px;
  object-fit: cover;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.founder-img:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
.about-founder h2 {
  font-size: 1.75rem;
}
.about-founder ul li {
  font-size: 1rem;
}
</style>
