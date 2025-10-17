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
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->text('history');
            $table->string('established_year');
            $table->string('location');
            $table->text('vision');
            $table->text('mission');
            $table->string('headmaster_name');
            $table->string('headmaster_position');
            $table->string('headmaster_education');
            $table->string('accreditation_status');
            $table->string('accreditation_number');
            $table->string('accreditation_year');
            $table->integer('accreditation_score');
            $table->string('accreditation_valid_until');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
