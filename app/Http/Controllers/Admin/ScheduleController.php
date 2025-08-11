<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\SchedulePrice;
use App\Models\Train;
use App\Models\Route;
use App\Models\TrainSeatClass;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['train', 'route']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('departure_datetime', 'LIKE', '%' . $search . '%')
                  ->orWhere('arrival_datetime', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('train', function($trainQuery) use ($search) {
                      $trainQuery->where('train_number', 'LIKE', '%' . $search . '%');
                  })
                  ->orWhereHas('route', function($routeQuery) use ($search) {
                      $routeQuery->where('name', 'LIKE', '%' . $search . '%');
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

        if ($request->filled('departure_date')) {
            $query->whereDate('departure_datetime', $request->departure_date);
        }

        $schedules = $query->orderBy('departure_datetime','desc')->paginate(15)->withQueryString();

        $trains = Train::where('is_active', true)->orderBy('train_number')->get();
        $routes = Route::where('is_active', true)->orderBy('name')->get();

        return view('admin.pages.schedules.index', compact('schedules', 'trains', 'routes'));
    }

    public function create()
    {
        $trains = Train::with('trainSeatClasses.seatClass')->where('is_active', true)->orderBy('train_number')->get();
        $routes = Route::where('is_active', true)->orderBy('name')->get();

        return view('admin.pages.schedules.create', compact('trains', 'routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_date' => 'required|date|after_or_equal:departure_date',
            'arrival_time' => 'required|date_format:H:i',
            'is_active' => 'boolean',
            'prices' => 'array',
            'prices.*' => 'required|numeric|min:0'
        ], [
            'train_id.required' => 'Tàu là bắt buộc',
            'route_id.required' => 'Tuyến đường là bắt buộc',
            'departure_date.required' => 'Ngày khởi hành là bắt buộc',
            'departure_time.required' => 'Giờ khởi hành là bắt buộc',
            'arrival_date.required' => 'Ngày đến là bắt buộc',
            'arrival_time.required' => 'Giờ đến là bắt buộc',
            'arrival_date.after_or_equal' => 'Ngày đến phải sau hoặc bằng ngày khởi hành',
            'prices.*.required' => 'Giá cho tất cả hạng ghế là bắt buộc',
            'prices.*.numeric' => 'Giá phải là số',
            'prices.*.min' => 'Giá không được âm',
        ]);

        try {
            DB::beginTransaction();

            // Combine date and time for departure and arrival
            $departureDateTime = Carbon::parse($request->departure_date . ' ' . $request->departure_time);
            $arrivalDateTime = Carbon::parse($request->arrival_date . ' ' . $request->arrival_time);

            // Validate that arrival is after departure
            if ($arrivalDateTime->lte($departureDateTime)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Thời gian đến phải sau thời gian khởi hành.');
            }

            // Create schedule
            $schedule = Schedule::create([
                'train_id' => $request->train_id,
                'route_id' => $request->route_id,
                'departure_datetime' => $departureDateTime,
                'arrival_datetime' => $arrivalDateTime,
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Create schedule prices for each train seat class
            $train = Train::with('trainSeatClasses')->find($request->train_id);
            $prices = $request->input('prices', []);

            foreach ($train->trainSeatClasses as $trainSeatClass) {
                if (isset($prices[$trainSeatClass->id]) && $prices[$trainSeatClass->id] > 0) {
                    SchedulePrice::create([
                        'schedule_id' => $schedule->id,
                        'train_seat_class_id' => $trainSeatClass->id,
                        'price' => $prices[$trainSeatClass->id],
                        'currency' => 'USD',
                        'effective_from' => $departureDateTime->toDateString(),
                        'effective_until' => $arrivalDateTime->addDays(30)->toDateString(), // Valid for 30 days
                        'is_active' => true
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.schedules.index')
                ->with('success', 'Lịch trình và giá vé đã được tạo thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo lịch trình: ' . $e->getMessage());
        }
    }

    public function show(Schedule $schedule)
    {
        $schedule->load(['train', 'route', 'tickets', 'schedulePrices.trainSeatClass.seatClass']);
        return view('admin.pages.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $trains = Train::with('trainSeatClasses.seatClass')->where('is_active', true)->orderBy('train_number')->get();
        $routes = Route::where('is_active', true)->orderBy('name')->get();

        // Get existing prices
        $existingPrices = [];
        foreach ($schedule->schedulePrices as $price) {
            $existingPrices[$price->train_seat_class_id] = $price->price;
        }

        return view('admin.pages.schedules.edit', compact('schedule', 'trains', 'routes', 'existingPrices'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_date' => 'required|date|after_or_equal:departure_date',
            'arrival_time' => 'required|date_format:H:i',
            'is_active' => 'boolean',
            'prices' => 'array',
            'prices.*' => 'required|numeric|min:0'
        ], [
            'train_id.required' => 'Tàu là bắt buộc',
            'route_id.required' => 'Tuyến đường là bắt buộc',
            'departure_date.required' => 'Ngày khởi hành là bắt buộc',
            'departure_time.required' => 'Giờ khởi hành là bắt buộc',
            'arrival_date.required' => 'Ngày đến là bắt buộc',
            'arrival_time.required' => 'Giờ đến là bắt buộc',
            'arrival_date.after_or_equal' => 'Ngày đến phải sau hoặc bằng ngày khởi hành',
            'prices.*.required' => 'Giá cho tất cả hạng ghế là bắt buộc',
            'prices.*.numeric' => 'Giá phải là số',
            'prices.*.min' => 'Giá không được âm',
        ]);

        try {
            DB::beginTransaction();

            // Combine date and time for departure and arrival
            $departureDateTime = Carbon::parse($request->departure_date . ' ' . $request->departure_time);
            $arrivalDateTime = Carbon::parse($request->arrival_date . ' ' . $request->arrival_time);

            // Validate that arrival is after departure
            if ($arrivalDateTime->lte($departureDateTime)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Thời gian đến phải sau thời gian khởi hành.');
            }

            // Update schedule
            $schedule->update([
                'train_id' => $request->train_id,
                'route_id' => $request->route_id,
                'departure_datetime' => $departureDateTime,
                'arrival_datetime' => $arrivalDateTime,
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Delete existing schedule prices
            $schedule->schedulePrices()->delete();

            // Create new schedule prices
            $train = Train::with('trainSeatClasses')->find($request->train_id);
            $prices = $request->input('prices', []);

            foreach ($train->trainSeatClasses as $trainSeatClass) {
                if (isset($prices[$trainSeatClass->id]) && $prices[$trainSeatClass->id] > 0) {
                    SchedulePrice::create([
                        'schedule_id' => $schedule->id,
                        'train_seat_class_id' => $trainSeatClass->id,
                        'price' => $prices[$trainSeatClass->id],
                        'currency' => 'USD',
                        'effective_from' => $departureDateTime->toDateString(),
                        'effective_until' => $arrivalDateTime->addDays(30)->toDateString(),
                        'is_active' => true
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.schedules.index')
                ->with('success', 'Lịch trình và giá vé đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật lịch trình: ' . $e->getMessage());
        }
    }

    public function destroy(Schedule $schedule)
    {
        try {
            DB::beginTransaction();

            if ($schedule->tickets()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa lịch trình đã có vé được đặt.');
            }

            // Delete schedule prices first
            $schedule->schedulePrices()->delete();

            // Then delete schedule
            $schedule->delete();

            DB::commit();

            return redirect()->route('admin.schedules.index')
                ->with('success', 'Lịch trình đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa lịch trình: ' . $e->getMessage());
        }
    }

    /**
     * Get train seat classes via AJAX
     */
    public function getTrainSeatClasses(Request $request)
    {
        try {
            $trainId = $request->get('train_id');

            if (!$trainId) {
                return response()->json(['error' => 'Train ID is required'], 400);
            }

            $train = Train::with('trainSeatClasses.seatClass')->find($trainId);

            if (!$train) {
                return response()->json(['error' => 'Train not found'], 404);
            }

            $seatClasses = $train->trainSeatClasses->map(function($trainSeatClass) {
                return [
                    'id' => $trainSeatClass->id,
                    'seat_class_id' => $trainSeatClass->seat_class_id,
                    'seat_class_name' => $trainSeatClass->seatClass->name ?? 'Unknown',
                    'total_seats' => $trainSeatClass->total_seats ?? 0,
                    'available_seats' => $trainSeatClass->available_seats ?? 0,
                ];
            });

            return response()->json($seatClasses);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}
