<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Response;

/**
 * /sitemap.xml — lists every public page plus each active blog post,
 * so search engines can find them. New blog posts appear automatically.
 */
class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $pages = [
            ['url' => url('/'),         'priority' => '1.0', 'freq' => 'weekly'],
            ['url' => url('/about'),    'priority' => '0.8', 'freq' => 'monthly'],
            ['url' => url('/pay'),      'priority' => '0.9', 'freq' => 'monthly'],
            ['url' => url('/blogs'),    'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => url('/gallery'),  'priority' => '0.7', 'freq' => 'weekly'],
            ['url' => url('/videos'),   'priority' => '0.6', 'freq' => 'monthly'],
            ['url' => url('/contact'),  'priority' => '0.6', 'freq' => 'yearly'],
            ['url' => url('/privacy'),  'priority' => '0.3', 'freq' => 'yearly'],
            ['url' => url('/terms'),    'priority' => '0.3', 'freq' => 'yearly'],
        ];

        $blogs = Blog::active()
            ->whereNotNull('slug')
            ->latest('updated_at')
            ->get(['slug', 'updated_at', 'created_at']);

        foreach ($blogs as $blog) {
            $pages[] = [
                'url'      => route('blogs.show', $blog->slug),
                'priority' => '0.6',
                'freq'     => 'monthly',
                'lastmod'  => optional($blog->updated_at ?? $blog->created_at)->toAtomString(),
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
             . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($pages as $p) {
            $xml .= "  <url>\n"
                  . '    <loc>' . e($p['url']) . "</loc>\n"
                  . (!empty($p['lastmod']) ? '    <lastmod>' . $p['lastmod'] . "</lastmod>\n" : '')
                  . '    <changefreq>' . $p['freq'] . "</changefreq>\n"
                  . '    <priority>' . $p['priority'] . "</priority>\n"
                  . "  </url>\n";
        }

        $xml .= '</urlset>' . "\n";

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
