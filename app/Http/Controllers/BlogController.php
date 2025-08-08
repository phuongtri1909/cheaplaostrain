<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs for clients.
     */
    public function indexClient(Request $request)
    {
        $page = $request->get('page', 1);
        
        $blogs = Cache::remember("blogs_data_page_{$page}", 3600, function () {
            return Blog::published()
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        });

        $featuredBlogs = Cache::remember('featured_blogs', 86400, function () {
            return Blog::published()
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        });

        $recentBlogs = Cache::remember('recent_blogs', 3600, function () {
            return Blog::published()
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
        });

        return view('pages.blogs.index-client', compact('blogs', 'featuredBlogs', 'recentBlogs'));
    }

    /**
     * Display the specified blog for clients.
     */
    public function showClient($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->published()
            ->firstOrFail();

        $previousBlog = Blog::published()
            ->where('created_at', '<', $blog->created_at)
            ->orderBy('created_at', 'desc')
            ->first();

        $nextBlog = Blog::published()
            ->where('created_at', '>', $blog->created_at)
            ->orderBy('created_at', 'asc')
            ->first();

        $featuredBlogs = Cache::remember('featured_blogs', 86400, function () {
            return Blog::published()
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        });

        $relatedBlogs = Cache::remember("related_blogs_{$blog->id}", 3600, function () use ($blog) {
            return Blog::published()
                ->where('id', '!=', $blog->id)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
        });

        return view('pages.blogs.show-client', compact('blog', 'previousBlog', 'nextBlog', 'featuredBlogs', 'relatedBlogs'));
    }
}
