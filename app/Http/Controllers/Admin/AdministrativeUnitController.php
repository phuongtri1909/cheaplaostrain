<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdministrativeUnit;
use App\Models\Country;
use Illuminate\Http\Request;

class AdministrativeUnitController extends Controller
{
    public function index(Request $request)
    {
        $query = AdministrativeUnit::with(['country', 'parent']);

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $administrativeUnits = $query->orderBy('level', 'asc')
                                   ->orderBy('name', 'asc')
                                   ->paginate(15)
                                   ->withQueryString();

        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $types = [
            'province' => 'Tỉnh',
            'district' => 'Huyện',
            'subdistrict' => 'Xã',
            'town' => 'Thị trấn',
            'village' => 'Làng'
        ];

        return view('admin.pages.administrative-units.index', compact('administrativeUnits', 'countries', 'types'));
    }

    public function create()
    {
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $parentUnits = AdministrativeUnit::where('is_active', true)
                                        ->orderBy('level')
                                        ->orderBy('name')
                                        ->get();

        $types = [
            'province' => 'Tỉnh',
            'district' => 'Huyện',
            'subdistrict' => 'Xã',
            'town' => 'Thị trấn',
            'village' => 'Làng'
        ];

        return view('admin.pages.administrative-units.create', compact('countries', 'parentUnits', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'parent_id' => 'nullable|exists:administrative_units,id',
            'code' => 'required|string|max:10|unique:administrative_units,code',
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'type' => 'required|in:province,district,subdistrict,town,village',
            'level' => 'required|integer|min:1|max:5',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ], [
            'country_id.required' => 'Quốc gia là bắt buộc',
            'code.required' => 'Mã đơn vị là bắt buộc',
            'code.unique' => 'Mã đơn vị đã tồn tại',
            'name.required' => 'Tên đơn vị là bắt buộc',
            'type.required' => 'Loại đơn vị là bắt buộc',
            'level.required' => 'Cấp độ là bắt buộc',
        ]);

        try {
            AdministrativeUnit::create($request->all());
            return redirect()->route('admin.administrative-units.index')->with('success', 'Đơn vị hành chính đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra khi tạo đơn vị hành chính.');
        }
    }

    public function edit(AdministrativeUnit $administrativeUnit)
    {
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $parentUnits = AdministrativeUnit::where('is_active', true)
                                        ->where('id', '!=', $administrativeUnit->id)
                                        ->orderBy('level')
                                        ->orderBy('name')
                                        ->get();

        $types = [
            'province' => 'Tỉnh',
            'district' => 'Huyện',
            'subdistrict' => 'Xã',
            'town' => 'Thị trấn',
            'village' => 'Làng'
        ];

        return view('admin.pages.administrative-units.edit', compact('administrativeUnit', 'countries', 'parentUnits', 'types'));
    }

    public function update(Request $request, AdministrativeUnit $administrativeUnit)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'parent_id' => 'nullable|exists:administrative_units,id',
            'code' => 'required|string|max:10|unique:administrative_units,code,' . $administrativeUnit->id,
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'type' => 'required|in:province,district,subdistrict,town,village',
            'level' => 'required|integer|min:1|max:5',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ], [
            'country_id.required' => 'Quốc gia là bắt buộc',
            'code.required' => 'Mã đơn vị là bắt buộc',
            'code.unique' => 'Mã đơn vị đã tồn tại',
            'name.required' => 'Tên đơn vị là bắt buộc',
            'type.required' => 'Loại đơn vị là bắt buộc',
            'level.required' => 'Cấp độ là bắt buộc',
        ]);

        try {
            $administrativeUnit->update($request->all());
            return redirect()->route('admin.administrative-units.index')->with('success', 'Đơn vị hành chính đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra khi cập nhật đơn vị hành chính.');
        }
    }

    public function destroy(AdministrativeUnit $administrativeUnit)
    {
        try {
            if ($administrativeUnit->children()->count() > 0) {
                return redirect()->back()->with('error', 'Không thể xóa đơn vị hành chính đã có đơn vị con.');
            }
            if ($administrativeUnit->stations()->count() > 0) {
                return redirect()->back()->with('error', 'Không thể xóa đơn vị hành chính đã có ga tàu.');
            }
            $administrativeUnit->delete();
            return redirect()->route('admin.administrative-units.index')->with('success', 'Đơn vị hành chính đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa đơn vị hành chính.');
        }
    }

    public function getByCountry(Request $request)
    {
        $units = AdministrativeUnit::where('country_id', $request->country_id)
                                  ->where('is_active', true)
                                  ->orderBy('level')
                                  ->orderBy('name')
                                  ->get();
        return response()->json($units);
    }
}
