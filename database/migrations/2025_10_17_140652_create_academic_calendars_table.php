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
        Schema::create('academic_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul acara
            $table->text('description')->nullable(); // Deskripsi acara
            $table->date('start_date'); // Tanggal mulai
            $table->date('end_date')->nullable(); // Tanggal selesai (opsional)
            $table->time('start_time')->nullable(); // Waktu mulai
            $table->time('end_time')->nullable(); // Waktu selesai
            $table->enum('type', ['semester', 'ujian', 'libur', 'hari_besar', 'kegiatan', 'lainnya']); // Jenis acara
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium'); // Prioritas
            $table->string('location')->nullable(); // Lokasi acara
            $table->string('organizer')->nullable(); // Penyelenggara
            $table->boolean('is_all_day')->default(false); // Acara sepanjang hari
            $table->boolean('is_public')->default(true); // Acara publik
            $table->boolean('is_downloadable')->default(false); // Dapat diunduh
            $table->string('file_path')->nullable(); // Path file yang dapat diunduh
            $table->string('color')->default('#3B82F6'); // Warna untuk kalender
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_calendars');
    }
};
