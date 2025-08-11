<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    const BOOKING_PENDING = 'pending';
    const BOOKING_CONFIRMED = 'confirmed';
    const BOOKING_CANCELLED = 'cancelled';

    const PAYMENT_UNPAID = 'unpaid';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_REFUNDED = 'refunded';

    protected $fillable = [
        'ticket_number',
        'schedule_id',
        'train_id',
        'route_id',
        'seat_class_id',
        'travel_date',
        'passenger_name',
        'passenger_email',
        'seat_number',
        'price',
        'currency',
        'booking_status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'booked_at',
        'expires_at',
        'ip_address',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'price' => 'decimal:2',
        'booked_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = 'TKT-' . strtoupper(Str::random(8));
            }
        });
    }

    public function schedule() { return $this->belongsTo(Schedule::class)->withDefault(); }
    public function train() { return $this->belongsTo(Train::class)->withDefault(); }
    public function route() { return $this->belongsTo(Route::class)->withDefault(); }
    public function seatClass() { return $this->belongsTo(SeatClass::class)->withDefault(); }

    public function isExpired() { return $this->expires_at && now()->isAfter($this->expires_at); }
    public function isConfirmed() { return $this->booking_status === self::BOOKING_CONFIRMED && $this->payment_status === self::PAYMENT_PAID; }
}
