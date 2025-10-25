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
        Schema::table('libraries', function (Blueprint $table) {
            // Add missing columns that were in the duplicate migration
            if (!Schema::hasColumn('libraries', 'vision')) {
                $table->text('vision')->nullable();
            }
            if (!Schema::hasColumn('libraries', 'mission')) {
                $table->text('mission')->nullable();
            }
            if (!Schema::hasColumn('libraries', 'goals')) {
                $table->text('goals')->nullable();
            }
            if (!Schema::hasColumn('libraries', 'logo')) {
                $table->string('logo')->nullable();
            }
            if (!Schema::hasColumn('libraries', 'banner_image')) {
                $table->string('banner_image')->nullable();
            }
            if (!Schema::hasColumn('libraries', 'gallery_images')) {
                $table->json('gallery_images')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('libraries', function (Blueprint $table) {
            $table->dropColumn([
                'vision',
                'mission', 
                'goals',
                'logo',
                'banner_image',
                'gallery_images'
            ]);
        });
    }
};
