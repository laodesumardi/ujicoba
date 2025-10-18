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
            // Class information
            if (!Schema::hasColumn('users', 'class_section')) {
                $table->string('class_section')->nullable()->after('class_level');
            }
            
            // Personal information
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('users', 'religion')) {
                $table->string('religion')->nullable()->after('gender');
            }
            
            // Previous school information
            if (!Schema::hasColumn('users', 'previous_school')) {
                $table->string('previous_school')->nullable()->after('religion');
            }
            if (!Schema::hasColumn('users', 'previous_school_address')) {
                $table->text('previous_school_address')->nullable()->after('previous_school');
            }
            if (!Schema::hasColumn('users', 'graduation_year')) {
                $table->integer('graduation_year')->nullable()->after('previous_school_address');
            }
            if (!Schema::hasColumn('users', 'transfer_reason')) {
                $table->string('transfer_reason')->nullable()->after('graduation_year');
            }
            
            // Health information
            if (!Schema::hasColumn('users', 'blood_type')) {
                $table->string('blood_type')->nullable()->after('transfer_reason');
            }
            if (!Schema::hasColumn('users', 'allergies')) {
                $table->string('allergies')->nullable()->after('blood_type');
            }
            if (!Schema::hasColumn('users', 'medical_conditions')) {
                $table->text('medical_conditions')->nullable()->after('allergies');
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
                'class_section',
                'gender',
                'religion',
                'previous_school',
                'previous_school_address',
                'graduation_year',
                'transfer_reason',
                'blood_type',
                'allergies',
                'medical_conditions'
            ]);
        });
    }
};