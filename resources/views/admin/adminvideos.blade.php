@extends('admin.dashboard')

@section('title', 'Videos')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4">Videos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        {{-- Add New Video --}}
        <div class="col-12 col-xl-4">
            <div class="card p-3 shadow-sm">
                <h5>Add New Video</h5>
                <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" onchange="toggleUploadType(this.value)">
                            <option value="video">Video</option>
                            <option value="youtube">YouTube Link</option>
                        </select>
                    </div>

                    <div id="video-upload" class="upload-type">
                        <label class="form-label">Upload Video</label>
                        <input type="file" name="video" class="form-control" accept="video/*">
                    </div>

                    <div id="youtube-upload" class="upload-type" style="display:none;">
                        <label class="form-label">YouTube Link</label>
                        <input type="url" name="youtube_url" class="form-control" placeholder="https://youtube.com/watch?v=...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Video Flag</label>
                        <select name="videoflag" class="form-select">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Home Flag</label>
                        <select name="homeflag" class="form-select">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <button class="btn btn-primary w-100">Save</button>
                </form>
            </div>
        </div>

        {{-- Video List --}}
        <div class="col-12 col-xl-8">
            <div class="card p-3 shadow-sm">
                <h5>Video Records</h5>
                <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Preview</th>
                            <th>Video Flag</th>
                            <th>Home Flag</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($videos as $video)
                        <tr>
                            <!-- <td class="text-center fw-bold">{{ $video->id }}</td> -->
                             <td class="text-center fw-bold">
                                        {{ $loop->iteration + ($videos->firstItem() - 1) }}
                                    </td>
                            <td class="text-center">
                                @if($video->type === 'video')
                                   <video width="120" height="80" autoplay muted loop playsinline>
                                        <source src="{{ asset('uploads/videos/'.$video->video) }}" type="video/mp4">
                                    </video>

                                @else
                                    {{-- Small thumbnail iframe --}}
                                    <!-- <iframe width="120" height="80"
                                        src="{{ $video->youtube_url }}"
                                        frameborder="0" allowfullscreen>
                                    </iframe> -->
                                    @php
                                    $embedUrl = str_replace("youtu.be/", "www.youtube.com/embed/", $video->youtube_url);
                                    $embedUrl = preg_replace("/\?feature=.*/", "", $embedUrl);
                                @endphp

                                <iframe width="120" height="80"
        src="{{ $embedUrl }}?mute=1&rel=0"
        frameborder="0"
        allowfullscreen>
</iframe>



                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $video->videoflag ? 'success' : 'secondary' }}">
                                    {{ $video->videoflag ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $video->homeflag ? 'success' : 'secondary' }}">
                                    {{ $video->homeflag ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Edit Button --}}
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            data-bs-toggle="modal" data-bs-target="#editModal{{ $video->id }}">
                                        Edit
                                    </button>

                                    {{-- Delete --}}
                                    <form action="{{ route('videos.destroy', $video->id) }}" method="POST"
                                          onsubmit="return confirm('Delete this video?')" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>

                                    {{-- View (YouTube / Video Fullscreen) --}}
                                    @if($video->type === 'youtube')
                                        <button type="button" class="btn btn-info btn-sm text-white" 
                                                data-bs-toggle="modal" data-bs-target="#viewModal{{ $video->id }}">
                                            View
                                        </button>
                                    @elseif($video->type === 'video')
                                        <a href="{{ asset('uploads/videos/'.$video->video) }}" 
                                           target="_blank" class="btn btn-info btn-sm text-white">
                                           Play
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- EDIT MODAL --}}
                        <div class="modal fade" id="editModal{{ $video->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title">Edit Video #{{ $video->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Type</label>
                                                <select name="type" class="form-select" onchange="toggleEditType({{ $video->id }}, this.value)">
                                                    <option value="video" {{ $video->type === 'video' ? 'selected' : '' }}>Video</option>
                                                    <option value="youtube" {{ $video->type === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                                </select>
                                            </div>

                                            <div id="edit-video-{{ $video->id }}" class="upload-type" style="{{ $video->type === 'video' ? '' : 'display:none;' }}">
                                                <label class="form-label">Replace Video (optional)</label>
                                                <input type="file" name="video" class="form-control" accept="video/*">
                                            </div>

                                            <div id="edit-youtube-{{ $video->id }}" class="upload-type" style="{{ $video->type === 'youtube' ? '' : 'display:none;' }}">
                                                <label class="form-label">YouTube Link</label>
                                                <input type="url" name="youtube_url" class="form-control" value="{{ $video->youtube_url }}">
                                            </div>

                                            <div class="row g-3 mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Video Flag</label>
                                                    <select name="videoflag" class="form-select">
                                                        <option value="0" {{ !$video->videoflag ? 'selected' : '' }}>No</option>
                                                        <option value="1" {{ $video->videoflag ? 'selected' : '' }}>Yes</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Home Flag</label>
                                                    <select name="homeflag" class="form-select">
                                                        <option value="0" {{ !$video->homeflag ? 'selected' : '' }}>No</option>
                                                        <option value="1" {{ $video->homeflag ? 'selected' : '' }}>Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- /EDIT MODAL --}}

                        {{-- VIEW MODAL FOR YOUTUBE --}}
                        @if($video->type === 'youtube')
                        <div class="modal fade" id="viewModal{{ $video->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                      <iframe width="100%" height="500"
                                            src="{{ $embedUrl }}?autoplay=1&mute=1&rel=0"
                                            frameborder="0"
                                            allow="autoplay; encrypted-media"
                                            allowfullscreen>
                                    </iframe>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $videos->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleUploadType(type) {
    document.querySelectorAll('.upload-type').forEach(el => el.style.display = "none");
    if(type === "video") document.getElementById('video-upload').style.display = "block";
    if(type === "youtube") document.getElementById('youtube-upload').style.display = "block";
}

function toggleEditType(id, type) {
    document.getElementById('edit-video-' + id).style.display = "none";
    document.getElementById('edit-youtube-' + id).style.display = "none";
    if(type === "video") document.getElementById('edit-video-' + id).style.display = "block";
    if(type === "youtube") document.getElementById('edit-youtube-' + id).style.display = "block";
}
</script>
@endsection
