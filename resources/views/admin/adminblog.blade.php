@extends('admin.dashboard')

@section('title', 'Blogs')

@php
    $addHasErrors  = $errors->any() && old('_blog_id') === 'new';
    $editErrorId   = $errors->any() && old('_blog_id') !== 'new' ? old('_blog_id') : null;
    $langBadge = [
        'both' => ['EN + த', 'bg-success'],
        'en'   => ['EN', 'bg-primary'],
        'ta'   => ['த', 'bg-warning text-dark'],
    ];
@endphp

@section('content')
<div class="py-4">

    {{-- ===== Header ===== --}}
    <div class="na-page-head">
        <div class="na-page-title">
            <span class="na-page-icon"><i class="fas fa-pen-nib"></i></span>
            <div>
                <h1>Blogs</h1>
                <p>Write posts in English, Tamil, or both.</p>
            </div>
        </div>
        <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#addBlog"
                aria-expanded="{{ $addHasErrors ? 'true' : 'false' }}" aria-controls="addBlog">
            <i class="fas fa-plus me-1"></i> Add New Blog
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ===== Add form (collapsible) ===== --}}
    <div class="collapse {{ $addHasErrors ? 'show' : '' }} mb-4" id="addBlog">
        <div class="card shadow-sm border-0">
            <div class="card-body p-3 p-md-4">
                <h5 class="mb-3">Add New Blog</h5>
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.partials.blog-form', ['blog' => null, 'formId' => 'blog-new'])
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end mt-4">
                        <button type="button" class="btn btn-light" data-bs-toggle="collapse" data-bs-target="#addBlog">Cancel</button>
                        <button class="btn btn-success px-4"><i class="fas fa-save me-1"></i> Save Blog</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== List ===== --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-3 p-md-4">

            <form method="GET" class="row g-2 align-items-end mb-3">
                <div class="col-12 col-md-6 col-lg-5">
                    <label class="form-label small text-muted mb-1" for="q">Search title</label>
                    <input type="search" id="q" name="q" value="{{ request('q') }}" class="form-control" placeholder="English or Tamil title">
                </div>
                <div class="col-7 col-md-3">
                    <label class="form-label small text-muted mb-1" for="language">Language</label>
                    <select id="language" name="language" class="form-select">
                        <option value="">All</option>
                        @foreach(\App\Models\Blog::LANGUAGES as $value => $label)
                            <option value="{{ $value }}" @selected(request('language') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-5 col-md-3 col-lg-2 d-flex gap-2">
                    <button class="btn btn-primary flex-fill"><i class="fas fa-filter"></i><span class="d-none d-sm-inline"> Filter</span></button>
                    @if(request()->hasAny(['q', 'language']))
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-light" title="Clear"><i class="fas fa-xmark"></i></a>
                    @endif
                </div>
            </form>

            {{-- Desktop / tablet: table --}}
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle mb-0 bl-admin-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width:56px">#</th>
                            <th style="width:96px">Image</th>
                            <th>Title</th>
                            <th class="text-center">Language</th>
                            <th class="text-center">Home</th>
                            <th class="text-center">Status</th>
                            <th class="text-end" style="width:170px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($blogs as $blog)
                        <tr>
                            <td class="fw-bold text-muted">{{ $blogs->firstItem() + $loop->index }}</td>
                            <td>
                                @if($blog->image_url)
                                    <img src="{{ $blog->image_url }}" class="bl-thumb" alt="" loading="lazy">
                                @else
                                    <span class="text-muted small">No image</span>
                                @endif
                            </td>
                            <td class="bl-title-cell">
                                @if($blog->title)<strong class="d-block">{{ $blog->title }}</strong>@endif
                                @if($blog->title_tamil)<span class="d-block bf-ta">{{ $blog->title_tamil }}</span>@endif
                                <small class="text-muted">{{ $blog->created_at?->format('d M Y') }}</small>
                            </td>
                            <td class="text-center"><span class="badge {{ $langBadge[$blog->language][1] }}">{{ $langBadge[$blog->language][0] }}</span></td>
                            <td class="text-center"><span class="badge bg-{{ $blog->homeflag ? 'success' : 'secondary' }}">{{ $blog->homeflag ? 'Yes' : 'No' }}</span></td>
                            <td class="text-center"><span class="badge bg-{{ $blog->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($blog->status) }}</span></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    @if($blog->status === 'active')
                                        <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm" title="View on site"><i class="fas fa-eye"></i></a>
                                    @endif
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $blog->id }}">
                                        <i class="fas fa-pen"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="m-0" onsubmit="return confirm('Delete this blog?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No blogs found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile: cards --}}
            <div class="d-md-none vstack gap-3">
                @forelse($blogs as $blog)
                    <div class="bl-mcard">
                        @if($blog->image_url)
                            <img src="{{ $blog->image_url }}" alt="" loading="lazy">
                        @endif
                        <div class="p-3">
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                <span class="badge {{ $langBadge[$blog->language][1] }}">{{ $langBadge[$blog->language][0] }}</span>
                                <span class="badge bg-{{ $blog->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($blog->status) }}</span>
                                @if($blog->homeflag)<span class="badge bg-info text-dark">Home</span>@endif
                            </div>
                            @if($blog->title)<strong class="d-block">{{ $blog->title }}</strong>@endif
                            @if($blog->title_tamil)<span class="d-block bf-ta">{{ $blog->title_tamil }}</span>@endif
                            <small class="text-muted">{{ $blog->created_at?->format('d M Y') }}</small>
                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-warning btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#editModal{{ $blog->id }}">
                                    <i class="fas fa-pen"></i> Edit
                                </button>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="m-0 flex-fill" onsubmit="return confirm('Delete this blog?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm w-100"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted py-3 mb-0">No blogs found.</p>
                @endforelse
            </div>

            @if($blogs->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ===== Edit modals (outside the table so the HTML stays valid) ===== --}}
