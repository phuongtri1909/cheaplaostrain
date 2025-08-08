<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('icon');
            $table->string('url');
            $table->boolean('status')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Add default social media
        $this->seedDefaultSocialMedia();
    }

    /**
     * Seed default social media entries
     */
    private function seedDefaultSocialMedia(): void
    {
        $socials = [
            [
                'platform' => 'Facebook',
                'icon' => 'fab fa-facebook-f',
                'url' => '#',
                'status' => true,
                'order' => 1
            ],
            [
                'platform' => 'Twitter',
                'icon' => 'fab fa-twitter',
                'url' => '#',
                'status' => true,
                'order' => 2
            ],
            [
                'platform' => 'LinkedIn',
                'icon' => 'fab fa-linkedin-in',
                'url' => '#',
                'status' => true,
                'order' => 3
            ],
            [
                'platform' => 'Instagram',
                'icon' => 'fab fa-instagram',
                'url' => '#',
                'status' => true,
                'order' => 4
            ],
        ];

        foreach ($socials as $social) {
            DB::table('social_media')->insert($social);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};