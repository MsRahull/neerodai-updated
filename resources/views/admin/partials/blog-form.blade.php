{{--
    Blog form used for both "Add" and "Edit".
    Params: $blog (App\Models\Blog|null), $formId (unique string)
    On "Add", old() values are restored after a validation error.
--}}
@php
    $isEdit  = isset($blog) && $blog;
    // After a failed submit, restore typed values only into the form that was submitted.
    $useOld  = $isEdit ? (string) old('_blog_id') === (string) $blog->id : old('_blog_id') === 'new';
    $val     = function ($field, $default = null) use ($isEdit, $useOld, $blog) {
        $current = $isEdit ? $blog->{$field} : $default;
        return $useOld ? old($field, $current) : $current;
    };
    $lang    = $val('language', 'both');
    $status  = $val('status', 'active');
    $home    = (string) (int) $val('homeflag', 0);
@endphp

<div class="blog-form" data-blog-form id="{{ $formId }}">
    <input type="hidden" name="_blog_id" value="{{ $isEdit ? $blog->id : 'new' }}">

    {{-- Language choice --}}
    <div class="mb-3">
        <label class="form-label fw-semibold d-block">Content language</label>
        <div class="bf-lang-choice" role="radiogroup">
            @foreach(\App\Models\Blog::LANGUAGES as $value => $label)
                <input type="radio" class="btn-check" name="language" value="{{ $value }}"
                       id="{{ $formId }}-lang-{{ $value }}" autocomplete="off" @checked($lang === $value)>
                <label class="btn btn-outline-success btn-sm" for="{{ $formId }}-lang-{{ $value }}">
                    @if($value === 'both') <i class="fas fa-language me-1"></i>
                    @elseif($value === 'en') EN
                    @else த
                    @endif
                    {{ $label }}
                </label>
            @endforeach
        </div>
        <div class="form-text">
            Visitors see the version that matches the site language. If a post has only one language,
            that version is shown to everyone.
        </div>
    </div>

    {{-- Language tabs --}}
    <ul class="nav nav-tabs bf-tabs" role="tablist">
        <li class="nav-item" role="presentation" data-lang-tab="en">
            <button class="nav-link {{ $lang !== 'ta' ? 'active' : '' }}" type="button" data-bs-toggle="tab"
                    data-bs-target="#{{ $formId }}-en" role="tab">English</button>
        </li>
        <li class="nav-item" role="presentation" data-lang-tab="ta">
            <button class="nav-link {{ $lang === 'ta' ? 'active' : '' }}" type="button" data-bs-toggle="tab"
                    data-bs-target="#{{ $formId }}-ta" role="tab">தமிழ் (Tamil)</button>
        </li>
    </ul>

    <div class="tab-content bf-tab-body">
        {{-- English --}}
        <div class="tab-pane fade {{ $lang !== 'ta' ? 'show active' : '' }}" id="{{ $formId }}-en" role="tabpanel" data-lang-pane="en">
            <div class="mb-3">
                <label class="form-label" for="{{ $formId }}-title">Title (English)</label>
                <input type="text" name="title" id="{{ $formId }}-title" class="form-control" maxlength="255"
                       value="{{ $val('title') }}" data-req-lang="en">
            </div>
            <div class="mb-3">
                <label class="form-label" for="{{ $formId }}-sd">Short description (English)</label>
                <textarea name="short_description" id="{{ $formId }}-sd" rows="2" class="form-control" maxlength="1000"
                          data-req-lang="en">{{ $val('short_description') }}</textarea>
            </div>
            <div class="mb-0">
                <label class="form-label" for="{{ $formId }}-content">Content (English)</label>
                <textarea name="content" id="{{ $formId }}-content" rows="8" class="form-control"
                          data-req-lang="en">{{ $val('content') }}</textarea>
                <div class="form-text">Leave an empty line between paragraphs.</div>
            </div>
        </div>

        {{-- Tamil --}}
        <div class="tab-pane fade {{ $lang === 'ta' ? 'show active' : '' }}" id="{{ $formId }}-ta" role="tabpanel" data-lang-pane="ta" lang="ta">
            <div class="mb-3">
                <label class="form-label" for="{{ $formId }}-title-ta">தலைப்பு / Title (Tamil)</label>
                <input type="text" name="title_tamil" id="{{ $formId }}-title-ta" class="form-control bf-ta" maxlength="255"
                       value="{{ $val('title_tamil') }}" data-req-lang="ta">
            </div>
            <div class="mb-3">
                <label class="form-label" for="{{ $formId }}-sd-ta">சுருக்கம் / Short description (Tamil)</label>
                <textarea name="short_description_tamil" id="{{ $formId }}-sd-ta" rows="2" class="form-control bf-ta" maxlength="1000"
                          data-req-lang="ta">{{ $val('short_description_tamil') }}</textarea>
            </div>
            <div class="mb-0">
                <label class="form-label" for="{{ $formId }}-content-ta">உள்ளடக்கம் / Content (Tamil)</label>
                <textarea name="content_tamil" id="{{ $formId }}-content-ta" rows="8" class="form-control bf-ta"
                          data-req-lang="ta">{{ $val('content_tamil') }}</textarea>
                <div class="form-text">பத்திகளுக்கு இடையில் ஒரு வெற்று வரி விடவும் · Leave an empty line between paragraphs.</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-6">
            <label class="form-label" for="{{ $formId }}-image">{{ $isEdit ? 'Replace image' : 'Blog image' }}</label>
            <input type="file" name="image" id="{{ $formId }}-image" class="form-control"
                   accept="image/jpeg,image/png,image/webp" data-preview="#{{ $formId }}-preview" @required(!$isEdit)>
            <div class="form-text">JPG, PNG or WEBP · max 2 MB</div>
            <img id="{{ $formId }}-preview" class="bf-preview {{ $isEdit && $blog->image_url ? '' : 'd-none' }}"
                 src="{{ $isEdit ? $blog->image_url : '' }}" alt="Image preview">
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label" for="{{ $formId }}-status">Status</label>
            <select name="status" id="{{ $formId }}-status" class="form-select">
                <option value="active" @selected($status === 'active')>Active</option>
                <option value="inactive" @selected($status === 'inactive')>Inactive</option>
            </select>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label" for="{{ $formId }}-home">Show on home page</label>
            <select name="homeflag" id="{{ $formId }}-home" class="form-select">
                <option value="0" @selected($home === '0')>No</option>
                <option value="1" @selected($home === '1')>Yes</option>
            </select>
        </div>
    </div>
</div>
