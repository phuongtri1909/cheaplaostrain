<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departure_station_id')->constrained('stations')->cascadeOnDelete();
            $table->foreignId('arrival_station_id')->constrained('stations')->cascadeOnDelete();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->decimal('distance_km', 10, 2)->nullable();
            $table->unsignedInteger('estimated_duration_minutes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('routes');
    }
};
