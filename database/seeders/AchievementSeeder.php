<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'title' => 'Juara 1 Lomba Matematika Tingkat Provinsi',
                'description' => 'Siswa berhasil meraih juara 1 dalam lomba matematika tingkat provinsi yang diadakan oleh Dinas Pendidikan.',
                'category' => 'academic',
                'level' => 'provincial',
                'year' => '2024',
                'student_name' => 'Ahmad Rizki',
                'student_class' => '9A',
                'teacher_name' => 'Bu Sari',
                'position' => 'Juara 1',
                'event_name' => 'Olimpiade Matematika Provinsi',
                'organizer' => 'Dinas Pendidikan Provinsi',
                'is_featured' => true,
                'is_public' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Juara 2 Lomba Pidato Bahasa Indonesia',
                'description' => 'Prestasi membanggakan dalam lomba pidato bahasa Indonesia tingkat kabupaten.',
                'category' => 'arts',
                'level' => 'district',
                'year' => '2024',
                'student_name' => 'Siti Nurhaliza',
                'student_class' => '8B',
                'teacher_name' => 'Pak Budi',
                'position' => 'Juara 2',
                'event_name' => 'Lomba Pidato Bahasa Indonesia',
                'organizer' => 'Dinas Pendidikan Kabupaten',
                'is_featured' => true,
                'is_public' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Juara 1 Futsal Putra Tingkat Sekolah',
                'description' => 'Tim futsal putra berhasil meraih juara 1 dalam turnamen futsal antar sekolah.',
                'category' => 'sports',
                'level' => 'school',
                'year' => '2024',
                'student_name' => 'Tim Futsal Putra',
                'student_class' => '9A, 9B, 8A',
                'teacher_name' => 'Pak Andi',
                'position' => 'Juara 1',
                'event_name' => 'Turnamen Futsal Antar Sekolah',
                'organizer' => 'MGMP Olahraga',
                'is_featured' => false,
                'is_public' => true,
                'sort_order' => 3
            ],
            [
                'title' => 'Peserta Terbaik Lomba Karya Ilmiah',
                'description' => 'Siswa berhasil menjadi peserta terbaik dalam lomba karya ilmiah tingkat nasional.',
                'category' => 'science',
                'level' => 'national',
                'year' => '2024',
                'student_name' => 'Muhammad Fajar',
                'student_class' => '9C',
                'teacher_name' => 'Bu Dewi',
                'position' => 'Peserta Terbaik',
                'event_name' => 'Lomba Karya Ilmiah Nasional',
                'organizer' => 'Kementerian Pendidikan',
                'is_featured' => true,
                'is_public' => true,
                'sort_order' => 4
            ],
            [
                'title' => 'Juara 3 Lomba Tari Tradisional',
                'description' => 'Kelompok tari tradisional berhasil meraih juara 3 dalam festival seni budaya.',
                'category' => 'arts',
                'level' => 'provincial',
                'year' => '2024',
                'student_name' => 'Kelompok Tari Tradisional',
                'student_class' => '8A, 8B, 9A',
                'teacher_name' => 'Bu Rina',
                'position' => 'Juara 3',
                'event_name' => 'Festival Seni Budaya',
                'organizer' => 'Dinas Kebudayaan Provinsi',
                'is_featured' => false,
                'is_public' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['title' => $achievement['title'], 'year' => $achievement['year']],
                $achievement
            );
        }
    }
}
