<?php

namespace App\Http\Controllers;

use App\Models\Videosadmin;
use App\Support\PublicUpload;
use Illuminate\Http\Request;

class AdminVideosurlController extends Controller
{
    private const DIR = 'uploads/videos';

    public function index()
    {
        $videos = Videosadmin::latest()->paginate(10);

        return view('admin.adminvideos', compact('videos'));
    }

    // Public videos page — two separately paginated lists
    public function viewindex()
    {
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

    public function store(Request $request)
    {
        $request->validate($this->rules(isUpdate: false));

        $data = $this->baseData($request);

        if ($request->type === 'video') {
            $data['video']       = PublicUpload::store($request->file('video'), self::DIR, PublicUpload::VIDEO_EXTENSIONS);
            $data['youtube_url'] = null;
        } else {
            $embed = $this->normalizeYouTubeUrl($request->youtube_url);
            if (!$embed) {
                return back()->withErrors(['youtube_url' => 'Invalid YouTube URL'])->withInput();
            }
            $data['youtube_url'] = $embed;
        }

        Videosadmin::create($data);

        return back()->with('success', 'Video added successfully.');
    }

    public function update(Request $request, Videosadmin $video)
    {
        $request->validate($this->rules(isUpdate: true));

        $data = $this->baseData($request);

        if ($request->type === 'video') {
            if ($request->hasFile('video')) {
                $data['video'] = PublicUpload::store($request->file('video'), self::DIR, PublicUpload::VIDEO_EXTENSIONS);
                PublicUpload::delete(self::DIR, $video->video);
            } elseif (blank($video->video)) {
                return back()->withErrors(['video' => 'Please choose a video file.']);
            }
            $data['youtube_url'] = null;
        } else {
            if ($request->filled('youtube_url')) {
                $embed = $this->normalizeYouTubeUrl($request->youtube_url);
                if (!$embed) {
                    return back()->withErrors(['youtube_url' => 'Invalid YouTube URL'])->withInput();
                }
                $data['youtube_url'] = $embed;
            } elseif (blank($video->youtube_url)) {
                return back()->withErrors(['youtube_url' => 'Please enter a YouTube URL.']);
            }
            // Switched from uploaded file to YouTube: remove the old file.
            if ($video->video) {
                PublicUpload::delete(self::DIR, $video->video);
                $data['video'] = null;
            }
        }

        $video->update($data);

        return back()->with('success', 'Video updated successfully.');
    }

    public function destroy(Videosadmin $video)
    {
        PublicUpload::delete(self::DIR, $video->video);
        $video->delete();

        return back()->with('success', 'Video deleted successfully.');
    }

    private function rules(bool $isUpdate): array
    {
        return [
            'type'        => 'required|in:video,youtube',
            'video'       => [$isUpdate ? 'nullable' : 'required_if:type,video', 'nullable', 'file',
                              'mimetypes:video/mp4,video/x-msvideo,video/avi,video/mpeg,video/quicktime,video/webm', 'max:10240'],
            'youtube_url' => [$isUpdate ? 'nullable' : 'required_if:type,youtube', 'nullable', 'url', 'max:255'],
            'videoflag'   => 'required|in:0,1',
            'homeflag'    => 'required|in:0,1',
        ];
    }

    private function baseData(Request $request): array
    {
        return [
            'type'      => $request->type,
            'videoflag' => (int) $request->videoflag,
            'homeflag'  => (int) $request->homeflag,
        ];
    }

    /** Accepts any common YouTube link and returns the embed URL, or null. */
    private function normalizeYouTubeUrl(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        if (!preg_match('/(^|\.)(youtube\.com|youtu\.be|youtube-nocookie\.com)$/', $host)) {
            return null;
        }

        $patterns = [
            '~youtu\.be/([A-Za-z0-9_-]{11})~',
            '~[?&]v=([A-Za-z0-9_-]{11})~',
            '~youtube(?:-nocookie)?\.com/(?:shorts|embed|live)/([A-Za-z0-9_-]{11})~',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $m)) {
                return 'https://www.youtube.com/embed/' . $m[1];
            }
        }

        return null;
    }
}
