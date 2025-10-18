<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;

class LessonSeeder extends Seeder
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

        // Create sample lessons for each course
        foreach ($courses as $course) {
            $lessons = [
                [
                    'title' => 'Pengenalan Dasar',
                    'description' => 'Materi pengenalan dasar untuk memulai pembelajaran',
                    'content' => 'Selamat datang di kelas ' . $course->title . '!\n\nPada materi ini, kita akan mempelajari dasar-dasar yang diperlukan untuk memahami topik yang lebih lanjut.\n\nMateri yang akan dipelajari:\n1. Konsep dasar\n2. Terminologi penting\n3. Contoh praktis\n\nSilakan baca dengan seksama dan jangan ragu untuk bertanya jika ada yang kurang jelas.',
                    'type' => 'lesson',
                    'order' => 1,
                    'is_published' => true,
                    'published_at' => Carbon::now(),
                    'settings' => [
                        'allow_comments' => true,
                        'require_completion' => true,
                        'show_progress' => true
                    ]
                ],
                [
                    'title' => 'Latihan Soal',
                    'description' => 'Latihan soal untuk menguji pemahaman',
                    'content' => 'Setelah mempelajari materi sebelumnya, sekarang saatnya untuk berlatih!\n\nInstruksi:\n1. Kerjakan semua soal dengan teliti\n2. Tuliskan langkah-langkah penyelesaian\n3. Kumpulkan sebelum deadline\n\nSoal akan mencakup:\n- Konsep dasar\n- Aplikasi praktis\n- Analisis mendalam',
                    'type' => 'assignment',
                    'order' => 2,
                    'due_date' => Carbon::now()->addDays(7),
                    'points' => 100,
                    'is_published' => true,
                    'published_at' => Carbon::now(),
                    'settings' => [
                        'allow_comments' => true,
                        'require_completion' => true,
                        'show_progress' => true
                    ]
                ],
                [
                    'title' => 'Kuis Singkat',
                    'description' => 'Kuis untuk menguji pemahaman cepat',
                    'content' => 'Kuis ini bertujuan untuk menguji pemahaman Anda terhadap materi yang telah dipelajari.\n\nAturan:\n- Waktu: 30 menit\n- Tidak boleh membuka buku\n- Kerjakan dengan jujur\n\nPertanyaan akan mencakup:\n- Konsep dasar (40%)\n- Aplikasi (40%)\n- Analisis (20%)',
                    'type' => 'quiz',
                    'order' => 3,
                    'due_date' => Carbon::now()->addDays(3),
                    'points' => 50,
                    'is_published' => true,
                    'published_at' => Carbon::now(),
                    'settings' => [
                        'allow_comments' => false,
                        'require_completion' => true,
                        'show_progress' => true
                    ]
                ],
                [
                    'title' => 'Materi Lanjutan',
                    'description' => 'Materi lanjutan untuk pengembangan lebih dalam',
                    'content' => 'Setelah menguasai dasar-dasar, sekarang kita akan mempelajari konsep yang lebih lanjut.\n\nTopik yang akan dibahas:\n1. Konsep lanjutan\n2. Aplikasi dalam kehidupan nyata\n3. Studi kasus\n4. Praktik langsung\n\nMateri ini memerlukan pemahaman yang baik terhadap materi sebelumnya.',
                    'type' => 'lesson',
                    'order' => 4,
                    'is_published' => true,
                    'published_at' => Carbon::now(),
                    'settings' => [
                        'allow_comments' => true,
                        'require_completion' => true,
                        'show_progress' => true
                    ]
                ],
                [
                    'title' => 'Proyek Akhir',
                    'description' => 'Proyek akhir untuk mengaplikasikan semua yang telah dipelajari',
                    'content' => 'Proyek ini adalah kesempatan untuk mengaplikasikan semua yang telah Anda pelajari.\n\nTugas:\n1. Pilih topik yang menarik\n2. Lakukan penelitian mendalam\n3. Buat presentasi yang menarik\n4. Presentasikan di depan kelas\n\nKriteria penilaian:\n- Kreativitas (30%)\n- Kedalaman analisis (40%)\n- Presentasi (30%)',
                    'type' => 'project',
                    'order' => 5,
                    'due_date' => Carbon::now()->addDays(21),
                    'points' => 150,
                    'is_published' => true,
                    'published_at' => Carbon::now(),
                    'settings' => [
                        'allow_comments' => true,
                        'require_completion' => true,
                        'show_progress' => true
                    ]
                ]
            ];

            foreach ($lessons as $lessonData) {
                Lesson::create(array_merge($lessonData, [
                    'course_id' => $course->id
                ]));
            }
        }

        $this->command->info('Sample lessons created successfully!');
    }
}