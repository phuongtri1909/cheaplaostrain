<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'train_number',
        'train_type',
        'operator',
        'total_seats',
        'is_active'
    ];

    protected $casts = [
        'total_seats' => 'integer',
        'is_active' => 'boolean'
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function route()
    {
        return $this->belongsTo(Route::class)->withDefault();
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function trainSeatClasses()
    {
        return $this->hasMany(TrainSeatClass::class);
    }

    public function getSeatClassInfo($seatClassId)
    {
        return $this->trainSeatClasses()
            ->where('seat_class_id', $seatClassId)
            ->where('is_active', true)
            ->first();
    }

    public function getAvailableSeats($routeSegmentId, $scheduleId, $travelDate, $seatClassId)
    {
        $trainSeatClass = $this->getSeatClassInfo($seatClassId);
        if (!$trainSeatClass) return 0;

        $bookedSeats = Ticket::where('train_id', $this->id)
            ->where('schedule_id', $scheduleId)
            ->where('travel_date', $travelDate)
            ->where('seat_class_id', $seatClassId)
            ->whereIn('booking_status', [Ticket::BOOKING_CONFIRMED, Ticket::BOOKING_PENDING])
            ->count();

        return max(0, $trainSeatClass->total_seats - $bookedSeats);
    }
}
