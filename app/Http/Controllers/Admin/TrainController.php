<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Train;
use App\Models\Route;
use Illuminate\Http\Request;

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

        return view('admin.pages.trains.create', compact('routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'train_number' => 'required|string|max:50|unique:trains,train_number',
            'route_id' => 'required|exists:routes,id',
            'train_type' => 'required|string|max:50',
            'operator' => 'required|string|max:255',
            'total_seats' => 'nullable|integer|min:1',
            'is_active' => 'boolean'
        ], [
            'train_number.required' => 'Số hiệu tàu là bắt buộc',
            'train_number.unique' => 'Số hiệu tàu đã tồn tại',
            'route_id.required' => 'Tuyến đường là bắt buộc',
            'train_type.required' => 'Loại tàu là bắt buộc',
            'operator.required' => 'Nhà vận hành là bắt buộc',
        ]);

        try {
            Train::create($request->all());
            return redirect()->route('admin.trains.index')
                ->with('success', 'Tàu đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo tàu: ' . $e->getMessage());
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

        return view('admin.pages.trains.edit', compact('train', 'routes'));
    }

    public function update(Request $request, Train $train)
    {
        $request->validate([
            'train_number' => 'required|string|max:50|unique:trains,train_number,' . $train->id,
            'route_id' => 'required|exists:routes,id',
            'train_type' => 'required|string|max:50',
            'operator' => 'required|string|max:255',
            'total_seats' => 'nullable|integer|min:1',
            'is_active' => 'boolean'
        ], [
            'train_number.required' => 'Số hiệu tàu là bắt buộc',
            'train_number.unique' => 'Số hiệu tàu đã tồn tại',
            'route_id.required' => 'Tuyến đường là bắt buộc',
            'train_type.required' => 'Loại tàu là bắt buộc',
            'operator.required' => 'Nhà vận hành là bắt buộc',
        ]);

        try {
            $train->update($request->all());
            return redirect()->route('admin.trains.index')
                ->with('success', 'Tàu đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật tàu: ' . $e->getMessage());
        }
    }

    public function destroy(Train $train)
    {
        try {
            if ($train->schedules()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa tàu đã có lịch trình.');
            }

            if ($train->trainSeatClasses()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa tàu đã có cấu hình ghế.');
            }

            $train->delete();
            return redirect()->route('admin.trains.index')
                ->with('success', 'Tàu đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa tàu: ' . $e->getMessage());
        }
    }
}
