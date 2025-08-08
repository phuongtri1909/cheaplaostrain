<?php

namespace App\Observers;

use App\Models\Faq;
use Illuminate\Support\Facades\Cache;

class FaqObserver
{
    /**
     * Handle the Faq "created" event.
     */
    public function created(Faq $faq): void
    {
        $this->clearFaqCache();
    }

    /**
     * Handle the Faq "updated" event.
     */
    public function updated(Faq $faq): void
    {
        $this->clearFaqCache();
    }

    /**
     * Handle the Faq "deleted" event.
     */
    public function deleted(Faq $faq): void
    {
        $this->clearFaqCache();
    }

    /**
     * Handle the Faq "restored" event.
     */
    public function restored(Faq $faq): void
    {
        $this->clearFaqCache();
    }

    /**
     * Handle the Faq "force deleted" event.
     */
    public function forceDeleted(Faq $faq): void
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
