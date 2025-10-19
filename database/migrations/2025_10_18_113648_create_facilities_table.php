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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama fasilitas
            $table->text('description')->nullable(); // Deskripsi fasilitas
            $table->string('image')->nullable(); // Gambar fasilitas
            $table->string('icon')->nullable(); // Icon fasilitas
            $table->string('category')->default('general'); // Kategori fasilitas
            $table->integer('sort_order')->default(0); // Urutan tampil
            $table->boolean('is_active')->default(true); // Status aktif
            $table->boolean('is_featured')->default(false); // Fasilitas unggulan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
