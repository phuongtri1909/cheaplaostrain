<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeatClass;
use Illuminate\Http\Request;

class SeatClassController extends Controller
{
    public function index(Request $request)
    {
        $query = SeatClass::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('code', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $seatClasses = $query->orderBy('sort_order')
                           ->orderBy('name')
                           ->paginate(15)
                           ->withQueryString();

        return view('admin.pages.seat-classes.index', compact('seatClasses'));
    }

    public function create()
    {
        return view('admin.pages.seat-classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:20|unique:seat_classes,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ], [
            'code.required' => 'Mã hạng ghế là bắt buộc',
            'code.unique' => 'Mã hạng ghế đã tồn tại',
            'name.required' => 'Tên hạng ghế là bắt buộc',
            'image.image' => 'File phải là hình ảnh',
            'image.max' => 'Kích thước ảnh không được vượt quá 2MB',
        ]);

        try {
            $data = $request->only(['code', 'name', 'description', 'sort_order', 'is_active']);

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/seat-classes'), $imageName);
                $data['image'] = 'uploads/seat-classes/' . $imageName;
            }

            // Auto set sort_order if not provided
            if (!$request->filled('sort_order')) {
                $data['sort_order'] = (SeatClass::max('sort_order') ?? 0) + 1;
            }

            SeatClass::create($data);
            return redirect()->route('admin.seat-classes.index')
                ->with('success', 'Hạng ghế đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo hạng ghế: ' . $e->getMessage());
        }
    }

    public function show(SeatClass $seatClass)
    {
        $seatClass->load(['trainSeatClasses.train', 'segmentPrices']);
        return view('admin.pages.seat-classes.show', compact('seatClass'));
    }

    public function edit(SeatClass $seatClass)
    {
        return view('admin.pages.seat-classes.edit', compact('seatClass'));
    }

    public function update(Request $request, SeatClass $seatClass)
    {
        $request->validate([
            'code' => 'required|string|max:20|unique:seat_classes,code,' . $seatClass->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ], [
            'code.required' => 'Mã hạng ghế là bắt buộc',
            'code.unique' => 'Mã hạng ghế đã tồn tại',
            'name.required' => 'Tên hạng ghế là bắt buộc',
            'image.image' => 'File phải là hình ảnh',
            'image.max' => 'Kích thước ảnh không được vượt quá 2MB',
        ]);

        try {
            $data = $request->only(['code', 'name', 'description', 'sort_order', 'is_active']);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($seatClass->image && file_exists(public_path($seatClass->image))) {
                    unlink(public_path($seatClass->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/seat-classes'), $imageName);
                $data['image'] = 'uploads/seat-classes/' . $imageName;
            }

            $seatClass->update($data);
            return redirect()->route('admin.seat-classes.index')
                ->with('success', 'Hạng ghế đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật hạng ghế: ' . $e->getMessage());
        }
    }

    public function destroy(SeatClass $seatClass)
    {
        try {
            if ($seatClass->trainSeatClasses()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa hạng ghế đã được sử dụng trong tàu.');
            }

            if ($seatClass->segmentPrices()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa hạng ghế đã có giá vé.');
            }

            // Delete image if exists
            if ($seatClass->image && file_exists(public_path($seatClass->image))) {
                unlink(public_path($seatClass->image));
            }

            $seatClass->delete();
            return redirect()->route('admin.seat-classes.index')
                ->with('success', 'Hạng ghế đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa hạng ghế: ' . $e->getMessage());
        }
    }
}
