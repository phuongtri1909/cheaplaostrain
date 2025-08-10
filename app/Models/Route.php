<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure_station_id',
        'arrival_station_id',
        'code',
        'name',
        'distance_km',
        'estimated_duration_minutes',
        'is_active'
    ];

    protected $casts = [
        'distance_km' => 'decimal:2',
        'estimated_duration_minutes' => 'integer',
        'is_active' => 'boolean'
    ];

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function departureStation() { return $this->belongsTo(Station::class, 'departure_station_id')->withDefault(); }
    public function arrivalStation() { return $this->belongsTo(Station::class, 'arrival_station_id')->withDefault(); }

    public function trains() { return $this->hasMany(Train::class); }
    public function schedules() { return $this->hasMany(Schedule::class); }
}
