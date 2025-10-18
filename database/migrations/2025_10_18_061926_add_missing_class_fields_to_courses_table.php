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
        Schema::table('courses', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('courses', 'class_section')) {
                $table->string('class_section')->nullable()->after('class_level');
            }
            if (!Schema::hasColumn('courses', 'is_public')) {
                $table->boolean('is_public')->default(true)->after('class_section');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['class_section', 'is_public']);
        });
    }
};