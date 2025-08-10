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

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function route() { return $this->belongsTo(Route::class)->withDefault(); }
    public function schedules() { return $this->hasMany(Schedule::class); }
    public function tickets() { return $this->hasMany(Ticket::class); }
    public function trainSeatClasses() { return $this->hasMany(TrainSeatClass::class); }

    // optimized: use loaded collection to avoid extra queries
    public function getStopsBetween($originStationId, $destinationStationId)
    {
        $stops = $this->relationLoaded('trainStops')
            ? $this->trainStops->keyBy('station_id')
            : $this->trainStops()->get()->keyBy('station_id');

        $originStop = $stops[$originStationId] ?? null;
        $destinationStop = $stops[$destinationStationId] ?? null;

        if (!$originStop || !$destinationStop || $originStop->stop_order >= $destinationStop->stop_order) {
            return collect();
        }

        // return slice between orders (use collection to avoid another DB query if already loaded)
        if ($this->relationLoaded('trainStops')) {
            return $this->trainStops->where('stop_order', '>=', $originStop->stop_order)
                                    ->where('stop_order', '<=', $destinationStop->stop_order)
                                    ->sortBy('stop_order')
                                    ->values();
        }

        return $this->trainStops()
                    ->where('stop_order', '>=', $originStop->stop_order)
                    ->where('stop_order', '<=', $destinationStop->stop_order)
                    ->orderBy('stop_order')
                    ->get();
    }

    public function getSeatClassInfo($seatClassId)
    {
        return $this->trainSeatClasses()->where('seat_class_id', $seatClassId)->first();
    }

    // returns available seats for a given route segment + schedule + travel_date
    public function getAvailableSeatsForSegment($routeSegmentId, $seatClassId, $scheduleId, $travelDate)
    {
        $trainSeatClass = $this->getSeatClassInfo($seatClassId);
        if (!$trainSeatClass) return 0;

        $bookedSeats = Ticket::where('train_id', $this->id)
            ->where('route_segment_id', $routeSegmentId)
            ->where('schedule_id', $scheduleId)
            ->where('travel_date', $travelDate)
            ->where('seat_class_id', $seatClassId)
            ->whereIn('booking_status', [Ticket::BOOKING_CONFIRMED, Ticket::BOOKING_PENDING])
            ->count();

        return max(0, $trainSeatClass->total_seats - $bookedSeats);
    }
}
