<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained()->cascadeOnDelete();
            $table->foreignId('route_id')->constrained()->cascadeOnDelete();
            $table->timestamp('departure_datetime');
            $table->timestamp('arrival_datetime');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['train_id']);
            $table->index(['route_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
