<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('administrative_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('administrative_units')->nullOnDelete();
            $table->string('code', 50)->nullable();
            $table->string('name');
            $table->string('local_name')->nullable();
            $table->string('type', 50)->nullable();
            $table->unsignedTinyInteger('level')->default(1);
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administrative_units');
    }
};
