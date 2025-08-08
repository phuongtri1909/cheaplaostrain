<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'icon',
        'url',
        'status',
        'order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}