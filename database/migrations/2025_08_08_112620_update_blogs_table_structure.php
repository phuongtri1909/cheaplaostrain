<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (Schema::hasColumn('blogs', 'status')) {
                $table->dropColumn('status');
            }
            
            if (!Schema::hasColumn('blogs', 'is_published')) {
                $table->boolean('is_published')->default(true)->after('featured_image');
            }
            
            if (!Schema::hasColumn('blogs', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'status')) {
                $table->boolean('status')->default(true)->after('featured_image');
            }
            
            if (Schema::hasColumn('blogs', 'is_published')) {
                $table->dropColumn('is_published');
            }
            
            if (Schema::hasColumn('blogs', 'published_at')) {
                $table->dropColumn('published_at');
            }
        });
    }
};