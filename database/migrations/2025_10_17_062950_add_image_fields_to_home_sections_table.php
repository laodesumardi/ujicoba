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
        Schema::table('home_sections', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
            $table->string('image_alt')->nullable()->after('image');
            $table->string('image_position')->default('center')->after('image_alt'); // center, left, right, top, bottom
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_sections', function (Blueprint $table) {
            $table->dropColumn(['image', 'image_alt', 'image_position']);
        });
    }
};