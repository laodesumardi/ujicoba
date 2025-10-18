<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum to include 'project'
        DB::statement("ALTER TABLE lessons MODIFY COLUMN type ENUM('lesson', 'assignment', 'quiz', 'exam', 'project') DEFAULT 'lesson'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE lessons MODIFY COLUMN type ENUM('lesson', 'assignment', 'quiz', 'exam') DEFAULT 'lesson'");
    }
};