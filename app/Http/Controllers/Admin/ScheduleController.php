<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Train;
use App\Models\Route;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['train', 'route']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('departure_time', 'LIKE', '%' . $search . '%')
                  ->orWhere('arrival_time', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('train', function($trainQuery) use ($search) {
                      $trainQuery->where('train_number', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('train_id')) {
            $query->where('train_id', $request->train_id);
        }

        if ($request->filled('route_id')) {
            $query->where('route_id', $request->route_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('effective_date')) {
            $effectiveDate = $request->effective_date;
            $query->where('effective_from', '<=', $effectiveDate)
                  ->where(function($q) use ($effectiveDate) {
                      $q->whereNull('effective_until')
                        ->orWhere('effective_until', '>=', $effectiveDate);
                  });
        }

        $schedules = $query->orderBy('departure_time')->paginate(15)->withQueryString();

        $trains = Train::where('is_active', true)->orderBy('train_number')->get();
        $routes = Route::where('is_active', true)->orderBy('name')->get();

        return view('admin.pages.schedules.index', compact('schedules', 'trains', 'routes'));
    }

    public function create()
    {
        $trains = Train::where('is_active', true)->orderBy('train_number')->get();
        $routes = Route::where('is_active', true)->orderBy('name')->get();

        return view('admin.pages.schedules.create', compact('trains', 'routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'operating_days' => 'nullable|array',
            'operating_days.*' => 'integer|between:1,7',
            'effective_from' => 'required|date',
            'effective_until' => 'nullable|date|after_or_equal:effective_from',
            'is_active' => 'boolean'
        ], [
            'train_id.required' => 'Tàu là bắt buộc',
            'route_id.required' => 'Tuyến đường là bắt buộc',
            'departure_time.required' => 'Giờ khởi hành là bắt buộc',
            'arrival_time.required' => 'Giờ đến là bắt buộc',
            'arrival_time.after' => 'Giờ đến phải sau giờ khởi hành',
            'effective_from.required' => 'Ngày hiệu lực là bắt buộc',
            'effective_until.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày hiệu lực',
        ]);

        try {
            $data = $request->all();

            // Process operating_days array
            if ($request->filled('operating_days')) {
                $data['operating_days'] = array_map('intval', $request->operating_days);
            } else {
                $data['operating_days'] = [];
            }

            Schedule::create($data);
            return redirect()->route('admin.schedules.index')
                ->with('success', 'Lịch trình đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo lịch trình: ' . $e->getMessage());
        }
    }

    public function show(Schedule $schedule)
    {
        $schedule->load(['train', 'route', 'tickets', 'schedulePrices', 'segmentPrices']);
        return view('admin.pages.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $trains = Train::where('is_active', true)->orderBy('train_number')->get();
        $routes = Route::where('is_active', true)->orderBy('name')->get();

        return view('admin.pages.schedules.edit', compact('schedule', 'trains', 'routes'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'operating_days' => 'nullable|array',
            'operating_days.*' => 'integer|between:1,7',
            'effective_from' => 'required|date',
            'effective_until' => 'nullable|date|after_or_equal:effective_from',
            'is_active' => 'boolean'
        ], [
            'train_id.required' => 'Tàu là bắt buộc',
            'route_id.required' => 'Tuyến đường là bắt buộc',
            'departure_time.required' => 'Giờ khởi hành là bắt buộc',
            'arrival_time.required' => 'Giờ đến là bắt buộc',
            'arrival_time.after' => 'Giờ đến phải sau giờ khởi hành',
            'effective_from.required' => 'Ngày hiệu lực là bắt buộc',
            'effective_until.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày hiệu lực',
        ]);

        try {
            $data = $request->all();

            // Process operating_days array
            if ($request->filled('operating_days')) {
                $data['operating_days'] = array_map('intval', $request->operating_days);
            } else {
                $data['operating_days'] = [];
            }

            $schedule->update($data);
            return redirect()->route('admin.schedules.index')
                ->with('success', 'Lịch trình đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật lịch trình: ' . $e->getMessage());
        }
    }

    public function destroy(Schedule $schedule)
    {
        try {
            if ($schedule->tickets()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa lịch trình đã có vé được đặt.');
            }

            $schedule->delete();
            return redirect()->route('admin.schedules.index')
                ->with('success', 'Lịch trình đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa lịch trình: ' . $e->getMessage());
        }
    }
}
