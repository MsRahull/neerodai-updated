<?php

namespace App\Http\Controllers;

use App\Models\Videosadmin;
use Illuminate\Http\Request;

class AdminVideosurlController extends Controller
{
    public function index()
    {
        $videos = Videosadmin::latest()->paginate(3);
        return view('admin.adminvideos', compact('videos'));
    }

//     public function viewindex()
// {
//     // fetch only active videos (optional: you can filter by videoflag/homeflag if needed)
//     $videos = Videosadmin::latest()->get();

//     // Split into two collections
//     $uploadedVideos = $videos->where('type', 'video');
//     $youtubeVideos  = $videos->where('type', 'youtube');

//     return view('videos', compact('uploadedVideos', 'youtubeVideos'));
// }

public function viewindex()
{
    // Paginate separately
    $uploadedVideos = Videosadmin::where('type', 'video')
        ->where('videoflag', 1)
        ->latest()
        ->paginate(6, ['*'], 'uploaded_page');

    $youtubeVideos = Videosadmin::where('type', 'youtube')
        ->where('videoflag', 1)
        ->latest()
        ->paginate(6, ['*'], 'youtube_page');

    return view('videos', compact('uploadedVideos', 'youtubeVideos'));
}



    private function normalizeYouTubeUrl(?string $url): ?string
    {
        if (!$url) return null;

        // Match different YouTube URL formats
        if (preg_match('~youtu\.be/([A-Za-z0-9_-]{11})~', $url, $m)) {
            return "https://www.youtube.com/embed/" . $m[1];
        }

        if (preg_match('~v=([A-Za-z0-9_-]{11})~', $url, $m)) {
            return "https://www.youtube.com/embed/" . $m[1];
        }

        if (preg_match('~youtube\.com/(?:shorts|embed|live)/([A-Za-z0-9_-]{11})~', $url, $m)) {
            return "https://www.youtube.com/embed/" . $m[1];
        }

        // fallback: try parsing query string
        parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $q);
        if (!empty($q['v'])) {
            return "https://www.youtube.com/embed/" . $q['v'];
        }

        return null; // invalid YouTube link
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:video,youtube',
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:10240',
            'youtube_url' => 'nullable|url',
        ]);

        $data = [
            'type' => $request->type,
            'videoflag' => $request->videoflag,
            'homeflag' => $request->homeflag,
        ];

        if ($request->type === 'video' && $request->hasFile('video')) {
            $filename = time().'.'.$request->video->extension();
            $request->video->move(public_path('uploads/videos'), $filename);
            $data['video'] = $filename;
        }

        if ($request->type === 'youtube') {
            $embed = $this->normalizeYouTubeUrl($request->youtube_url);
            if (!$embed) {
                return back()->withErrors(['youtube_url' => 'Invalid YouTube URL'])->withInput();
            }
            $data['youtube_url'] = $embed;
        }

        Videosadmin::create($data);

        return back()->with('success', 'Video added successfully.');
    }

    public function update(Request $request, $id)
    {
        $video = Videosadmin::findOrFail($id);

        $request->validate([
            'type' => 'required|in:video,youtube',
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:10240',
            'youtube_url' => 'nullable|url',
        ]);

        $data = [
            'type' => $request->type,
            'videoflag' => $request->videoflag,
            'homeflag' => $request->homeflag,
        ];

        if ($request->type === 'video' && $request->hasFile('video')) {
            $filename = time().'.'.$request->video->extension();
            $request->video->move(public_path('uploads/videos'), $filename);
            $data['video'] = $filename;
        }

        if ($request->type === 'youtube') {
            $embed = $this->normalizeYouTubeUrl($request->youtube_url);
            if (!$embed) {
                return back()->withErrors(['youtube_url' => 'Invalid YouTube URL'])->withInput();
            }
            $data['youtube_url'] = $embed;
        }

        $video->update($data);

        return back()->with('success', 'Video updated successfully.');
    }

    public function destroy($id)
    {
        $video = Videosadmin::findOrFail($id);
        $video->delete();
        return back()->with('success', 'Video deleted successfully.');
    }
}
