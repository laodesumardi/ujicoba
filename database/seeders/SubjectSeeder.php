<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'code' => 'MAT',
                'name' => 'Matematika',
                'description' => 'Mata pelajaran yang mempelajari tentang angka, geometri, aljabar, dan logika matematika.',
                'level' => 'SMP',
                'hours_per_week' => 4,
                'color' => '#3B82F6',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'code' => 'BIN',
                'name' => 'Bahasa Indonesia',
                'description' => 'Mata pelajaran yang mempelajari tentang bahasa Indonesia, sastra, dan komunikasi.',
                'level' => 'SMP',
                'hours_per_week' => 4,
                'color' => '#EF4444',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'code' => 'BING',
                'name' => 'Bahasa Inggris',
                'description' => 'Mata pelajaran yang mempelajari tentang bahasa Inggris untuk komunikasi internasional.',
                'level' => 'SMP',
                'hours_per_week' => 3,
                'color' => '#10B981',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'code' => 'IPA',
                'name' => 'Ilmu Pengetahuan Alam',
                'description' => 'Mata pelajaran yang mempelajari tentang fenomena alam, fisika, kimia, dan biologi.',
                'level' => 'SMP',
                'hours_per_week' => 4,
                'color' => '#F59E0B',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'code' => 'IPS',
                'name' => 'Ilmu Pengetahuan Sosial',
                'description' => 'Mata pelajaran yang mempelajari tentang masyarakat, sejarah, geografi, dan ekonomi.',
                'level' => 'SMP',
                'hours_per_week' => 3,
                'color' => '#8B5CF6',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'code' => 'PKN',
                'name' => 'Pendidikan Kewarganegaraan',
                'description' => 'Mata pelajaran yang mempelajari tentang kewarganegaraan, demokrasi, dan hak asasi manusia.',
                'level' => 'SMP',
                'hours_per_week' => 2,
                'color' => '#F97316',
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'code' => 'PJOK',
                'name' => 'Pendidikan Jasmani, Olahraga dan Kesehatan',
                'description' => 'Mata pelajaran yang mempelajari tentang olahraga, kesehatan, dan kebugaran jasmani.',
                'level' => 'SMP',
                'hours_per_week' => 2,
                'color' => '#06B6D4',
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'code' => 'SENI',
                'name' => 'Seni Budaya',
                'description' => 'Mata pelajaran yang mempelajari tentang seni rupa, musik, tari, dan teater.',
                'level' => 'SMP',
                'hours_per_week' => 2,
                'color' => '#EC4899',
                'is_active' => true,
                'sort_order' => 8
            ],
            [
                'code' => 'PRAKARYA',
                'name' => 'Prakarya',
                'description' => 'Mata pelajaran yang mempelajari tentang kerajinan, rekayasa, budidaya, dan pengolahan.',
                'level' => 'SMP',
                'hours_per_week' => 2,
                'color' => '#84CC16',
                'is_active' => true,
                'sort_order' => 9
            ],
            [
                'code' => 'PAI',
                'name' => 'Pendidikan Agama Islam',
                'description' => 'Mata pelajaran yang mempelajari tentang ajaran Islam, akhlak, dan ibadah.',
                'level' => 'SMP',
                'hours_per_week' => 2,
                'color' => '#14B8A6',
                'is_active' => true,
                'sort_order' => 10
            ]
        ];

        foreach ($subjects as $subject) {
            Subject::updateOrCreate(
                ['code' => $subject['code']],
                $subject
            );
        }
    }
}