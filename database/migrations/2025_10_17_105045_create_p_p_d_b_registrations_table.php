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
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique(); // Nomor pendaftaran
            $table->string('student_name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P']);
            $table->string('religion');
            $table->text('address');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('parent_occupation');
            $table->string('previous_school')->nullable();
            $table->text('achievements')->nullable(); // Prestasi
            $table->text('motivation')->nullable(); // Motivasi masuk sekolah
            $table->string('photo')->nullable(); // Foto siswa
            $table->string('birth_certificate')->nullable(); // Akte kelahiran
            $table->string('family_card')->nullable(); // Kartu keluarga
            $table->string('report_card')->nullable(); // Raport
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable(); // Catatan admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};
