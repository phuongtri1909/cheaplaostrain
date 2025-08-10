<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainSeatClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id', 'seat_class_id', 'total_seats', 'available_seats', 'is_active'
    ];

    protected $casts = [
        'total_seats' => 'integer',
        'available_seats' => 'integer',
        'is_active' => 'boolean'
    ];

    public function train() { return $this->belongsTo(Train::class)->withDefault(); }
    public function seatClass() { return $this->belongsTo(SeatClass::class)->withDefault(); }
    public function schedulePrices() { return $this->hasMany(SchedulePrice::class); }
}
