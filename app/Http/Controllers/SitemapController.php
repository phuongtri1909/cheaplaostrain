<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    /**
     * Main sitemap index
     */
    public function index()
    {
        $sitemaps = [
            [
                'loc' => URL::route('sitemap.pages'),
                'lastmod' => date('c'),
            ],
            [
                'loc' => URL::route('sitemap.blogs'),
                'lastmod' => Blog::latest()->first() ? Blog::latest()->first()->updated_at->format('c') : date('c'),
            ],
        ];

        return response()->view('sitemaps.index', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
    }

    /**
     * Static pages sitemap
     */
    public function pages()
    {
        $pages = [
            [
                'loc' => URL::route('home'),
                'lastmod' => date('c'),
                'priority' => '1.0',
                'changefreq' => 'daily',
            ],
            [
                'loc' => URL::route('about.us'),
                'lastmod' => date('c'),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ],
            [
                'loc' => URL::route('faq'),
                'lastmod' => date('c'),
                'priority' => '0.6',
                'changefreq' => 'monthly',
            ],
            [
                'loc' => URL::route('blogs'),
                'lastmod' => date('c'),
                'priority' => '0.7',
                'changefreq' => 'daily',
            ],
        ];

        return response()->view('sitemaps.pages', [
            'pages' => $pages,
        ])->header('Content-Type', 'text/xml');
    }

    /**
     * Blog posts sitemap
     */
    public function blogs()
    {
        $blogs = Blog::where('status', 'published')->get();

        return response()->view('sitemaps.blogs', [
            'blogs' => $blogs,
        ])->header('Content-Type', 'text/xml');
    }
}
