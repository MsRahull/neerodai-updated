<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

/**
 * A blog post can be written in English, Tamil, or both (`language` column).
 *
 * In views use the "display" accessors — they pick the text for the current
 * site language (/lang/en or /lang/ta) and fall back to the other language
 * when that version does not exist:
 *
 *   $blog->display_title, $blog->display_short_description,
 *   $blog->display_content, $blog->shown_locale, $blog->image_url
 */
class Blog extends Model
{
    public const LANGUAGES = [
        'both' => 'English & Tamil',
        'en'   => 'English only',
        'ta'   => 'Tamil only',
    ];

    public const UPLOAD_DIR = 'uploads/blog';

    protected $table = 'blogs';

    protected $fillable = [
        'language',
        'title',
        'title_tamil',
        'slug',
        'short_description',
        'short_description_tamil',
        'content',
        'content_tamil',
        'image',
        'status',
        'homeflag',
    ];

    protected $casts = [
        'homeflag' => 'boolean',
    ];

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    // ── Language helpers ─────────────────────────────────────────────────────

    public function hasEnglish(): bool
    {
        return $this->language !== 'ta' && filled($this->title);
    }

    public function hasTamil(): bool
    {
        return $this->language !== 'en' && filled($this->title_tamil);
    }

    /** Which language this post will actually be shown in for the visitor. */
    public function getShownLocaleAttribute(): string
    {
        $wantsTamil = app()->getLocale() === 'ta';

        if ($wantsTamil && $this->hasTamil()) {
            return 'ta';
        }
        if (!$wantsTamil && $this->hasEnglish()) {
            return 'en';
        }

        return $this->hasEnglish() ? 'en' : 'ta';
    }

    /** True when the visitor asked for one language but sees the other. */
    public function getIsFallbackAttribute(): bool
    {
        return $this->shown_locale !== (app()->getLocale() === 'ta' ? 'ta' : 'en');
    }

    private function localized(string $field): ?string
    {
        return $this->shown_locale === 'ta'
            ? $this->{$field . '_tamil'}
            : $this->{$field};
    }

    public function getDisplayTitleAttribute(): string
    {
        return (string) $this->localized('title');
    }

    public function getDisplayShortDescriptionAttribute(): ?string
    {
        return $this->localized('short_description');
    }

    public function getDisplayContentAttribute(): string
    {
        return (string) $this->localized('content');
    }

    // ── Image ────────────────────────────────────────────────────────────────

    /**
     * New uploads live in public_html/uploads/blog. The first posts used
     * images from public_html/user/frontend, so fall back to that folder.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        if (File::exists(public_path(self::UPLOAD_DIR . '/' . $this->image))) {
            return asset(self::UPLOAD_DIR . '/' . $this->image);
        }

        return asset('user/frontend/' . $this->image);
    }
}
