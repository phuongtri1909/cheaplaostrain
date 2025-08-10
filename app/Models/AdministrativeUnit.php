<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrativeUnit extends Model
{
    use HasFactory;

    const LEVEL_PROVINCE = 1;
    const LEVEL_DISTRICT = 2;

    const TYPE_PROVINCE = 'province';
    const TYPE_DISTRICT = 'district';
    const TYPE_SUBDISTRICT = 'subdistrict';
    const TYPE_TOWN = 'town';
    const TYPE_VILLAGE = 'village';

    protected $fillable = [
        'country_id', 'parent_id', 'code', 'name', 'local_name',
        'type', 'level', 'latitude', 'longitude', 'is_active'
    ];

    protected $casts = [
        'level' => 'integer',
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
    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->withDefault();
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function stations()
    {
        return $this->hasMany(Station::class, 'administrative_unit_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */
    public function getProvince()
    {
        return $this->level === self::LEVEL_PROVINCE
            ? $this
            : ($this->parent ? $this->parent->getProvince() : null);
    }

    public function isProvince()
    {
        return $this->level === self::LEVEL_PROVINCE;
    }

    public function isDistrict()
    {
        return $this->level === self::LEVEL_DISTRICT;
    }

    public function getFullPath()
    {
        $path = [$this->name];
        $current = $this->parent;
        while ($current) {
            array_unshift($path, $current->name);
            $current = $current->parent;
        }
        return implode(' → ', $path);
    }
}
