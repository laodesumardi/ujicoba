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
            $table->string('image_one')->nullable()->after('missions');
            $table->string('image_two')->nullable()->after('image_one');
            $table->string('image_three')->nullable()->after('image_two');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vision_missions', function (Blueprint $table) {
            $table->dropColumn(['image_one', 'image_two', 'image_three']);
        });
    }
};
