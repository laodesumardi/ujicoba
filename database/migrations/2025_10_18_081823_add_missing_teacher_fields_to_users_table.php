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
        Schema::table('users', function (Blueprint $table) {
            // Check if columns exist before adding
            if (!Schema::hasColumn('users', 'subject')) {
                $table->string('subject')->nullable()->after('religion');
            }
            if (!Schema::hasColumn('users', 'position')) {
                $table->string('position')->nullable()->after('subject');
            }
            if (!Schema::hasColumn('users', 'employment_status')) {
                $table->enum('employment_status', ['Aktif', 'Non-Aktif', 'Cuti'])->nullable()->after('position');
            }
            if (!Schema::hasColumn('users', 'join_date')) {
                $table->date('join_date')->nullable()->after('employment_status');
            }
            if (!Schema::hasColumn('users', 'education')) {
                $table->string('education')->nullable()->after('join_date');
            }
            if (!Schema::hasColumn('users', 'certification')) {
                $table->string('certification')->nullable()->after('education');
            }
            if (!Schema::hasColumn('users', 'experience_years')) {
                $table->integer('experience_years')->nullable()->after('certification');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('experience_years');
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable()->after('bio');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'subject',
                'position',
                'employment_status',
                'join_date',
                'education',
                'certification',
                'experience_years',
                'bio',
                'photo'
            ]);
        });
    }
};