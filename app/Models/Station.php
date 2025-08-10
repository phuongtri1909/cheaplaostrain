<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'administrative_unit_id', 'code', 'name',
        'address', 'latitude', 'longitude', 'is_active'
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'is_active' => 'boolean'
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function administrativeUnit()
    {
        return $this->belongsTo(AdministrativeUnit::class)->withDefault();
    }

    public function departureRoutes()
    {
        return $this->hasMany(Route::class, 'departure_station_id');
    }

    public function arrivalRoutes()
    {
        return $this->hasMany(Route::class, 'arrival_station_id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */
    public function getProvince()
    {
        return $this->administrativeUnit?->getProvince();
    }

    public function getFullLocationPath()
    {
        return $this->administrativeUnit?->getFullPath() ?? '';
    }
}
