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
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('opening_hours')->nullable();
            $table->text('services')->nullable();
            $table->text('rules')->nullable();
            $table->string('librarian_name')->nullable();
            $table->string('librarian_phone')->nullable();
            $table->string('librarian_email')->nullable();
            $table->string('organization_chart')->nullable();
            $table->text('facilities')->nullable();
            $table->text('collection_info')->nullable();
            $table->text('membership_info')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};
