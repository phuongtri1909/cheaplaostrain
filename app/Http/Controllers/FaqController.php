<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FaqController extends Controller
{
    /**
     * Display a listing of the FAQs for clients.
     */
    public function indexClient()
    {
        $categories = Cache::remember('faq_categories_data', 86400, function () {
            return FaqCategory::active()
                             ->ordered()
                             ->with(['faqs' => function($query) {
                                 $query->ordered();
                             }])
                             ->get();
        });

        // Lấy tổng số FAQ
        $totalFaqs = Cache::remember('total_faqs_count', 86400, function () {
            return Faq::count();
        });

        return view('pages.faqs.index-client', compact('categories', 'totalFaqs'));
    }

    /**
     * Search FAQs by keyword
     */
    public function search(Request $request)
    {
        $keyword = $request->get('q');
        
        if (empty($keyword)) {
            return response()->json([]);
        }

        $cacheKey = 'faq_search_' . md5($keyword);
        
        $results = Cache::remember($cacheKey, 3600, function () use ($keyword) {
            return Faq::with(['faqCategory' => function($query) {
                        $query->active();
                    }])
                    ->whereHas('faqCategory', function($query) {
                        $query->active();
                    })
                    ->where(function($query) use ($keyword) {
                        $query->where('question', 'LIKE', '%' . $keyword . '%')
                              ->orWhere('answer', 'LIKE', '%' . $keyword . '%');
                    })
                    ->ordered()
                    ->limit(10)
                    ->get();
        });

        return response()->json($results);
    }
}
