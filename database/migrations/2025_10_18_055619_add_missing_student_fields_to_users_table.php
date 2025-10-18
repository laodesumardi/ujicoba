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
        Schema::table('users', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('users', 'class_level')) {
                $table->string('class_level')->nullable()->after('student_id');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('class_level');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'parent_name')) {
                $table->string('parent_name')->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('users', 'parent_phone')) {
                $table->string('parent_phone')->nullable()->after('parent_name');
            }
            if (!Schema::hasColumn('users', 'parent_email')) {
                $table->string('parent_email')->nullable()->after('parent_phone');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('parent_email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'class_level',
                'phone',
                'address',
                'date_of_birth',
                'parent_name',
                'parent_phone',
                'parent_email',
                'is_active'
            ]);
        });
    }
};