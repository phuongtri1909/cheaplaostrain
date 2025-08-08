<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Validator;

class SmtpSettingController extends Controller
{
    /**
     * Hiển thị form chỉnh sửa cài đặt SMTP
     */
    public function edit()
    {
        $smtpSetting = SmtpSetting::first() ?? new SmtpSetting();

        return view('admin.pages.smtp-setting.edit', compact('smtpSetting'));
    }

    /**
     * Cập nhật cài đặt SMTP
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'host' => 'required|string|max:255',
            'port' => 'required|integer',
            'username' => 'required|string|max:255',
            'password' => 'required|string',
            'encryption' => 'required|in:tls,ssl',
            'from_address' => 'required|email|max:255',
            'from_name' => 'required|string|max:255',
            'admin_email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cập nhật hoặc tạo mới cài đặt
        $data = $request->only([
            'host',
            'port',
            'username',
            'password',
            'encryption',
            'from_address',
            'from_name',
            'admin_email'
        ]);
        $data['is_active'] = $request->has('is_active') ? true : false;

        SmtpSetting::updateSettings($data);

        return redirect()
            ->route('admin.smtp-settings.edit')
            ->with('success', __('smtp.success.update'));
    }

    public function sendTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            SmtpSetting::applySettings();

            Mail::to($request->test_email)->send(new TestMail());

            return response()->json([
                'success' => true,
                'message' => __('smtp.success.test_email')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('smtp.error.test_email') . ': ' . $e->getMessage()
            ], 500);
        }
    }
}
