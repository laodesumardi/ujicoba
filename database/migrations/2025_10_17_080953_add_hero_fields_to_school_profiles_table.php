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
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn(['button_text', 'button_link', 'background_color', 'text_color']);
        });
    }
};
