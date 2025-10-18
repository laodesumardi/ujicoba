<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get teacher and courses
        $teacher = User::where('role', 'teacher')->first();
        if (!$teacher) {
            $this->command->info('No teacher found. Please run UserRoleSeeder first.');
            return;
        }

        $courses = Course::where('teacher_id', $teacher->id)->get();
        if ($courses->isEmpty()) {
            $this->command->info('No courses found. Please create courses first.');
            return;
        }

        // Create sample assignments
        $assignments = [
            [
                'title' => 'Tugas Matematika - Aljabar',
                'description' => 'Kerjakan soal-soal aljabar berikut dengan benar.',
                'instructions' => '1. Kerjakan semua soal dengan teliti\n2. Tuliskan langkah-langkah penyelesaian\n3. Kumpulkan sebelum deadline',
                'type' => 'assignment',
                'points' => 100,
                'due_date' => Carbon::now()->addDays(7),
                'is_published' => true,
                'published_at' => Carbon::now(),
                'allow_late_submission' => true,
                'late_penalty' => 10,
            ],
            [
                'title' => 'Kuis Bahasa Indonesia',
                'description' => 'Kuis tentang materi puisi dan prosa.',
                'instructions' => '1. Jawab semua pertanyaan dengan benar\n2. Waktu pengerjaan: 30 menit\n3. Tidak boleh membuka buku',
                'type' => 'quiz',
                'points' => 50,
                'due_date' => Carbon::now()->addDays(3),
                'is_published' => true,
                'published_at' => Carbon::now(),
                'allow_late_submission' => false,
                'late_penalty' => 0,
            ],
            [
                'title' => 'Ujian Tengah Semester IPA',
                'description' => 'Ujian tengah semester untuk mata pelajaran IPA.',
                'instructions' => '1. Kerjakan dengan jujur\n2. Waktu: 120 menit\n3. Bawa alat tulis lengkap',
                'type' => 'exam',
                'points' => 100,
                'due_date' => Carbon::now()->addDays(14),
                'is_published' => true,
                'published_at' => Carbon::now(),
                'allow_late_submission' => false,
                'late_penalty' => 0,
            ],
            [
                'title' => 'Proyek Sejarah - Timeline Perjuangan',
                'description' => 'Buat timeline perjuangan kemerdekaan Indonesia.',
                'instructions' => '1. Buat timeline yang menarik\n2. Sertakan gambar dan penjelasan\n3. Presentasikan di depan kelas',
                'type' => 'project',
                'points' => 150,
                'due_date' => Carbon::now()->addDays(21),
                'is_published' => true,
                'published_at' => Carbon::now(),
                'allow_late_submission' => true,
                'late_penalty' => 5,
            ],
            [
                'title' => 'Tugas Bahasa Inggris - Essay',
                'description' => 'Tulis essay tentang lingkungan dalam bahasa Inggris.',
                'instructions' => '1. Minimal 300 kata\n2. Gunakan grammar yang benar\n3. Sertakan referensi',
                'type' => 'assignment',
                'points' => 80,
                'due_date' => Carbon::now()->addDays(5),
                'is_published' => true,
                'published_at' => Carbon::now(),
                'allow_late_submission' => true,
                'late_penalty' => 15,
            ],
        ];

        foreach ($courses as $course) {
            foreach ($assignments as $assignmentData) {
                Assignment::create(array_merge($assignmentData, [
                    'course_id' => $course->id,
                    'rubric' => [
                        'criteria' => [
                            'Kemampuan' => 40,
                            'Kreativitas' => 30,
                            'Ketepatan Waktu' => 20,
                            'Presentasi' => 10
                        ]
                    ]
                ]));
            }
        }

        $this->command->info('Sample assignments created successfully!');
    }
}