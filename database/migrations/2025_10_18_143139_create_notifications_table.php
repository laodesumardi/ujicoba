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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'ppdb_registration', 'message', 'system'
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable(); // icon class or emoji
            $table->string('color')->default('blue'); // blue, green, red, yellow, purple
            $table->json('data')->nullable(); // additional data
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->string('action_url')->nullable(); // URL to redirect when clicked
            $table->string('action_text')->nullable(); // Button text
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
