<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $query = Country::query();

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('code')) {
            $query->where('code', 'LIKE', '%' . $request->code . '%');
        }

        $countries = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return view('admin.pages.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.pages.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:countries,code',
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'currency_code' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'timezone' => 'nullable|string|max:50',
        ], [
            'code.required' => 'Mã quốc gia là bắt buộc',
            'code.unique' => 'Mã quốc gia đã tồn tại',
            'name.required' => 'Tên quốc gia là bắt buộc',
        ]);

        try {
            Country::create($request->all());
            return redirect()->route('admin.countries.index')->with('success', 'Quốc gia đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra khi tạo quốc gia.');
        }
    }

    public function edit(Country $country)
    {
        return view('admin.pages.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:countries,code,' . $country->id,
            'name' => 'required|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'currency_code' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'timezone' => 'nullable|string|max:50',
        ], [
            'code.required' => 'Mã quốc gia là bắt buộc',
            'code.unique' => 'Mã quốc gia đã tồn tại',
            'name.required' => 'Tên quốc gia là bắt buộc',
        ]);

        try {
            $country->update($request->all());
            return redirect()->route('admin.countries.index')->with('success', 'Quốc gia đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra khi cập nhật quốc gia.');
        }
    }

    public function destroy(Country $country)
    {
        try {
            if ($country->administrativeUnits()->count() > 0) {
                return redirect()->back()->with('error', 'Không thể xóa quốc gia đã có đơn vị hành chính.');
            }
            $country->delete();
            return redirect()->route('admin.countries.index')->with('success', 'Quốc gia đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa quốc gia.');
        }
    }
}
