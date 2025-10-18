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
        Schema::table('achievements', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('achievements', 'category')) {
                $table->string('category')->nullable()->after('description');
            }
            if (!Schema::hasColumn('achievements', 'level')) {
                $table->string('level')->nullable()->after('category');
            }
            if (!Schema::hasColumn('achievements', 'student_name')) {
                $table->string('student_name')->nullable()->after('year');
            }
            if (!Schema::hasColumn('achievements', 'student_class')) {
                $table->string('student_class')->nullable()->after('student_name');
            }
            if (!Schema::hasColumn('achievements', 'teacher_name')) {
                $table->string('teacher_name')->nullable()->after('student_class');
            }
            if (!Schema::hasColumn('achievements', 'position')) {
                $table->string('position')->nullable()->after('teacher_name');
            }
            if (!Schema::hasColumn('achievements', 'event_name')) {
                $table->string('event_name')->nullable()->after('position');
            }
            if (!Schema::hasColumn('achievements', 'organizer')) {
                $table->string('organizer')->nullable()->after('event_name');
            }
            if (!Schema::hasColumn('achievements', 'certificate_image')) {
                $table->string('certificate_image')->nullable()->after('organizer');
            }
            if (!Schema::hasColumn('achievements', 'photo')) {
                $table->string('photo')->nullable()->after('certificate_image');
            }
            if (!Schema::hasColumn('achievements', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('photo');
            }
            if (!Schema::hasColumn('achievements', 'is_public')) {
                $table->boolean('is_public')->default(true)->after('is_featured');
            }
            if (!Schema::hasColumn('achievements', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_public');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'category',
                'level',
                'student_name',
                'student_class',
                'teacher_name',
                'position',
                'event_name',
                'organizer',
                'certificate_image',
                'photo',
                'is_featured',
                'is_public',
                'sort_order'
            ]);
        });
    }
};
