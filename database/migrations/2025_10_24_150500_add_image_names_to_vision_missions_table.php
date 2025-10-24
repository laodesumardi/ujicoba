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
        Schema::table('vision_missions', function (Blueprint $table) {
            $table->string('image_one_name')->nullable()->after('image_one');
            $table->string('image_two_name')->nullable()->after('image_two');
            $table->string('image_three_name')->nullable()->after('image_three');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vision_missions', function (Blueprint $table) {
            $table->dropColumn(['image_one_name', 'image_two_name', 'image_three_name']);
        });
    }
};