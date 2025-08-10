<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'sort_order','image', 'is_active'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean'
    ];

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function trainSeatClasses() { return $this->hasMany(TrainSeatClass::class); }
    public function tickets() { return $this->hasMany(Ticket::class); }
}
