<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id', 'route_id', 'departure_time', 'arrival_time',
        'operating_days', 'effective_from', 'effective_until', 'is_active'
    ];

    protected $casts = [
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
        'operating_days' => 'array',
        'effective_from' => 'date',
        'effective_until' => 'date',
        'is_active' => 'boolean'
    ];

    public function train() { return $this->belongsTo(Train::class)->withDefault(); }
    public function route() { return $this->belongsTo(Route::class)->withDefault(); }
    public function tickets() { return $this->hasMany(Ticket::class); }
    public function schedulePrices() { return $this->hasMany(SchedulePrice::class); }

    // check operating day by date (expects string|Date)
    public function isOperatingOnDate($date)
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeekIso; // 1-7
        return in_array($dayOfWeek, $this->operating_days ?? []);
    }

    // get price row for a given seat class (schedule-level prices)
    public function getPriceForSeatClass($seatClassId, $date = null)
    {
        $query = $this->schedulePrices()->whereHas('trainSeatClass', function ($q) use ($seatClassId) {
            $q->where('seat_class_id', $seatClassId);
        })->where('is_active', true);

        if ($date) {
            $query->where('effective_from', '<=', $date)
                  ->where(function($q) use ($date) {
                      $q->whereNull('effective_until')->orWhere('effective_until', '>=', $date);
                  });
        }

        return $query->first();
    }

    // return train seat classes with schedule prices for this schedule
    public function getAvailableSeatClasses($travelDate = null)
    {
        return $this->train->trainSeatClasses()
            ->with(['seatClass', 'schedulePrices' => function($q) use ($travelDate) {
                $q->where('schedule_id', $this->id);
                if ($travelDate) {
                    $q->where('effective_from', '<=', $travelDate)
                      ->where(function($qq) use ($travelDate) {
                          $qq->whereNull('effective_until')->orWhere('effective_until', '>=', $travelDate);
                      });
                }
            }])
            ->where('is_active', true)
            ->get();
    }
}
