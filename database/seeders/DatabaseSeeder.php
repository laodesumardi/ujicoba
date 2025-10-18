<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed role-based data first
        $this->call([
            RoleBasedDataSeeder::class,
            HomeSectionSeeder::class,
            SchoolProfileSeeder::class,
            NewsSeeder::class,
            AcademicCalendarSeeder::class,
            GallerySeeder::class,
            DocumentSeeder::class,
            AchievementSeeder::class,
            SubjectSeeder::class,
            AssignmentSeeder::class,
            LessonSeeder::class,
        ]);
    }
}
