<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedule_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('train_seat_class_id')->constrained()->cascadeOnDelete();
           $table->decimal('price', 12, 2);
            $table->string('currency', 10)->nullable();
            $table->date('effective_from')->nullable();
            $table->date('effective_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['schedule_id', 'train_seat_class_id'], 'schedule_price_unique');
            $table->index(['schedule_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedule_prices');
    }
};
