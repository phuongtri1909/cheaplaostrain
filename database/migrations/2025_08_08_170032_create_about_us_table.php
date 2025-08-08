<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->longText('content');
            $table->string('hero_image')->nullable();
            $table->json('features')->nullable();
            $table->json('stats')->nullable();
            $table->json('team_members')->nullable();
            $table->string('mission_title')->nullable();
            $table->text('mission_content')->nullable();
            $table->string('vision_title')->nullable();
            $table->text('vision_content')->nullable();
            $table->string('values_title')->nullable();
            $table->text('values_content')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_us');
    }
};