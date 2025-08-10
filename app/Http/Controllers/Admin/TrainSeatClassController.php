<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainSeatClass;
use App\Models\Train;
use App\Models\SeatClass;
use Illuminate\Http\Request;

class TrainSeatClassController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainSeatClass::with(['train', 'seatClass']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('total_seats', 'LIKE', '%' . $search . '%')
                  ->orWhere('available_seats', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('train', function($trainQuery) use ($search) {
                      $trainQuery->where('train_number', 'LIKE', '%' . $search . '%');
                  })
                  ->orWhereHas('seatClass', function($seatQuery) use ($search) {
                      $seatQuery->where('name', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('train_id')) {
            $query->where('train_id', $request->train_id);
        }

        if ($request->filled('seat_class_id')) {
            $query->where('seat_class_id', $request->seat_class_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $trainSeatClasses = $query->orderBy('train_id')->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $trains = Train::where('is_active', true)->orderBy('train_number')->get();
        $seatClasses = SeatClass::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.pages.train-seat-classes.index', compact('trainSeatClasses', 'trains', 'seatClasses'));
    }

    public function create()
    {
        $trains = Train::where('is_active', true)->orderBy('train_number')->get();
        $seatClasses = SeatClass::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.pages.train-seat-classes.create', compact('trains', 'seatClasses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'seat_class_id' => 'required|exists:seat_classes,id',
            'total_seats' => 'required|integer|min:1',
            'available_seats' => 'required|integer|min:0|lte:total_seats',
            'is_active' => 'boolean'
        ], [
            'train_id.required' => 'Tàu là bắt buộc',
            'seat_class_id.required' => 'Hạng ghế là bắt buộc',
            'total_seats.required' => 'Tổng số ghế là bắt buộc',
            'total_seats.integer' => 'Tổng số ghế phải là số nguyên',
            'total_seats.min' => 'Tổng số ghế phải lớn hơn 0',
            'available_seats.required' => 'Số ghế có sẵn là bắt buộc',
            'available_seats.integer' => 'Số ghế có sẵn phải là số nguyên',
            'available_seats.min' => 'Số ghế có sẵn không được âm',
            'available_seats.lte' => 'Số ghế có sẵn không được lớn hơn tổng số ghế',
        ]);

        try {
            // Check if train seat class combination already exists
            $existingTrainSeatClass = TrainSeatClass::where('train_id', $request->train_id)
                ->where('seat_class_id', $request->seat_class_id)
                ->first();

            if ($existingTrainSeatClass) {
                return redirect()->back()->withInput()
                    ->with('error', 'Hạng ghế này đã tồn tại cho tàu này.');
            }

            TrainSeatClass::create($request->all());
            return redirect()->route('admin.train-seat-classes.index')
                ->with('success', 'Hạng ghế tàu đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo hạng ghế tàu: ' . $e->getMessage());
        }
    }

    public function show(TrainSeatClass $trainSeatClass)
    {
        $trainSeatClass->load(['train', 'seatClass', 'schedulePrices.schedule']);
        return view('admin.pages.train-seat-classes.show', compact('trainSeatClass'));
    }

    public function edit(TrainSeatClass $trainSeatClass)
    {
        $trains = Train::where('is_active', true)->orderBy('train_number')->get();
        $seatClasses = SeatClass::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.pages.train-seat-classes.edit', compact('trainSeatClass', 'trains', 'seatClasses'));
    }

    public function update(Request $request, TrainSeatClass $trainSeatClass)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'seat_class_id' => 'required|exists:seat_classes,id',
            'total_seats' => 'required|integer|min:1',
            'available_seats' => 'required|integer|min:0|lte:total_seats',
            'is_active' => 'boolean'
        ], [
            'train_id.required' => 'Tàu là bắt buộc',
            'seat_class_id.required' => 'Hạng ghế là bắt buộc',
            'total_seats.required' => 'Tổng số ghế là bắt buộc',
            'total_seats.integer' => 'Tổng số ghế phải là số nguyên',
            'total_seats.min' => 'Tổng số ghế phải lớn hơn 0',
            'available_seats.required' => 'Số ghế có sẵn là bắt buộc',
            'available_seats.integer' => 'Số ghế có sẵn phải là số nguyên',
            'available_seats.min' => 'Số ghế có sẵn không được âm',
            'available_seats.lte' => 'Số ghế có sẵn không được lớn hơn tổng số ghế',
        ]);

        try {
            // Check if train seat class combination already exists (excluding current record)
            $existingTrainSeatClass = TrainSeatClass::where('train_id', $request->train_id)
                ->where('seat_class_id', $request->seat_class_id)
                ->where('id', '!=', $trainSeatClass->id)
                ->first();

            if ($existingTrainSeatClass) {
                return redirect()->back()->withInput()
                    ->with('error', 'Hạng ghế này đã tồn tại cho tàu này.');
            }

            $trainSeatClass->update($request->all());
            return redirect()->route('admin.train-seat-classes.index')
                ->with('success', 'Hạng ghế tàu đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật hạng ghế tàu: ' . $e->getMessage());
        }
    }

    public function destroy(TrainSeatClass $trainSeatClass)
    {
        try {
            if ($trainSeatClass->schedulePrices()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa hạng ghế tàu đã có giá lịch trình được thiết lập.');
            }

            $trainSeatClass->delete();
            return redirect()->route('admin.train-seat-classes.index')
                ->with('success', 'Hạng ghế tàu đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa hạng ghế tàu: ' . $e->getMessage());
        }
    }
}
