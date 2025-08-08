<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmtpSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
        'admin_email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Tự động áp dụng cài đặt SMTP để ghi đè cấu hình mặc định
     */
    public static function applySettings()
    {
        $settings = self::first();

        if ($settings && $settings->is_active) {
            config([
                'mail.mailers.smtp.host' => $settings->host,
                'mail.mailers.smtp.port' => $settings->port,
                'mail.mailers.smtp.encryption' => $settings->encryption,
                'mail.mailers.smtp.username' => $settings->username,
                'mail.mailers.smtp.password' => $settings->password,
                'mail.from.address' => $settings->from_address,
                'mail.from.name' => $settings->from_name,
            ]);
        }
    }

    /**
     * Tạo hoặc cập nhật cài đặt SMTP
     */
    public static function updateSettings($data)
    {
        $settings = self::first();

        if ($settings) {
            return $settings->update($data);
        } else {
            return self::create($data);
        }
    }

    /**
     * Lấy email admin để gửi thông báo
     */
    public static function getAdminEmail()
    {
        $settings = self::first();
        return $settings && $settings->admin_email ? $settings->admin_email : null;
    }
}
