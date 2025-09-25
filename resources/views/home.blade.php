@extends('user')

@section('title', 'Neerodai - Old Age Home Trust')

@section('content')

<!-- 🌟 Hero Section with Slider -->
<section id="hero" class="mt-3">
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
    <div class="carousel-inner">

      @php
        $heroSlides = [
          [
            'title' => 'Care. Dignity. Hope.',
            'desc' => 'Supporting our elders with love and compassion every day.',
            'btn' => ['text'=>'Support Now', 'url'=>'/pay', 'color'=>'success'],
            'img' => 'istockphoto-1301869552-612x612.jpg'
          ],
          [
            'title' => 'Together We Can Make a Difference',
            'desc' => 'Join us in supporting the elderly with meals, care, and compassion.',
            'btn' => ['text'=>'Donate Now', 'url'=>'/pay', 'color'=>'primary'],
            'img' => 'istockphoto-522605257-612x612.jpg'
          ],
          [
            'title' => 'Be a Volunteer',
            'desc' => 'Spend time, share love, and bring smiles to elders’ lives.',
            'btn' => ['text'=>'Join Us', 'url'=>'/contact', 'color'=>'warning'],
            'img' => 'slide3.jpg'
          ],
        ];
      @endphp

      @foreach($heroSlides as $i => $s)
      <div class="carousel-item @if($i==0) active @endif">
        <div class="container">
          <div class="row g-5 align-items-stretch"> <!-- 👈 ensures equal height -->

            @if($i == 1)
              <!-- Slide 2: Content left, Image right -->
              <div class="col-lg-6 d-flex flex-column justify-content-center text-center text-lg-start">
                <div>
                  <h1 class="display-4 fw-bold mb-3 text-{{ $s['btn']['color'] }}">
                    {{ $s['title'] }}
                  </h1>
                  <p class="lead mb-4 text-muted">{{ $s['desc'] }}</p>
                  <a href="{{ $s['btn']['url'] }}" 
                     class="btn btn-lg btn-{{ $s['btn']['color'] }} rounded-pill shadow px-4">
                     {{ $s['btn']['text'] }}
                  </a>
                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <img src="http://localhost/dow-img/{{ $s['img'] }}" 
                     class="img-fluid rounded-4 shadow-lg hero-main-img" 
                     alt="Slide {{ $i+1 }}">
              </div>
            @else
              <!-- Slide 1 & 3: Image left, Content right -->
              <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <img src="http://localhost/dow-img/{{ $s['img'] }}" 
                     class="img-fluid rounded-4 shadow-lg hero-main-img" 
                     alt="Slide {{ $i+1 }}">
              </div>
              <div class="col-lg-6 d-flex flex-column justify-content-center text-center text-lg-start">
                <div>
                  <h1 class="display-4 fw-bold mb-3 text-{{ $s['btn']['color'] }}">
                    {{ $s['title'] }}
                  </h1>
                  <p class="lead mb-4 text-muted">{{ $s['desc'] }}</p>
                  <a href="{{ $s['btn']['url'] }}" 
                     class="btn btn-lg btn-{{ $s['btn']['color'] }} rounded-pill shadow px-4">
                     {{ $s['btn']['text'] }}
                  </a>
                </div>
              </div>
            @endif

          </div>
        </div>
      </div>
      @endforeach

    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</section>









<!-- 🌟 Gallery -->
<section id="gallery" class="py-5 mt-3 bg-success bg-opacity-10">
  <div class="container text-center">
    <h2 class="fw-bold mb-5 display-6 text-dark">Our Happy Moments</h2>
    <div class="row g-4">
      @foreach([1,2,3] as $i)
      <div class="col-12 col-md-4">
        <div class="gallery-card rounded-4 overflow-hidden shadow-sm hover-scale">
          <img src="http://localhost/laravel/testimg/galary{{ $i }}.png" 
               class="img-fluid" alt="Gallery Image {{ $i }}">
        </div>
      </div>
      @endforeach
    </div>
    <a href="/gallery" class="btn btn-outline-success rounded-pill px-4 mt-4">Learn More</a>
  </div>
</section>



