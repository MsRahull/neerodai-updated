@extends('admin.dashboard')

@section('title', 'Gallery')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4">Gallery</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        {{-- Left: Add Image --}}
        <div class="col-12 col-md-4">
            <div class="card shadow-sm p-3 h-100">
                <h5 class="mb-3">Add New Image</h5>

                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="image" class="form-label">Select Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)" required>
                        @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3 text-center">
                        <img id="preview" src="#" alt="Preview" class="gallery-preview">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image Flag</label>
                        <select name="imageflag" class="form-select">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        @error('imageflag')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Home Flag</label>
                        <select name="homeflag" class="form-select">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        @error('homeflag')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>
            </div>
        </div>

        {{-- Right: Table --}}
        <div class="col-12 col-md-8">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">Gallery Records</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th style="width: 120px;">Image</th>
                                <th>Dashboard Flag</th>
                                <th>Home Flag</th>
                                <th style="width: 160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($galleries as $gallery)
                                <tr>
                                    <!-- <td class="text-center fw-bold">{{ $gallery->id }}</td> -->
                                    <td class="text-center fw-bold">
                                        {{ $loop->iteration + ($galleries->firstItem() - 1) }}
                                    </td>

                                    <td class="text-center">
                                        <img src="{{ asset('uploads/gallery/'.$gallery->image) }}" class="gallery-thumb">
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $gallery->imageflag ? 'success' : 'secondary' }}">
                                            {{ $gallery->imageflag ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $gallery->homeflag ? 'success' : 'secondary' }}">
                                            {{ $gallery->homeflag ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                   <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Edit --}}
                                        <button type="button" 
                                            class="btn btn-sm btn-warning d-flex align-items-center px-3" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal{{ $gallery->id }}">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>

                                        {{-- Delete --}}
                                        <form action="{{ route('gallery.destroy', $gallery->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Delete this image?');" 
                                            class="m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="btn btn-sm btn-danger d-flex align-items-center px-3">
                                                <i class="bi bi-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>

                                </tr>

                                {{-- EDIT MODAL --}}
                                <div class="modal fade" id="editModal{{ $gallery->id }}" tabindex="-1" aria-labelledby="editLabel{{ $gallery->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title" id="editLabel{{ $gallery->id }}">Edit Image #{{ $gallery->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3 text-center">
                                                        <label class="form-label fw-bold">Current Image</label><br>
                                                        <img src="{{ asset('uploads/gallery/'.$gallery->image) }}" class="gallery-preview" style="display:block;">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="image{{ $gallery->id }}" class="form-label">Replace Image (optional)</label>
                                                        <input type="file" name="image" id="image{{ $gallery->id }}" class="form-control" accept="image/*" onchange="previewEditImage({{ $gallery->id }}, event)">
                                                        <div class="text-center mt-2">
                                                            <img id="preview-edit-{{ $gallery->id }}" src="#" alt="Preview" class="gallery-preview">
                                                        </div>
                                                    </div>

                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Image Flag</label>
                                                            <select name="imageflag" class="form-select">
                                                                <option value="0" {{ $gallery->imageflag ? '' : 'selected' }}>No</option>
                                                                <option value="1" {{ $gallery->imageflag ? 'selected' : '' }}>Yes</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Home Flag</label>
                                                            <select name="homeflag" class="form-select">
                                                                <option value="0" {{ $gallery->homeflag ? '' : 'selected' }}>No</option>
                                                                <option value="1" {{ $gallery->homeflag ? 'selected' : '' }}>Yes</option>
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
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                        {{ $galleries->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Scripts --}}
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(event.target.files[0]);
    }
}

function previewEditImage(id, event) {
    const preview = document.getElementById('preview-edit-' + id);
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>

