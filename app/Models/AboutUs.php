<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'about_us';

    protected $fillable = [
        'title',
        'subtitle', 
        'content',
        'hero_image',
        'features',
        'stats',
        'team_members',
        'mission_title',
        'mission_content',
        'vision_title',
        'vision_content',
        'values_title',
        'values_content',
        'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'stats' => 'array', 
        'team_members' => 'array',
        'is_active' => 'boolean'
    ];

    // Singleton method
    public static function getSingleton()
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'About Us',
                'content' => 'Please update this content...',
                'is_active' => true
            ]
        );
    }

    // Frontend method  
    public static function getActiveContent()
    {
        return self::getSingleton();
    }

    // Prevent multiple records
    protected static function booted()
    {
        static::creating(function ($model) {
            // Only allow 1 record
            if (self::count() >= 1) {
                return false;
            }
        });
    }
}