<!-- 🌟 About Us -->
<!-- 🌟 About Us -->
<section id="about" class="py-5 position-relative">
  <div class="container">
    <div class="row g-5 align-items-center">

      <!-- Text Side (comes first on mobile, second on desktop) -->
      <div class="col-lg-6 order-1 order-lg-2">
        <h2 class="fw-bold mb-3 display-6 text-success">About Neerodai Trust</h2>
        <p class="lead text-muted mb-4">
          Neerodai Trust is dedicated to improving the lives of elderly people who are alone, vulnerable, and in need of love and care. For over 15 years, we have been providing food, shelter, and emotional support for senior citizens.
        </p>

        <!-- Features -->
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <div class="d-flex align-items-center">
              <span class="badge bg-success p-3 me-3"><i class="bi bi-heart fs-4"></i></span>
              <p class="mb-0 fw-semibold">Daily Nutritious Meals</p>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="d-flex align-items-center">
              <span class="badge bg-success p-3 me-3"><i class="bi bi-hospital fs-4"></i></span>
              <p class="mb-0 fw-semibold">Medical Care & Counseling</p>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="d-flex align-items-center">
              <span class="badge bg-success p-3 me-3"><i class="bi bi-emoji-smile fs-4"></i></span>
              <p class="mb-0 fw-semibold">Emotional Support & Companionship</p>
            </div>
          </div>
        </div>

        <a href="/about" class="btn btn-outline-success rounded-pill px-4 mt-4">Learn More</a>
      </div>

      <!-- Image Side (comes second on mobile, first on desktop) -->
      <div class="col-lg-6 order-2 order-lg-1">
        <div class="about-img-wrapper position-relative">
          <div class="about-badge bg-success text-white shadow rounded-3 p-3 position-absolute">
            <h3 class="mb-0 fw-bold">15+ Years</h3>
            <small>Caring for Elders</small>
          </div>
          <img src="http://localhost/laravel/testimg/about1.png" 
               class="img-fluid rounded-4 shadow-lg" alt="About Neerodai">
        </div>
      </div>

    </div>
  </div>
</section>

<!-- 🌟 Video Section -->
<section id="video" class="py-5 bg-success bg-opacity-10">
  <div class="container text-center">
    <h2 class="fw-bold mb-4 display-6 text-success">Watch Our Mission</h2>
    <div class="ratio ratio-16x9 rounded-4 shadow-lg overflow-hidden">
      <iframe src="https://www.youtube.com/embed/NWney1SCKwE?rel=0" title="YouTube video player" allowfullscreen></iframe>
    </div>
    <a href="/videos" class="btn btn-outline-success rounded-pill px-4 mt-4">Learn More</a>
  </div>
</section>



<!-- 🌟 Blog Section -->
<section id="blog" class="py-5">
  <div class="container">
    <h2 class="text-center fw-bold mb-5 display-6">From Our Blog</h2>
    <div class="row g-4">
      @php
        $blogs = [
          ['title'=>'How Your Donation Helps','desc'=>'Your support helps us provide three meals daily to over 200 elders in our care network.'],
          ['title'=>'Volunteer Stories','desc'=>'Read about amazing volunteers who spend time and love with our elderly beneficiaries.'],
          ['title'=>'Special Festive Drives','desc'=>'We organize special meal drives during festivals so no elder feels left out.'],
        ];
      @endphp
      @foreach($blogs as $b)
      <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 h-100 hover-scale">
          <div class="card-body">
            <h5 class="fw-bold">{{ $b['title'] }}</h5>
            <p class="text-muted">{{ $b['desc'] }}</p>
            <a href="#" class="text-success fw-bold">Read More →</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>


<!-- 🌟 Donate CTA -->
<section id="donate" class="py-5 bg-dark text-white text-center">
  <div class="container">
    <h2 class="fw-bold mb-3 display-6">Support Our Mission</h2>
    <p class="lead">Every small contribution makes a big difference in an elderly person's life.</p>
    <a href="/pay" class="btn btn-warning btn-lg rounded-pill shadow px-4">Donate Now</a>
  </div>
</section>

@endsection

@push('styles')
<style>
/* Hero */
.hero-main-img {
  max-height: 420px;
  object-fit: cover;
  transition: transform .5s ease;
}
.hero-main-img:hover { transform: scale(1.05); }
.carousel-item { padding: 4rem 0; }

/* Gallery Hover */
.hover-scale {
  transition: transform .4s ease, box-shadow .3s ease;
}
.hover-scale:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}
.about-img-wrapper {
  position: relative;
  display: inline-block;
}

.about-badge {
  position: absolute;
  bottom: 15px;
  left: 15px;
  background: #198754; /* Bootstrap success */
  z-index: 2;
}

/* On small screens, scale badge smaller so it doesn’t break layout */
@media (max-width: 768px) {
  .about-badge {
    bottom: 10px;
    left: 10px;
    padding: 0.5rem 0.75rem;
    font-size: 0.85rem;
  }
}

</style>
@endpush
