<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Station;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $query = Route::with(['departureStation', 'arrivalStation']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('code', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->filled('departure_station_id')) {
            $query->where('departure_station_id', $request->departure_station_id);
        }

        if ($request->filled('arrival_station_id')) {
            $query->where('arrival_station_id', $request->arrival_station_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $routes = $query->orderBy('name')->paginate(15)->withQueryString();

        $stations = Station::where('is_active', true)->orderBy('name')->get();

        return view('admin.pages.routes.index', compact('routes', 'stations'));
    }

    public function create()
    {
        $stations = Station::with(['administrativeUnit.country'])
                          ->where('is_active', true)
                          ->orderBy('name')
                          ->get();

        return view('admin.pages.routes.create', compact('stations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:20|unique:routes,code',
            'name' => 'required|string|max:255',
            'departure_station_id' => 'required|exists:stations,id',
            'arrival_station_id' => 'required|exists:stations,id|different:departure_station_id',
            'distance_km' => 'nullable|numeric|min:0',
            'estimated_duration_minutes' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ], [
            'code.required' => 'Mã tuyến đường là bắt buộc',
            'code.unique' => 'Mã tuyến đường đã tồn tại',
            'name.required' => 'Tên tuyến đường là bắt buộc',
            'departure_station_id.required' => 'Ga khởi hành là bắt buộc',
            'arrival_station_id.required' => 'Ga đến là bắt buộc',
            'arrival_station_id.different' => 'Ga đến phải khác ga khởi hành',
        ]);

        try {
            Route::create($request->all());
            return redirect()->route('admin.routes.index')
                ->with('success', 'Tuyến đường đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo tuyến đường: ' . $e->getMessage());
        }
    }

    public function show(Route $route)
    {
        $route->load(['departureStation.administrativeUnit.country',
                     'arrivalStation.administrativeUnit.country',
                     'routeSegments.departureStation',
                     'routeSegments.arrivalStation',
                     'trains']);
        return view('admin.pages.routes.show', compact('route'));
    }

    public function edit(Route $route)
    {
        $stations = Station::with(['administrativeUnit.country'])
                          ->where('is_active', true)
                          ->orderBy('name')
                          ->get();

        return view('admin.pages.routes.edit', compact('route', 'stations'));
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'code' => 'required|string|max:20|unique:routes,code,' . $route->id,
            'name' => 'required|string|max:255',
            'departure_station_id' => 'required|exists:stations,id',
            'arrival_station_id' => 'required|exists:stations,id|different:departure_station_id',
            'distance_km' => 'nullable|numeric|min:0',
            'estimated_duration_minutes' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ], [
            'code.required' => 'Mã tuyến đường là bắt buộc',
            'code.unique' => 'Mã tuyến đường đã tồn tại',
            'name.required' => 'Tên tuyến đường là bắt buộc',
            'departure_station_id.required' => 'Ga khởi hành là bắt buộc',
            'arrival_station_id.required' => 'Ga đến là bắt buộc',
            'arrival_station_id.different' => 'Ga đến phải khác ga khởi hành',
        ]);

        try {
            $route->update($request->all());
            return redirect()->route('admin.routes.index')
                ->with('success', 'Tuyến đường đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật tuyến đường: ' . $e->getMessage());
        }
    }

    public function destroy(Route $route)
    {
        try {
            if ($route->trains()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa tuyến đường đã có tàu chạy.');
            }

            if ($route->routeSegments()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa tuyến đường đã có đoạn tuyến.');
            }

            $route->delete();
            return redirect()->route('admin.routes.index')
                ->with('success', 'Tuyến đường đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa tuyến đường: ' . $e->getMessage());
        }
    }
}
