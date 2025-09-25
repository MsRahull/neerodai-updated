@extends('user')

@section('title', 'Neerodai Gallery')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 fw-bold text-dark">Our Gallery</h1>

    <div class="row g-3">
        @foreach($galleries as $gallery)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <a href="{{ asset('uploads/gallery/'.$gallery->image) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/gallery/'.$gallery->image) }}" class="gallery-img" alt="Gallery Image">
                </a>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $galleries->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Optional Lightbox CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

<style>
    .gallery-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    .gallery-img:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .pagination .page-item .page-link {
        color: #0B3D91;
        border-radius: 50%;
        margin: 0 2px;
        min-width: 38px;
        min-height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .pagination .page-item.active .page-link {
        background: #198754;
        color: #fff;
        border: none;
    }
    .pagination .page-item .page-link:hover {
        background: #198754;
        color: #fff;
        transform: scale(1.1);
    }
    .greenymain-bg{
        background-color: rgba(25, 135, 84, 0.1);
    }
    @media(max-width:576px){
        .gallery-img { height: 150px; }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endsection
