<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Saves admin uploads into public_html/<dir> safely:
 *  - random file name (the user's original file name is never used)
 *  - extension taken from the real file content, checked against an allow-list
 */
class PublicUpload
{
    public const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    public const VIDEO_EXTENSIONS = ['mp4', 'mov', 'avi', 'mpeg', 'mpg', 'webm'];

    public static function store(UploadedFile $file, string $dir, array $allowedExtensions): string
    {
        $extension = strtolower((string) $file->guessExtension());

        if (!in_array($extension, $allowedExtensions, true)) {
            throw new \InvalidArgumentException('File type not allowed.');
        }

        $name = now()->format('Ymd') . '_' . Str::random(20) . '.' . $extension;

        File::ensureDirectoryExists(public_path($dir));
        $file->move(public_path($dir), $name);

        return $name;
    }

    public static function delete(?string $dir, ?string $name): void
    {
        if (blank($name)) {
            return;
        }

        // basename() stops "../" tricks from a tampered database value.
        $path = public_path($dir . '/' . basename($name));

        if (File::isFile($path)) {
            File::delete($path);
        }
    }
}
