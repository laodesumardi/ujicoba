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
        Schema::table('achievements', function (Blueprint $table) {
            if (!Schema::hasColumn('achievements', 'participant_name')) {
                $table->string('participant_name')->nullable()->after('position');
            }
            if (!Schema::hasColumn('achievements', 'notes')) {
                $table->text('notes')->nullable()->after('participant_name');
            }
            if (!Schema::hasColumn('achievements', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn(['participant_name', 'notes', 'is_active']);
        });
    }
};
