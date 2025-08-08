<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Session\Session;

class UserController extends Controller
{

    public function logoutUser($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Không tìm thấy tài khoản!');
        }

        // Ngăn admin tự logout chính mình
        if (auth()->user()->id == $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể ngắt kết nối tài khoản của chính mình!');
        }


        if ($user->session_id) {

            DB::table('sessions')
            ->where('id', $user->session_id)
            ->delete();

            $user->session_id = null;
            $user->save();
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Đã ngắt kết nối tài khoản ' . $user->user_name);
    }

    public function index()
    {
        $users = User::paginate(20);
        return view('admin.pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'user_name' => 'required|unique:users,user_name',
            'full_name' => 'required',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user',
        ], [
            'user_name.required' => 'Tên tài khoản không được để trống',
            'user_name.unique' => 'Tên tài khoản đã tồn tại',
            'full_name.required' => 'Họ và tên không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'role.required' => 'Vui lòng chọn quyền',
            'role.in' => 'Quyền không hợp lệ',
        ]);

        User::create([
            'user_name' => $request->user_name,
            'full_name' => $request->full_name,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản thành công!');
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Không tìm thấy tài khoản!');
        }

        return view('admin.pages.users.edit', compact('user'));
    }

    public function update(Request $request, $user_id)
    {

        $user = User::find($user_id);

        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Không tìm thấy tài khoản!');
        }


        $request->validate([
            'user_name' => 'required|unique:users,user_name,' . $user->id,
            'full_name' => 'required',
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,user',
        ], [
            'user_name.required' => 'Tên tài khoản không được để trống',
            'user_name.unique' => 'Tên tài khoản đã tồn tại',
            'full_name.required' => 'Họ và tên không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'role.required' => 'Vui lòng chọn quyền',
            'role.in' => 'Quyền không hợp lệ',
        ]);

        $userData = [
            'user_name' => $request->user_name,
            'full_name' => $request->full_name,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    public function destroy($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Không tìm thấy tài khoản!');
        }

        if (auth()->user()->id == $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể xóa tài khoản của chính mình!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản thành công!');
    }
}
