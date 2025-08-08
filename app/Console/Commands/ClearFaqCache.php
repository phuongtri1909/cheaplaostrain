<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearFaqCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-faq';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all FAQ related cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cache::forget('faq_categories_data');
        Cache::forget('total_faqs_count');
        
        // Clear search cache with pattern
        $keys = Cache::getRedis()->keys('*faq_search_*');
        if (!empty($keys)) {
            Cache::getRedis()->del($keys);
        }

        $this->info('FAQ cache cleared successfully!');
        return 0;
    }
}