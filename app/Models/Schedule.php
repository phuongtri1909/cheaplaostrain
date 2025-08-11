<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id',
        'route_id',
        'departure_datetime',
        'arrival_datetime',
        'is_active'
    ];

    protected $casts = [
        'departure_datetime' => 'datetime',
        'arrival_datetime' => 'datetime',
        'is_active' => 'boolean'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function train()
    {
        return $this->belongsTo(Train::class)->withDefault();
    }

    public function route()
    {
        return $this->belongsTo(Route::class)->withDefault();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function schedulePrices()
    {
        return $this->hasMany(SchedulePrice::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */
    public function getDepartureDateAttribute()
    {
        return $this->departure_datetime ? $this->departure_datetime->format('Y-m-d') : null;
    }

    public function getDepartureTimeAttribute()
    {
        return $this->departure_datetime ? $this->departure_datetime->format('H:i') : null;
    }

    public function getArrivalDateAttribute()
    {
        return $this->arrival_datetime ? $this->arrival_datetime->format('Y-m-d') : null;
    }

    public function getArrivalTimeAttribute()
    {
        return $this->arrival_datetime ? $this->arrival_datetime->format('H:i') : null;
    }

    public function getFormattedDepartureAttribute()
    {
        return $this->departure_datetime ? $this->departure_datetime->format('H:i') : null;
    }

    public function getFormattedArrivalAttribute()
    {
        return $this->arrival_datetime ? $this->arrival_datetime->format('H:i') : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOnDate($query, $date)
    {
        return $query->whereDate('departure_datetime', $date);
    }

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('departure_datetime', [$startDate, $endDate]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */
    public function getDurationInMinutes()
    {
        if (!$this->departure_datetime || !$this->arrival_datetime) {
            return 0;
        }

        return $this->departure_datetime->diffInMinutes($this->arrival_datetime);
    }

    public function getFormattedDuration()
    {
        $minutes = $this->getDurationInMinutes();

        if ($minutes <= 0) return '0m';

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        if ($hours > 0) {
            return $hours . 'h ' . ($remainingMinutes > 0 ? $remainingMinutes . 'm' : '');
        }

        return $remainingMinutes . 'm';
    }

    public function isOperatingOnDate($date)
    {
        $targetDate = Carbon::parse($date);
        $scheduleDate = $this->departure_datetime ? Carbon::parse($this->departure_datetime) : null;

        return $scheduleDate && $scheduleDate->isSameDay($targetDate);
    }
}
