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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul galeri
            $table->string('slug')->unique(); // URL slug
            $table->text('description')->nullable(); // Deskripsi galeri
            $table->string('cover_image')->nullable(); // Gambar cover
            $table->enum('type', ['photo', 'video', 'mixed'])->default('photo'); // Jenis galeri
            $table->string('category'); // Kategori: kegiatan, event, profil, testimoni, dll
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft'); // Status publikasi
            $table->boolean('is_featured')->default(false); // Galeri unggulan
            $table->boolean('is_public')->default(true); // Publik atau tidak
            $table->integer('sort_order')->default(0); // Urutan tampil
            $table->json('metadata')->nullable(); // Data tambahan (video URL, dll)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
