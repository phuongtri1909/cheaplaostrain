<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 50)->unique();

            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('train_id')->constrained()->cascadeOnDelete();
            $table->foreignId('route_id')->constrained()->cascadeOnDelete();

            $table->foreignId('seat_class_id')->constrained()->cascadeOnDelete();

            $table->date('travel_date');
            $table->string('passenger_name');
            $table->string('passenger_email')->nullable();

            $table->string('seat_number', 50)->nullable();

            $table->decimal('price', 12, 2);
            $table->string('currency', 10)->nullable();

            $table->string('booking_status', 30)->default('pending'); // pending, confirmed, cancelled
            $table->string('payment_status', 30)->default('unpaid'); // unpaid, paid, refunded
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_reference', 100)->nullable();

            $table->timestamp('booked_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();

            $table->index(['schedule_id', 'travel_date']);
            $table->index(['booking_status']);
            $table->index(['payment_status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
