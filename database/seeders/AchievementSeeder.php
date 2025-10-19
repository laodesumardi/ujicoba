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
            // Prestasi Akademik
            [
                'type' => 'academic',
                'title' => 'Juara 1 Olimpiade Matematika Tingkat Kabupaten',
                'description' => 'Siswa berhasil meraih juara 1 dalam olimpiade matematika tingkat kabupaten.',
                'level' => 'kabupaten',
                'year' => 2023,
                'position' => 'Juara 1',
                'participant_name' => 'Ahmad Rizki',
                'notes' => 'Prestasi membanggakan dalam bidang matematika',
                'is_active' => true
            ],
            [
                'type' => 'academic',
                'title' => 'Juara 2 Lomba Cerdas Cermat Tingkat Provinsi',
                'description' => 'Tim cerdas cermat berhasil meraih juara 2 tingkat provinsi.',
                'level' => 'provinsi',
                'year' => 2023,
                'position' => 'Juara 2',
                'participant_name' => 'Tim Cerdas Cermat',
                'notes' => 'Kompetisi ketat dengan sekolah-sekolah unggulan',
                'is_active' => true
            ],
            [
                'type' => 'academic',
                'title' => 'Juara 1 Olimpiade IPA Tingkat Kabupaten',
                'description' => 'Prestasi gemilang dalam olimpiade IPA tingkat kabupaten.',
                'level' => 'kabupaten',
                'year' => 2022,
                'position' => 'Juara 1',
                'participant_name' => 'Siti Nurhaliza',
                'notes' => 'Mengalahkan 50 peserta dari berbagai sekolah',
                'is_active' => true
            ],
            [
                'type' => 'academic',
                'title' => 'Juara 3 Lomba Debat Bahasa Inggris Tingkat Provinsi',
                'description' => 'Tim debat bahasa Inggris meraih juara 3 tingkat provinsi.',
                'level' => 'provinsi',
                'year' => 2022,
                'position' => 'Juara 3',
                'participant_name' => 'Tim Debat Bahasa Inggris',
                'notes' => 'Prestasi pertama dalam lomba debat bahasa Inggris',
                'is_active' => true
            ],
            // Prestasi Non-Akademik
            [
                'type' => 'non_academic',
                'title' => 'Juara 1 Lomba Pidato Tingkat Kabupaten',
                'description' => 'Siswa berhasil meraih juara 1 dalam lomba pidato tingkat kabupaten.',
                'level' => 'kabupaten',
                'year' => 2023,
                'position' => 'Juara 1',
                'participant_name' => 'Muhammad Fajar',
                'notes' => 'Pidato dengan tema "Pendidikan Karakter"',
                'is_active' => true
            ],
            [
                'type' => 'non_academic',
                'title' => 'Juara 2 Lomba Tari Tradisional Tingkat Provinsi',
                'description' => 'Kelompok tari tradisional meraih juara 2 tingkat provinsi.',
                'level' => 'provinsi',
                'year' => 2023,
                'position' => 'Juara 2',
                'participant_name' => 'Kelompok Tari Tradisional',
                'notes' => 'Menampilkan tarian daerah yang memukau',
                'is_active' => true
            ],
            [
                'type' => 'non_academic',
                'title' => 'Juara 1 Lomba Paduan Suara Tingkat Kabupaten',
                'description' => 'Paduan suara sekolah meraih juara 1 tingkat kabupaten.',
                'level' => 'kabupaten',
                'year' => 2022,
                'position' => 'Juara 1',
                'participant_name' => 'Paduan Suara SMP Negeri 01 Namrole',
                'notes' => 'Harmoni yang indah dan menyentuh hati',
                'is_active' => true
            ],
            [
                'type' => 'non_academic',
                'title' => 'Juara 3 Lomba Futsal Tingkat Kabupaten',
                'description' => 'Tim futsal putra meraih juara 3 tingkat kabupaten.',
                'level' => 'kabupaten',
                'year' => 2022,
                'position' => 'Juara 3',
                'participant_name' => 'Tim Futsal Putra',
                'notes' => 'Prestasi membanggakan dalam olahraga futsal',
                'is_active' => true
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
