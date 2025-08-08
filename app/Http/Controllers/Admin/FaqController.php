<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    /**
     * Display a listing of the FAQs for admin.
     */
    public function index(Request $request)
    {
        $query = Faq::with('faqCategory');

        // Filter by question if provided
        if ($request->filled('question')) {
            $searchTerm = $request->question;
            $query->where('question', 'LIKE', '%' . $searchTerm . '%');
        }

        // Filter by category if provided
        if ($request->filled('category_id')) {
            $query->where('faq_category_id', $request->category_id);
        }

        // Order by order field then by creation date
        $faqs = $query->orderBy('order', 'asc')
                     ->orderBy('created_at', 'desc')
                     ->paginate(10)
                     ->withQueryString();

        // Get categories for filter dropdown
        $categories = FaqCategory::active()->ordered()->get();

        return view('admin.pages.faqs.index', compact('faqs', 'categories'));
    }

    /**
     * Show the form for creating a new FAQ.
     */
    public function create()
    {
        $categories = FaqCategory::active()->ordered()->get();
        return view('admin.pages.faqs.create', compact('categories'));
    }

    /**
     * Store a newly created FAQ in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
        ], [
            'faq_category_id.required' => 'Danh mục FAQ là bắt buộc',
            'faq_category_id.exists' => 'Danh mục FAQ không tồn tại',
            'question.required' => 'Câu hỏi là bắt buộc',
            'question.string' => 'Câu hỏi phải là chuỗi ký tự',
            'question.max' => 'Câu hỏi không được vượt quá 500 ký tự',
            'answer.required' => 'Câu trả lời là bắt buộc',
            'answer.string' => 'Câu trả lời phải là chuỗi ký tự',
            'order.integer' => 'Thứ tự phải là số nguyên',
            'order.min' => 'Thứ tự phải lớn hơn hoặc bằng 0',
        ]);

        try {
            Faq::create([
                'faq_category_id' => $request->faq_category_id,
                'question' => $request->question,
                'answer' => $request->answer,
                'order' => $request->order ?? 0,
            ]);

            // Clear FAQ cache
            Cache::forget('faqs_data');

            return redirect()->route('admin.faqs.index')
                ->with('success', 'FAQ đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo FAQ.');
        }
    }

    /**
     * Show the form for editing the specified FAQ.
     */
    public function edit(Faq $faq)
    {
        $categories = FaqCategory::active()->ordered()->get();
        return view('admin.pages.faqs.edit', compact('faq', 'categories'));
    }

    /**
     * Update the specified FAQ in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
        ], [
            'faq_category_id.required' => 'Danh mục FAQ là bắt buộc',
            'faq_category_id.exists' => 'Danh mục FAQ không tồn tại',
            'question.required' => 'Câu hỏi là bắt buộc',
            'question.string' => 'Câu hỏi phải là chuỗi ký tự',
            'question.max' => 'Câu hỏi không được vượt quá 500 ký tự',
            'answer.required' => 'Câu trả lời là bắt buộc',
            'answer.string' => 'Câu trả lời phải là chuỗi ký tự',
            'order.integer' => 'Thứ tự phải là số nguyên',
            'order.min' => 'Thứ tự phải lớn hơn hoặc bằng 0',
        ]);

        try {
            $faq->update([
                'faq_category_id' => $request->faq_category_id,
                'question' => $request->question,
                'answer' => $request->answer,
                'order' => $request->order ?? 0,
            ]);

            // Clear FAQ cache
            Cache::forget('faqs_data');

            return redirect()->route('admin.faqs.index')
                ->with('success', 'FAQ đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật FAQ.');
        }
    }

    /**
     * Remove the specified FAQ from storage.
     */
    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();

            // Clear FAQ cache
            Cache::forget('faqs_data');

            return redirect()->route('admin.faqs.index')
                ->with('success', 'FAQ đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa FAQ.');
        }
    }

    /**
     * Display a listing of the FAQs for clients.
     */
    public function indexClient()
    {
        $faqs = Cache::remember('faqs_data', 86400, function () {
            return Faq::with('faqCategory')
                      ->whereHas('faqCategory', function($query) {
                          $query->where('is_active', true);
                      })
                      ->orderBy('order', 'asc')
                      ->get()
                      ->groupBy('faq_category_id');
        });

        $categories = Cache::remember('faq_categories_data', 86400, function () {
            return FaqCategory::active()->ordered()->get();
        });

        return view('pages.faqs.index-client', compact('faqs', 'categories'));
    }
}
