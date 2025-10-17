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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul berita
            $table->string('slug')->unique(); // URL slug
            $table->text('excerpt')->nullable(); // Ringkasan berita
            $table->longText('content'); // Konten lengkap
            $table->string('featured_image')->nullable(); // Gambar utama
            $table->string('category'); // Kategori: akademik, ekstrakurikuler, libur, jadwal, osis, lomba
            $table->enum('type', ['news', 'announcement'])->default('news'); // Jenis: berita atau pengumuman
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft'); // Status publikasi
            $table->boolean('is_featured')->default(false); // Berita utama
            $table->boolean('is_pinned')->default(false); // Berita yang dipasang di atas
            $table->integer('views')->default(0); // Jumlah pembaca
            $table->timestamp('published_at')->nullable(); // Tanggal publikasi
            $table->string('author_name')->nullable(); // Nama penulis
            $table->string('author_email')->nullable(); // Email penulis
            $table->json('tags')->nullable(); // Tag berita
            $table->json('meta_data')->nullable(); // Data meta tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
