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
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            $table->string('status'); // Terakreditasi A, B, C, dll
            $table->string('certificate_number'); // Nomor sertifikat
            $table->integer('year'); // Tahun akreditasi
            $table->integer('score'); // Skor akreditasi
            $table->string('valid_until'); // Berlaku sampai
            $table->text('description')->nullable(); // Deskripsi tambahan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accreditations');
    }
};
