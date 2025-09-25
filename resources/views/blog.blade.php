@extends('user')

@section('title', 'Blog - Neerodai')

@section('content')
<section class="blog-section py-5">
  <div class="container">
    <h1 class="text-center mb-5 fw-bold gradient-text">Our Latest Blogs</h1>

    <div class="row g-4">
      <!-- Blog 1 -->
<div class="col-lg-4 col-md-6">
  <div class="blog-card shadow-lg rounded-4 overflow-hidden h-100">
    <div class="blog-img">
      <img src="http://localhost/dow-img/blog1.jpg" 
           alt="Elderly Care" class="img-fluid">
    </div>
    <div class="p-4 d-flex flex-column">
      <h5 class="fw-bold text-dark mb-2">How Neerodai is Supporting the Elderly</h5>
      <p class="text-muted small mb-3">
        <i class="bi bi-calendar"></i> Sep 12, 2025
      </p>
      <p class="text-muted flex-grow-1">We are committed to providing nutritious meals and emotional care for senior citizens...</p>
      <a href="#" class="btn-readmore mt-2">Read More →</a>
    </div>
  </div>
</div>

<!-- Blog 2 -->
<div class="col-lg-4 col-md-6">
  <div class="blog-card shadow-lg rounded-4 overflow-hidden h-100">
    <div class="blog-img">
      <img src="http://localhost/dow-img/blog2.jpg" 
           alt="Community Support" class="img-fluid">
    </div>
    <div class="p-4 d-flex flex-column">
      <h5 class="fw-bold text-dark mb-2">Community Efforts to Make a Difference</h5>
      <p class="text-muted small mb-3">
        <i class="bi bi-calendar"></i> Sep 5, 2025
      </p>
      <p class="text-muted flex-grow-1">Together with our volunteers, we are able to extend our mission and reach more elderly homes...</p>
      <a href="#" class="btn-readmore mt-2">Read More →</a>
    </div>
  </div>
</div>

<!-- Blog 3 -->
<div class="col-lg-4 col-md-6">
  <div class="blog-card shadow-lg rounded-4 overflow-hidden h-100">
    <div class="blog-img">
      <img src="http://localhost/dow-img/blog3.jpg" 
           alt="Food Donations" class="img-fluid">
    </div>
    <div class="p-4 d-flex flex-column">
      <h5 class="fw-bold text-dark mb-2">Meals of Love – Feeding with Care</h5>
      <p class="text-muted small mb-3">
        <i class="bi bi-calendar"></i> Aug 25, 2025
      </p>
      <p class="text-muted flex-grow-1">Every meal we serve carries hope and care. Here’s how our meal programs are making an impact...</p>
      <a href="#" class="btn-readmore mt-2">Read More →</a>
    </div>
  </div>
</div>

    </div>
  </div>
</section>

<!-- Styles -->
<style>
.blog-section {
  background: linear-gradient(135deg, #f9fdfb, #ffffff);
}

.gradient-text {
  background: linear-gradient(90deg, #198754, #28a745);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.blog-card {
  background: #fff;
  transition: all 0.3s ease;
  border: 1px solid rgba(25, 135, 84, 0.15);
}
.blog-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 20px rgba(25, 135, 84, 0.2);
}

.blog-img img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  transition: transform 0.4s ease;
}
.blog-card:hover .blog-img img {
  transform: scale(1.08);
}

.btn-readmore {
  text-decoration: none;
  color: #198754;
  font-weight: 600;
  transition: all 0.3s ease;
}
.btn-readmore:hover {
  color: #28a745;
  letter-spacing: 0.5px;
}
</style>
@endsection
