<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|min:6',
        ], [
            'password.required' => 'Mât khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'user_name.required' => 'Tên đăng nhập không được để trống',
            'user_name.string' => 'Tên đăng nhập phải là chuỗi',
        ]);

        $credentials = $request->only('user_name', 'password');
        
        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            $user->session_id = session()->getId();
            $user->save();
    
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
    
            return redirect()->route('home');
        }
        
        return back()->with('error', 'Thông tin xác thực không chính xác')->withInput();
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}
