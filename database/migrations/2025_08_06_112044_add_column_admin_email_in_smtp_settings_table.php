<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('smtp_settings', function (Blueprint $table) {
            $table->string('admin_email')->nullable()->after('from_name');
        });
    }

    public function down()
    {
        Schema::table('smtp_settings', function (Blueprint $table) {
            $table->dropColumn('admin_email');
        });
    }
};
