<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class FaqCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = FaqCategory::withCount('faqs');

        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $categories = $query->orderBy('order', 'asc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(10)
                           ->withQueryString();

        return view('admin.pages.faq-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.faq-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:faq_categories,slug',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'slug.string' => 'Slug phải là chuỗi ký tự',
            'slug.max' => 'Slug không được vượt quá 255 ký tự',
            'slug.unique' => 'Slug đã tồn tại',
            'order.integer' => 'Thứ tự phải là số nguyên',
            'order.min' => 'Thứ tự phải lớn hơn hoặc bằng 0',
            'is_active.boolean' => 'Trạng thái phải là true hoặc false',
        ]);

        try {
            $slug = $request->slug ?: Str::slug($request->name);

            FaqCategory::create([
                'name' => $request->name,
                'slug' => $slug,
                'order' => $request->order ?? 0,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('admin.faq-categories.index')
                ->with('success', 'Danh mục FAQ đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo danh mục FAQ.');
        }
    }

    public function edit(FaqCategory $faqCategory)
    {
        return view('admin.pages.faq-categories.edit', compact('faqCategory'));
    }

    public function update(Request $request, FaqCategory $faqCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:faq_categories,slug,' . $faqCategory->id,
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'slug.string' => 'Slug phải là chuỗi ký tự',
            'slug.max' => 'Slug không được vượt quá 255 ký tự',
            'slug.unique' => 'Slug đã tồn tại',
            'order.integer' => 'Thứ tự phải là số nguyên',
            'order.min' => 'Thứ tự phải lớn hơn hoặc bằng 0',
            'is_active.boolean' => 'Trạng thái phải là true hoặc false',
        ]);

        try {
            $slug = $request->slug ?: Str::slug($request->name);

            $faqCategory->update([
                'name' => $request->name,
                'slug' => $slug,
                'order' => $request->order ?? 0,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('admin.faq-categories.index')
                ->with('success', 'Danh mục FAQ đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật danh mục FAQ.');
        }
    }

    public function destroy(FaqCategory $faqCategory)
    {
        try {
            if ($faqCategory->faqs()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa danh mục có chứa câu hỏi FAQ.');
            }

            $faqCategory->delete();

            return redirect()->route('admin.faq-categories.index')
                ->with('success', 'Danh mục FAQ đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa danh mục FAQ.');
        }
    }
}
