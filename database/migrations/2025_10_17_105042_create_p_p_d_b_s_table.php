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
        Schema::create('ppdb_info', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('requirements')->nullable(); // Persyaratan pendaftaran
            $table->text('schedule')->nullable(); // Jadwal penting
            $table->text('technical_guide')->nullable(); // Petunjuk teknis
            $table->text('faq')->nullable(); // FAQ
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('registration_link')->nullable(); // Link formulir online
            $table->boolean('is_active')->default(true);
            $table->date('registration_start')->nullable();
            $table->date('registration_end')->nullable();
            $table->integer('quota')->nullable(); // Kuota penerimaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_info');
    }
};
