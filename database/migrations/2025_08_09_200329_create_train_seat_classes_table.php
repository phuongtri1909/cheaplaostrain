<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('train_seat_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained()->cascadeOnDelete();
            $table->foreignId('seat_class_id')->constrained()->cascadeOnDelete();
            $table->integer('total_seats');
            $table->integer('available_seats');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['train_id', 'seat_class_id'], 'train_seat_class_unique');
            $table->index(['train_id']);
            $table->index(['seat_class_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('train_seat_classes');
    }
};
