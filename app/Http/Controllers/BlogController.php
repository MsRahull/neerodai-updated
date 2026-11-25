<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    // Home page: latest 3 blogs flagged for home
    public function latest()
    {
        $blogs = Blog::active()
            ->where('homeflag', 1)
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact('blogs'));
    }

    // All blogs page
    public function index()
    {
        $blogs = Blog::active()->latest()->paginate(9);

        return view('blog.index', compact('blogs'));
    }

    // Blog detail page
    public function show(string $slug)
    {
        $blog = Blog::active()->where('slug', $slug)->firstOrFail();

        $related = Blog::active()
            ->whereKeyNot($blog->id)
            ->latest()
            ->take(3)
            ->get();

        return view('blog.show', compact('blog', 'related'));
    }
}
