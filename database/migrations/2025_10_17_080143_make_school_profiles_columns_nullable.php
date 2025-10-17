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
            $table->string('school_name')->nullable()->change();
            $table->text('history')->nullable()->change();
            $table->string('established_year')->nullable()->change();
            $table->string('location')->nullable()->change();
            $table->text('vision')->nullable()->change();
            $table->text('mission')->nullable()->change();
            $table->string('headmaster_name')->nullable()->change();
            $table->string('headmaster_position')->nullable()->change();
            $table->string('headmaster_education')->nullable()->change();
            $table->string('accreditation_status')->nullable()->change();
            $table->string('accreditation_number')->nullable()->change();
            $table->string('accreditation_year')->nullable()->change();
            $table->integer('accreditation_score')->nullable()->change();
            $table->string('accreditation_valid_until')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->string('school_name')->nullable(false)->change();
            $table->text('history')->nullable(false)->change();
            $table->string('established_year')->nullable(false)->change();
            $table->string('location')->nullable(false)->change();
            $table->text('vision')->nullable(false)->change();
            $table->text('mission')->nullable(false)->change();
            $table->string('headmaster_name')->nullable(false)->change();
            $table->string('headmaster_position')->nullable(false)->change();
            $table->string('headmaster_education')->nullable(false)->change();
            $table->string('accreditation_status')->nullable(false)->change();
            $table->string('accreditation_number')->nullable(false)->change();
            $table->string('accreditation_year')->nullable(false)->change();
            $table->integer('accreditation_score')->nullable(false)->change();
            $table->string('accreditation_valid_until')->nullable(false)->change();
        });
    }
};
