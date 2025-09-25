<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(3);
        
        return view('admin.admingallery', compact('galleries'));
    }

    public function viewindex()
    {
        $galleries = Gallery::latest()->paginate(12);
        
        return view('gallery', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'imageflag' => 'required|in:0,1',
            'homeflag' => 'required|in:0,1',
        ]);

        // Upload image
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/gallery'), $imageName);

        // Insert into DB
        $gallery = new Gallery();
        $gallery->image = $imageName;
        $gallery->imageflag = $request->imageflag;  // ✅ save
        $gallery->homeflag = $request->homeflag;    // ✅ save
        $gallery->save();

        return redirect()->route('gallery.index')->with('success', 'Image uploaded successfully');
    }

     public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'imageflag' => 'required|in:0,1',
            'homeflag'  => 'required|in:0,1',
        ]);

        // Replace image if a new file was uploaded
        if ($request->hasFile('image')) {
            $oldPath = public_path('uploads/gallery/' . $gallery->image);
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/gallery'), $imageName);
            $gallery->image = $imageName;
        }

        $gallery->imageflag = $request->imageflag;
        $gallery->homeflag  = $request->homeflag;
        $gallery->save();

        return redirect()->route('gallery.index')->with('success', 'Image updated successfully');
    }

    // NEW: destroy
    public function destroy(Gallery $gallery)
    {
        $path = public_path('uploads/gallery/' . $gallery->image);
        if (is_file($path)) {
            @unlink($path);
        }

        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Image deleted successfully');
    }


}
