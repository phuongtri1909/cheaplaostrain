<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->nullable()->constrained()->nullOnDelete();
            $table->string('train_number', 50)->unique();
            $table->string('train_type')->nullable();
            $table->string('operator')->nullable();
            $table->integer('total_seats');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['route_id', 'is_active']);
            $table->index('train_number');
            $table->index('operator');
        });
    }

    public function down()
    {
        Schema::dropIfExists('trains');
    }
};
