<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forum;
use App\Models\User;
use App\Models\Course;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a teacher user
        $teacher = User::where('role', 'teacher')->first();
        if (!$teacher) {
            $teacher = User::create([
                'name' => 'Guru Matematika',
                'email' => 'guru@example.com',
                'password' => bcrypt('password'),
                'role' => 'teacher',
                'phone' => '081234567890',
                'address' => 'Alamat Guru',
                'subject' => 'Matematika',
                'position' => 'Guru',
                'class_level' => 'VII',
                'class_section' => 'A',
                'employment_status' => 'active',
                'education' => 'S1 Matematika',
                'certification' => 'Sertifikat Guru',
                'experience_years' => 5,
                'bio' => 'Guru matematika berpengalaman'
            ]);
        }

        // Get or create a course
        $course = Course::first();
        if (!$course) {
            $course = Course::create([
                'title' => 'Matematika Dasar',
                'description' => 'Materi matematika dasar',
                'teacher_id' => $teacher->id,
                'class_level' => 'VII',
                'class_section' => 'A',
                'subject' => 'Matematika',
                'status' => 'active'
            ]);
        }

        // Create forums
        $forums = [
            [
                'id' => 1,
                'title' => 'Diskusi Materi Pertama',
                'description' => 'Diskusi tentang materi matematika dasar',
                'course_id' => $course->id,
                'author_id' => $teacher->id,
                'type' => 'general',
                'is_pinned' => false,
                'is_locked' => false,
                'views' => 0,
                'replies_count' => 0
            ],
            [
                'id' => 2,
                'title' => 'Tanya Jawab Tugas',
                'description' => 'Forum untuk bertanya tentang tugas',
                'course_id' => $course->id,
                'author_id' => $teacher->id,
                'type' => 'qna',
                'is_pinned' => true,
                'is_locked' => false,
                'views' => 0,
                'replies_count' => 0
            ]
        ];

        foreach ($forums as $forumData) {
            Forum::updateOrCreate(
                ['id' => $forumData['id']],
                $forumData
            );
        }
    }
}
