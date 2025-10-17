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
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->onDelete('cascade'); // Relasi ke gallery
            $table->string('title')->nullable(); // Judul item
            $table->text('description')->nullable(); // Deskripsi item
            $table->string('file_path'); // Path file (gambar/video)
            $table->string('file_type'); // Jenis file: image, video
            $table->string('mime_type')->nullable(); // MIME type file
            $table->integer('file_size')->nullable(); // Ukuran file dalam bytes
            $table->integer('width')->nullable(); // Lebar (untuk gambar/video)
            $table->integer('height')->nullable(); // Tinggi (untuk gambar/video)
            $table->integer('duration')->nullable(); // Durasi (untuk video, dalam detik)
            $table->string('thumbnail_path')->nullable(); // Path thumbnail (untuk video)
            $table->integer('sort_order')->default(0); // Urutan dalam galeri
            $table->boolean('is_featured')->default(false); // Item unggulan
            $table->json('metadata')->nullable(); // Data tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
    }
};
