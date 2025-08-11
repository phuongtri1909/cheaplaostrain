<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Train;
use App\Models\Route;
use App\Models\SeatClass;
use App\Models\TrainSeatClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainController extends Controller
{
    public function index(Request $request)
    {
        $query = Train::with('route');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('train_number', 'LIKE', '%' . $search . '%')
                  ->orWhere('operator', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->filled('route_id')) {
            $query->where('route_id', $request->route_id);
        }

        if ($request->filled('train_type')) {
            $query->where('train_type', $request->train_type);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $trains = $query->orderBy('train_number')->paginate(15)->withQueryString();

        $routes = Route::where('is_active', true)->orderBy('name')->get();

        return view('admin.pages.trains.index', compact('trains', 'routes'));
    }

    public function create()
    {
        $routes = Route::with(['departureStation', 'arrivalStation'])
                      ->where('is_active', true)
                      ->orderBy('name')
                      ->get();

        $seatClasses = SeatClass::where('is_active', true)
                               ->orderBy('sort_order')
                               ->get();

        return view('admin.pages.trains.create', compact('routes', 'seatClasses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'train_number' => 'required|string|max:50|unique:trains,train_number',
            'route_id' => 'required|exists:routes,id',
            'train_type' => 'required|string|max:50',
            'operator' => 'required|string|max:255',
            'total_seats' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'seat_classes' => 'required|array|min:1',
            'seat_classes.*.seat_class_id' => 'required|exists:seat_classes,id',
            'seat_classes.*.total_seats' => 'required|integer|min:1',
            'seat_classes.*.available_seats' => 'required|integer|min:0',
        ], [
            'train_number.required' => 'Số hiệu tàu là bắt buộc',
            'train_number.unique' => 'Số hiệu tàu đã tồn tại',
            'route_id.required' => 'Tuyến đường là bắt buộc',
            'train_type.required' => 'Loại tàu là bắt buộc',
            'operator.required' => 'Nhà vận hành là bắt buộc',
            'seat_classes.required' => 'Phải có ít nhất một hạng ghế',
            'seat_classes.*.seat_class_id.required' => 'Hạng ghế là bắt buộc',
            'seat_classes.*.total_seats.required' => 'Số ghế là bắt buộc',
            'seat_classes.*.available_seats.required' => 'Số ghế có sẵn là bắt buộc',
        ]);

        try {
            DB::beginTransaction();

            // Tạo Train
            $train = Train::create([
                'train_number' => $request->train_number,
                'route_id' => $request->route_id,
                'train_type' => $request->train_type,
                'operator' => $request->operator,
                'total_seats' => $request->total_seats,
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Tạo TrainSeatClasses
            foreach ($request->seat_classes as $seatClassData) {
                // Validate available_seats <= total_seats
                if ($seatClassData['available_seats'] > $seatClassData['total_seats']) {
                    throw new \Exception('Số ghế có sẵn không được lớn hơn tổng số ghế');
                }

                TrainSeatClass::create([
                    'train_id' => $train->id,
                    'seat_class_id' => $seatClassData['seat_class_id'],
                    'total_seats' => $seatClassData['total_seats'],
                    'available_seats' => $seatClassData['available_seats'],
                    'is_active' => true,
                ]);
            }

            // Auto-calculate total_seats if not provided
            if (!$request->total_seats) {
                $totalSeats = collect($request->seat_classes)->sum('total_seats');
                $train->update(['total_seats' => $totalSeats]);
            }

            DB::commit();
            return redirect()->route('admin.trains.index')
                ->with('success', 'Tàu và cấu hình ghế đã được tạo thành công!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show(Train $train)
    {
        $train->load(['route.departureStation', 'route.arrivalStation', 'trainSeatClasses.seatClass', 'schedules']);
        return view('admin.pages.trains.show', compact('train'));
    }

    public function edit(Train $train)
    {
        $routes = Route::with(['departureStation', 'arrivalStation'])
                      ->where('is_active', true)
                      ->orderBy('name')
                      ->get();

        $seatClasses = SeatClass::where('is_active', true)
                               ->orderBy('sort_order')
                               ->get();

        $train->load(['trainSeatClasses.seatClass']);

        return view('admin.pages.trains.edit', compact('train', 'routes', 'seatClasses'));
    }

    public function update(Request $request, Train $train)
    {
        $request->validate([
            'train_number' => 'required|string|max:50|unique:trains,train_number,' . $train->id,
            'route_id' => 'required|exists:routes,id',
            'train_type' => 'required|string|max:50',
            'operator' => 'required|string|max:255',
            'total_seats' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'seat_classes' => 'required|array|min:1',
            'seat_classes.*.seat_class_id' => 'required|exists:seat_classes,id',
            'seat_classes.*.total_seats' => 'required|integer|min:1',
            'seat_classes.*.available_seats' => 'required|integer|min:0',
        ], [
            'train_number.required' => 'Số hiệu tàu là bắt buộc',
            'train_number.unique' => 'Số hiệu tàu đã tồn tại',
            'route_id.required' => 'Tuyến đường là bắt buộc',
            'train_type.required' => 'Loại tàu là bắt buộc',
            'operator.required' => 'Nhà vận hành là bắt buộc',
            'seat_classes.required' => 'Phải có ít nhất một hạng ghế',
        ]);

        try {
            DB::beginTransaction();

            // Update Train
            $train->update([
                'train_number' => $request->train_number,
                'route_id' => $request->route_id,
                'train_type' => $request->train_type,
                'operator' => $request->operator,
                'total_seats' => $request->total_seats,
                'is_active' => $request->boolean('is_active'),
            ]);

            // Delete existing TrainSeatClasses
            $train->trainSeatClasses()->delete();

            // Create new TrainSeatClasses
            foreach ($request->seat_classes as $seatClassData) {
                if ($seatClassData['available_seats'] > $seatClassData['total_seats']) {
                    throw new \Exception('Số ghế có sẵn không được lớn hơn tổng số ghế');
                }

                TrainSeatClass::create([
                    'train_id' => $train->id,
                    'seat_class_id' => $seatClassData['seat_class_id'],
                    'total_seats' => $seatClassData['total_seats'],
                    'available_seats' => $seatClassData['available_seats'],
                    'is_active' => true,
                ]);
            }

            // Auto-calculate total_seats if not provided
            if (!$request->total_seats) {
                $totalSeats = collect($request->seat_classes)->sum('total_seats');
                $train->update(['total_seats' => $totalSeats]);
            }

            DB::commit();
            return redirect()->route('admin.trains.index')
                ->with('success', 'Tàu và cấu hình ghế đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(Train $train)
    {
        try {
            if ($train->schedules()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa tàu đã có lịch trình.');
            }

            if ($train->tickets()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa tàu đã có vé đặt.');
            }

            DB::beginTransaction();

            // Delete TrainSeatClasses first
            $train->trainSeatClasses()->delete();

            // Delete Train
            $train->delete();

            DB::commit();
            return redirect()->route('admin.trains.index')
                ->with('success', 'Tàu đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa tàu: ' . $e->getMessage());
        }
    }
}
