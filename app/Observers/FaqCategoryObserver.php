<?php

namespace App\Observers;

use App\Models\FaqCategory;
use Illuminate\Support\Facades\Cache;

class FaqCategoryObserver
{
    /**
     * Handle the FaqCategory "created" event.
     */
    public function created(FaqCategory $faqCategory): void
    {
        $this->clearFaqCache();
    }

    /**
     * Handle the FaqCategory "updated" event.
     */
    public function updated(FaqCategory $faqCategory): void
    {
        $this->clearFaqCache();
    }

    /**
     * Handle the FaqCategory "deleted" event.
     */
    public function deleted(FaqCategory $faqCategory): void
    {
        $this->clearFaqCache();
    }

    /**
     * Handle the FaqCategory "restored" event.
     */
    public function restored(FaqCategory $faqCategory): void
    {
        $this->clearFaqCache();
    }

    /**
     * Handle the FaqCategory "force deleted" event.
     */
    public function forceDeleted(FaqCategory $faqCategory): void
    {
        $this->clearFaqCache();
    }

    /**
     * Clear all FAQ related cache
     */
    private function clearFaqCache(): void
    {
        Cache::forget('faq_categories_data');
        Cache::forget('total_faqs_count');
        Cache::forget('faq_search_results');
    }
}