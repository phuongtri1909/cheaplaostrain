<?php

namespace App\Observers;

use App\Models\Blog;
use Illuminate\Support\Facades\Cache;

class BlogObserver
{
    /**
     * Handle the Blog "created" event.
     */
    public function created(Blog $blog): void
    {
        $this->clearBlogCache();
    }

    /**
     * Handle the Blog "updated" event.
     */
    public function updated(Blog $blog): void
    {
        $this->clearBlogCache();
    }

    /**
     * Handle the Blog "deleted" event.
     */
    public function deleted(Blog $blog): void
    {
        $this->clearBlogCache();
    }

    /**
     * Handle the Blog "restored" event.
     */
    public function restored(Blog $blog): void
    {
        $this->clearBlogCache();
    }

    /**
     * Handle the Blog "force deleted" event.
     */
    public function forceDeleted(Blog $blog): void
    {
        $this->clearBlogCache();
    }

    /**
     * Clear all blog related cache
     */
    private function clearBlogCache(): void
    {
        // Clear main cache keys
        Cache::forget('featured_blogs');
        Cache::forget('featured_blogs_data');
        Cache::forget('recent_blogs');
        
        // Clear paginated cache
        for ($i = 1; $i <= 20; $i++) {
            Cache::forget("blogs_data_page_{$i}");
        }
        
        // Clear related blogs cache for all existing blogs
        $blogIds = Blog::pluck('id');
        foreach ($blogIds as $blogId) {
            Cache::forget("related_blogs_{$blogId}");
        }
    }
}
