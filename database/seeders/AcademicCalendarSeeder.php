<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicCalendar;
use Carbon\Carbon;

class AcademicCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Awal Tahun Ajaran 2024/2025',
                'description' => 'Dimulainya tahun ajaran baru 2024/2025',
                'start_date' => '2024-07-15',
                'end_date' => '2024-07-15',
                'type' => 'semester',
                'priority' => 'high',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#10B981',
                'organizer' => 'SMP Negeri 01 Namrole'
            ],
            [
                'title' => 'Libur Hari Kemerdekaan RI',
                'description' => 'Hari Kemerdekaan Republik Indonesia',
                'start_date' => '2024-08-17',
                'end_date' => '2024-08-17',
                'type' => 'hari_besar',
                'priority' => 'high',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#EF4444',
                'organizer' => 'Pemerintah RI'
            ],
            [
                'title' => 'Ujian Tengah Semester Ganjil',
                'description' => 'Ujian Tengah Semester Ganjil Tahun Ajaran 2024/2025',
                'start_date' => '2024-09-23',
                'end_date' => '2024-09-27',
                'type' => 'ujian',
                'priority' => 'critical',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#F59E0B',
                'organizer' => 'SMP Negeri 01 Namrole'
            ],
            [
                'title' => 'Libur Semester Ganjil',
                'description' => 'Libur akhir semester ganjil',
                'start_date' => '2024-12-21',
                'end_date' => '2025-01-05',
                'type' => 'libur',
                'priority' => 'medium',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#8B5CF6',
                'organizer' => 'SMP Negeri 01 Namrole'
            ],
            [
                'title' => 'Awal Semester Genap',
                'description' => 'Dimulainya semester genap tahun ajaran 2024/2025',
                'start_date' => '2025-01-06',
                'end_date' => '2025-01-06',
                'type' => 'semester',
                'priority' => 'high',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#10B981',
                'organizer' => 'SMP Negeri 01 Namrole'
            ],
            [
                'title' => 'Ujian Akhir Semester Genap',
                'description' => 'Ujian Akhir Semester Genap Tahun Ajaran 2024/2025',
                'start_date' => '2025-05-19',
                'end_date' => '2025-05-23',
                'type' => 'ujian',
                'priority' => 'critical',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#F59E0B',
                'organizer' => 'SMP Negeri 01 Namrole'
            ],
            [
                'title' => 'Studi Wisata Kelas 8',
                'description' => 'Kegiatan studi wisata untuk siswa kelas 8',
                'start_date' => '2024-10-15',
                'end_date' => '2024-10-17',
                'type' => 'kegiatan',
                'priority' => 'medium',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#06B6D4',
                'organizer' => 'SMP Negeri 01 Namrole',
                'location' => 'Bali'
            ],
            [
                'title' => 'Camping OSIS',
                'description' => 'Kegiatan camping untuk pengurus OSIS',
                'start_date' => '2024-11-08',
                'end_date' => '2024-11-10',
                'type' => 'kegiatan',
                'priority' => 'medium',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#06B6D4',
                'organizer' => 'OSIS SMP Negeri 01 Namrole',
                'location' => 'Gunung Batur'
            ],
            [
                'title' => 'Hari Guru Nasional',
                'description' => 'Peringatan Hari Guru Nasional',
                'start_date' => '2024-11-25',
                'end_date' => '2024-11-25',
                'type' => 'hari_besar',
                'priority' => 'high',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#EF4444',
                'organizer' => 'SMP Negeri 01 Namrole'
            ],
            [
                'title' => 'Libur Hari Raya Idul Fitri',
                'description' => 'Libur Hari Raya Idul Fitri 1446 H',
                'start_date' => '2025-03-29',
                'end_date' => '2025-04-02',
                'type' => 'libur',
                'priority' => 'high',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#8B5CF6',
                'organizer' => 'Pemerintah RI'
            ],
            [
                'title' => 'Ujian Tengah Semester Ganjil 2025/2026',
                'description' => 'Ujian Tengah Semester Ganjil Tahun Ajaran 2025/2026',
                'start_date' => '2025-10-15',
                'end_date' => '2025-10-19',
                'type' => 'ujian',
                'priority' => 'critical',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#F59E0B',
                'organizer' => 'SMP Negeri 01 Namrole'
            ],
            [
                'title' => 'Hari Sumpah Pemuda',
                'description' => 'Peringatan Hari Sumpah Pemuda',
                'start_date' => '2025-10-28',
                'end_date' => '2025-10-28',
                'type' => 'hari_besar',
                'priority' => 'high',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#EF4444',
                'organizer' => 'SMP Negeri 01 Namrole'
            ],
            [
                'title' => 'Kegiatan Pramuka',
                'description' => 'Kegiatan ekstrakurikuler Pramuka',
                'start_date' => '2025-10-12',
                'end_date' => '2025-10-12',
                'type' => 'kegiatan',
                'priority' => 'medium',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#06B6D4',
                'organizer' => 'SMP Negeri 01 Namrole',
                'location' => 'Lapangan Sekolah'
            ],
            [
                'title' => 'Lomba Matematika',
                'description' => 'Lomba matematika tingkat kabupaten',
                'start_date' => '2025-10-25',
                'end_date' => '2025-10-25',
                'type' => 'kegiatan',
                'priority' => 'high',
                'is_all_day' => true,
                'is_public' => true,
                'color' => '#06B6D4',
                'organizer' => 'SMP Negeri 01 Namrole',
                'location' => 'Aula Sekolah'
            ]
        ];

        foreach ($events as $event) {
            AcademicCalendar::updateOrCreate(
                [
                    'title' => $event['title'],
                    'start_date' => $event['start_date']
                ],
                $event
            );
        }
    }
}