@foreach($blogs as $blog)
    <div class="modal fade" id="editModal{{ $blog->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $blog->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-md-down">
            <div class="modal-content">
                <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column h-100 overflow-hidden">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $blog->id }}">Edit Blog #{{ $blog->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('admin.partials.blog-form', ['blog' => $blog, 'formId' => 'blog-' . $blog->id])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Blog</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil:wght@400;600&display=swap" rel="stylesheet">
<style>
    .bf-ta { font-family: 'Noto Sans Tamil', 'Poppins', sans-serif; }
    .bf-lang-choice { display: flex; flex-wrap: wrap; gap: .5rem; }
    .bf-tabs .nav-link { font-weight: 600; }
    .bf-tabs .nav-link.is-required::after { content: ' *'; color: #dc3545; }
    .bf-tab-body { border: 1px solid #dee2e6; border-top: 0; border-radius: 0 0 .5rem .5rem; padding: 1rem; background: #fff; }
    .bf-preview { display: block; margin-top: .5rem; max-width: 220px; max-height: 140px; object-fit: cover; border-radius: .5rem; border: 1px solid #e5e7eb; }
    .bl-thumb { width: 80px; height: 56px; object-fit: cover; border-radius: .4rem; }
    .bl-title-cell { min-width: 220px; max-width: 420px; }
    .bl-mcard { border: 1px solid #e6ebf2; border-radius: .75rem; overflow: hidden; background: #fff; }
    .bl-mcard img { width: 100%; height: 160px; object-fit: cover; display: block; }
    @media (max-width: 575.98px) {
        .bf-lang-choice .btn { flex: 1 1 100%; }
        .bf-tab-body { padding: .75rem; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Show/require only the fields for the chosen language
    document.querySelectorAll('[data-blog-form]').forEach(function (form) {
        function apply() {
            var checked = form.querySelector('input[name="language"]:checked');
            var lang = checked ? checked.value : 'both';
            var needs = { en: lang !== 'ta', ta: lang !== 'en' };

            ['en', 'ta'].forEach(function (l) {
                var tab = form.querySelector('[data-lang-tab="' + l + '"]');
                tab.classList.toggle('d-none', !needs[l]);
                tab.querySelector('.nav-link').classList.toggle('is-required', needs[l]);
                form.querySelectorAll('[data-req-lang="' + l + '"]').forEach(function (f) { f.required = needs[l]; });
            });

            // If the visible tab was hidden, switch to the other one
            var activeTab = form.querySelector('.bf-tabs .nav-link.active');
            if (!activeTab || activeTab.closest('.d-none')) {
                var target = form.querySelector('[data-lang-tab="' + (needs.en ? 'en' : 'ta') + '"] .nav-link');
                bootstrap.Tab.getOrCreateInstance(target).show();
            }
        }
        form.querySelectorAll('input[name="language"]').forEach(function (r) { r.addEventListener('change', apply); });
        apply();

        // A required field inside a hidden tab: open that tab so the browser can show the message
        form.closest('form').addEventListener('invalid', function (e) {
            var pane = e.target.closest('.tab-pane');
            if (pane && !pane.classList.contains('active')) {
                var btn = form.querySelector('[data-bs-target="#' + pane.id + '"]');
                if (btn) bootstrap.Tab.getOrCreateInstance(btn).show();
            }
        }, true);
    });

    // Image preview
    document.querySelectorAll('input[type="file"][data-preview]').forEach(function (input) {
        input.addEventListener('change', function () {
            var img = document.querySelector(input.dataset.preview);
            if (!img || !input.files[0]) return;
            img.src = URL.createObjectURL(input.files[0]);
            img.classList.remove('d-none');
        });
    });

    // Re-open the edit modal that failed validation
    @if($editErrorId)
        var m = document.getElementById('editModal{{ (int) $editErrorId }}');
        if (m) bootstrap.Modal.getOrCreateInstance(m).show();
    @endif
});
</script>
@endpush
