<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Support\PublicUpload;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    private const DIR = 'uploads/gallery';

    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);

        return view('admin.admingallery', compact('galleries'));
    }

    // Public gallery: only images marked visible
    public function viewindex()
    {
        $galleries = Gallery::where('imageflag', 1)->latest()->paginate(12);

        return view('gallery', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'     => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'imageflag' => 'required|in:0,1',
            'homeflag'  => 'required|in:0,1',
        ]);

        Gallery::create([
            'image'     => PublicUpload::store($request->file('image'), self::DIR, PublicUpload::IMAGE_EXTENSIONS),
            'imageflag' => $request->imageflag,
            'homeflag'  => $request->homeflag,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Image uploaded successfully');
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'imageflag' => 'required|in:0,1',
            'homeflag'  => 'required|in:0,1',
        ]);

        if ($request->hasFile('image')) {
            $newImage = PublicUpload::store($request->file('image'), self::DIR, PublicUpload::IMAGE_EXTENSIONS);
            PublicUpload::delete(self::DIR, $gallery->image);
            $gallery->image = $newImage;
        }

        $gallery->imageflag = $request->imageflag;
        $gallery->homeflag  = $request->homeflag;
        $gallery->save();

        return redirect()->route('gallery.index')->with('success', 'Image updated successfully');
    }

    public function destroy(Gallery $gallery)
    {
        PublicUpload::delete(self::DIR, $gallery->image);
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Image deleted successfully');
    }
}
