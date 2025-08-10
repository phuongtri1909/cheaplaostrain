<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id', 'train_seat_class_id', 'price', 'currency', 'effective_from', 'effective_until', 'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'effective_from' => 'date',
        'effective_until' => 'date',
        'is_active' => 'boolean'
    ];

    public function schedule() { return $this->belongsTo(Schedule::class)->withDefault(); }
    public function trainSeatClass() { return $this->belongsTo(TrainSeatClass::class)->withDefault(); }
}
