<?php
// filepath: d:\cheaplaostrain\app\Http\Controllers\Admin\StationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\AdministrativeUnit;
use App\Models\Country;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index(Request $request)
    {
        $query = Station::with(['administrativeUnit.country']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('code', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->filled('country_id')) {
            $query->whereHas('administrativeUnit', function($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        if ($request->filled('administrative_unit_id')) {
            $query->where('administrative_unit_id', $request->administrative_unit_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $stations = $query->orderBy('name')->paginate(15)->withQueryString();

        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $administrativeUnits = AdministrativeUnit::with('country')
                                                ->where('is_active', true)
                                                ->orderBy('name')
                                                ->get();

        return view('admin.pages.stations.index', compact('stations', 'countries', 'administrativeUnits'));
    }

    public function create()
    {
        $administrativeUnits = AdministrativeUnit::with('country')
                                                ->where('is_active', true)
                                                ->orderBy('name')
                                                ->get();

        return view('admin.pages.stations.create', compact('administrativeUnits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'administrative_unit_id' => 'required|exists:administrative_units,id',
            'code' => 'required|string|max:20|unique:stations,code',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'boolean'
        ], [
            'administrative_unit_id.required' => 'Đơn vị hành chính là bắt buộc',
            'code.required' => 'Mã ga là bắt buộc',
            'code.unique' => 'Mã ga đã tồn tại',
            'name.required' => 'Tên ga là bắt buộc',
        ]);

        try {
            Station::create($request->all());
            return redirect()->route('admin.stations.index')
                ->with('success', 'Ga tàu đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo ga tàu: ' . $e->getMessage());
        }
    }

    public function show(Station $station)
    {
        $station->load(['administrativeUnit.country', 'trainStops.train', 'departureRoutes', 'arrivalRoutes']);
        return view('admin.pages.stations.show', compact('station'));
    }

    public function edit(Station $station)
    {
        $administrativeUnits = AdministrativeUnit::with('country')
                                                ->where('is_active', true)
                                                ->orderBy('name')
                                                ->get();

        return view('admin.pages.stations.edit', compact('station', 'administrativeUnits'));
    }

    public function update(Request $request, Station $station)
    {
        $request->validate([
            'administrative_unit_id' => 'required|exists:administrative_units,id',
            'code' => 'required|string|max:20|unique:stations,code,' . $station->id,
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'boolean'
        ], [
            'administrative_unit_id.required' => 'Đơn vị hành chính là bắt buộc',
            'code.required' => 'Mã ga là bắt buộc',
            'code.unique' => 'Mã ga đã tồn tại',
            'name.required' => 'Tên ga là bắt buộc',
        ]);

        try {
            $station->update($request->all());
            return redirect()->route('admin.stations.index')
                ->with('success', 'Ga tàu đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật ga tàu: ' . $e->getMessage());
        }
    }

    public function destroy(Station $station)
    {
        try {
            if ($station->trainStops()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa ga tàu đã có lịch trình tàu.');
            }

            if ($station->departureRoutes()->count() > 0 || $station->arrivalRoutes()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa ga tàu đã có tuyến đường.');
            }

            $station->delete();
            return redirect()->route('admin.stations.index')
                ->with('success', 'Ga tàu đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa ga tàu: ' . $e->getMessage());
        }
    }

    // API method for AJAX calls
    public function getByAdministrativeUnit(Request $request)
    {
        $stations = Station::where('administrative_unit_id', $request->administrative_unit_id)
                          ->where('is_active', true)
                          ->orderBy('name')
                          ->get(['id', 'code', 'name']);

        return response()->json($stations);
    }
}
