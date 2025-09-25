@extends('user')

@section('title', 'Neerodai Videos')

@section('content')

<section class="container my-5">

    <h1 class="text-center mb-4 fw-bold">Videos</h1>

    <!-- Nav Tabs -->
    <ul class="nav nav-pills justify-content-center mb-4" id="videoTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="uploaded-tab" data-bs-toggle="tab" data-bs-target="#uploaded" type="button" role="tab">
                <i class="fa fa-video me-2"></i>Videos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="youtube-tab" data-bs-toggle="tab" data-bs-target="#youtube" type="button" role="tab">
                <i class="fab fa-youtube me-2"></i>YouTube Videos
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="videoTabsContent">

        <!-- Uploaded Videos -->
        <div class="tab-pane fade show active" id="uploaded" role="tabpanel">
            @if($uploadedVideos->count())
            <div class="row g-4">
                @foreach($uploadedVideos as $video)
                    <div class="col-md-6 col-lg-4">
                        <video class="w-100 rounded shadow-sm" controls>
                            <source src="{{ asset('uploads/videos/' . $video->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @endforeach
            </div>
            @else
                <p class="text-muted text-center">No uploaded videos available.</p>
            @endif
        </div>

        <!-- YouTube Videos -->
        <div class="tab-pane fade" id="youtube" role="tabpanel">
            @if($youtubeVideos->count())
            <div class="row g-4">
                @foreach($youtubeVideos as $video)
                    <div class="col-md-6 col-lg-4">
                        <div class="ratio ratio-16x9 shadow-sm rounded">
                            <iframe src="{{ $video->youtube_url }}" title="YouTube video" allowfullscreen></iframe>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <p class="text-muted text-center">No YouTube videos available.</p>
            @endif
        </div>

    </div>

</section>

@endsection

<style>
video, iframe {
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
video:hover, iframe:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
.nav-pills .nav-link {
    border-radius: 30px;
    padding: 10px 20px;
    color:#198754 !important;
}
.nav-pills .nav-link.active {
    background-color: #198754 !important;
    color: #fff !important;
}
.greenymain-bg{
  background-color: rgba(25, 135, 84, 0.1);
}
</style>
