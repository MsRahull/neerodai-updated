<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Support\PublicUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminBlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%' . $request->q . '%';
                $q->where(fn ($w) => $w->where('title', 'like', $term)->orWhere('title_tamil', 'like', $term));
            })
            ->when($request->filled('language'), fn ($q) => $q->where('language', $request->language))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.adminblog', compact('blogs'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, imageRequired: true);

        $data['image'] = PublicUpload::store($request->file('image'), Blog::UPLOAD_DIR, PublicUpload::IMAGE_EXTENSIONS);
        $data['slug']  = $this->uniqueSlug($data);

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog added successfully.');
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $this->validated($request, imageRequired: false);

        if ($request->hasFile('image')) {
            $newImage = PublicUpload::store($request->file('image'), Blog::UPLOAD_DIR, PublicUpload::IMAGE_EXTENSIONS);
            PublicUpload::delete(Blog::UPLOAD_DIR, $blog->image);
            $data['image'] = $newImage;
        }

        // Keep the existing URL stable when the title has not changed.
        $titleChanged = ($data['title'] ?? null) !== $blog->title || ($data['title_tamil'] ?? null) !== $blog->title_tamil;
        if ($titleChanged) {
            $data['slug'] = $this->uniqueSlug($data, $blog->id);
        }

        $blog->update($data);

        return back()->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        PublicUpload::delete(Blog::UPLOAD_DIR, $blog->image);
        $blog->delete();

        return back()->with('success', 'Blog deleted successfully.');
    }

    /**
     * English fields are required for "en" and "both"; Tamil fields for "ta" and "both".
     * Fields for a language that is not selected are cleared.
     */
    private function validated(Request $request, bool $imageRequired): array
    {
        $language = $request->input('language');
        $needsEn  = in_array($language, ['both', 'en'], true);
        $needsTa  = in_array($language, ['both', 'ta'], true);

        $data = $request->validate([
            'language'                => ['required', Rule::in(array_keys(Blog::LANGUAGES))],

            'title'                   => [Rule::requiredIf($needsEn), 'nullable', 'string', 'max:255'],
            'short_description'       => [Rule::requiredIf($needsEn), 'nullable', 'string', 'max:1000'],
            'content'                 => [Rule::requiredIf($needsEn), 'nullable', 'string', 'max:100000'],

            'title_tamil'             => [Rule::requiredIf($needsTa), 'nullable', 'string', 'max:255'],
            'short_description_tamil' => [Rule::requiredIf($needsTa), 'nullable', 'string', 'max:1000'],
            'content_tamil'           => [Rule::requiredIf($needsTa), 'nullable', 'string', 'max:100000'],

            'status'                  => 'required|in:active,inactive',
            'homeflag'                => 'required|boolean',
            'image'                   => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'title.required'                   => 'English title is required for this language option.',
            'short_description.required'       => 'English short description is required for this language option.',
            'content.required'                 => 'English content is required for this language option.',
            'title_tamil.required'             => 'Tamil title is required for this language option.',
            'short_description_tamil.required' => 'Tamil short description is required for this language option.',
            'content_tamil.required'           => 'Tamil content is required for this language option.',
        ]);

        if (!$needsEn) {
            $data['title'] = $data['short_description'] = $data['content'] = null;
        }
        if (!$needsTa) {
            $data['title_tamil'] = $data['short_description_tamil'] = $data['content_tamil'] = null;
        }

        unset($data['image']);

        return $data;
    }

    /** Slug from the English title; Tamil-only posts get "blog-<random>" (Str::slug drops Tamil letters). */
    private function uniqueSlug(array $data, ?int $ignoreId = null): string
    {
        $base = Str::slug((string) ($data['title'] ?? '')) ?: 'blog';
        $base = Str::limit($base, 80, '');

        do {
            $slug = $base . '-' . Str::lower(Str::random(6));
        } while (Blog::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists());

        return $slug;
    }
}
