<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchedulePrice;
use App\Models\Schedule;
use App\Models\SeatClass;
use Illuminate\Http\Request;

class SchedulePriceController extends Controller
{
    public function index(Request $request)
    {
        $query = SchedulePrice::with(['schedule.train', 'schedule.route', 'seatClass']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('price', 'LIKE', '%' . $search . '%')
                  ->orWhere('currency', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('schedule.train', function($trainQuery) use ($search) {
                      $trainQuery->where('train_number', 'LIKE', '%' . $search . '%');
                  })
                  ->orWhereHas('seatClass', function($seatQuery) use ($search) {
                      $seatQuery->where('name', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('schedule_id')) {
            $query->where('schedule_id', $request->schedule_id);
        }

        if ($request->filled('seat_class_id')) {
            $query->where('seat_class_id', $request->seat_class_id);
        }

        $schedulePrices = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $schedules = Schedule::with(['train', 'route'])->where('is_active', true)->orderBy('departure_time')->get();
        $seatClasses = SeatClass::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.pages.schedule-prices.index', compact('schedulePrices', 'schedules', 'seatClasses'));
    }

    public function create()
    {
        $schedules = Schedule::with(['train', 'route'])->where('is_active', true)->orderBy('departure_time')->get();
        $seatClasses = SeatClass::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.pages.schedule-prices.create', compact('schedules', 'seatClasses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'train_seat_class_id' => 'required|exists:train_seat_classes,id',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'effective_from' => 'nullable|date',
            'effective_until' => 'nullable|date|after_or_equal:effective_from'
        ], [
            'schedule_id.required' => 'Lịch trình là bắt buộc',
            'train_seat_class_id.required' => 'Hạng ghế là bắt buộc',
            'price.required' => 'Giá là bắt buộc',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá không được âm',
            'effective_until.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
        ]);

        try {
            // Check if price already exists for this schedule and seat class
            $existingPrice = SchedulePrice::where('schedule_id', $request->schedule_id)
                ->where('seat_class_id', $request->seat_class_id)
                ->first();

            if ($existingPrice) {
                return redirect()->back()->withInput()
                    ->with('error', 'Giá cho lịch trình và hạng ghế này đã tồn tại.');
            }

            SchedulePrice::create($request->all());
            return redirect()->route('admin.schedule-prices.index')
                ->with('success', 'Giá lịch trình đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo giá lịch trình: ' . $e->getMessage());
        }
    }

    public function show(SchedulePrice $schedulePrice)
    {
        $schedulePrice->load(['schedule.train', 'schedule.route', 'seatClass']);
        return view('admin.pages.schedule-prices.show', compact('schedulePrice'));
    }

    public function edit(SchedulePrice $schedulePrice)
    {
        $schedules = Schedule::with(['train', 'route'])->where('is_active', true)->orderBy('departure_time')->get();
        $seatClasses = SeatClass::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.pages.schedule-prices.edit', compact('schedulePrice', 'schedules', 'seatClasses'));
    }

    public function update(Request $request, SchedulePrice $schedulePrice)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'train_seat_class_id' => 'required|exists:train_seat_classes,id',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'effective_from' => 'nullable|date',
            'effective_until' => 'nullable|date|after_or_equal:effective_from'
        ], [
            'schedule_id.required' => 'Lịch trình là bắt buộc',
            'train_seat_class_id.required' => 'Hạng ghế là bắt buộc',
            'price.required' => 'Giá là bắt buộc',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá không được âm',
            'effective_until.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
        ]);

        try {
            // Check if price already exists for this schedule and seat class (excluding current record)
            $existingPrice = SchedulePrice::where('schedule_id', $request->schedule_id)
                ->where('seat_class_id', $request->seat_class_id)
                ->where('id', '!=', $schedulePrice->id)
                ->first();

            if ($existingPrice) {
                return redirect()->back()->withInput()
                    ->with('error', 'Giá cho lịch trình và hạng ghế này đã tồn tại.');
            }

            $schedulePrice->update($request->all());
            return redirect()->route('admin.schedule-prices.index')
                ->with('success', 'Giá lịch trình đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật giá lịch trình: ' . $e->getMessage());
        }
    }

    public function destroy(SchedulePrice $schedulePrice)
    {
        try {
            $schedulePrice->delete();
            return redirect()->route('admin.schedule-prices.index')
                ->with('success', 'Giá lịch trình đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa giá lịch trình: ' . $e->getMessage());
        }
    }
}
