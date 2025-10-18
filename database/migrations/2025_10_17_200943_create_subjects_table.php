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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode mata pelajaran (e.g., MAT, BIN, IPA)
            $table->string('name'); // Nama mata pelajaran
            $table->text('description')->nullable(); // Deskripsi mata pelajaran
            $table->string('level')->default('SMP'); // Tingkat pendidikan (SD, SMP, SMA)
            $table->integer('hours_per_week')->default(2); // Jam per minggu
            $table->string('color')->default('#3B82F6'); // Warna untuk identifikasi
            $table->boolean('is_active')->default(true); // Status aktif
            $table->integer('sort_order')->default(0); // Urutan tampil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};