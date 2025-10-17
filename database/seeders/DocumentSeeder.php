<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\HomeSection;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Download Center section
        HomeSection::updateOrCreate(
            ['section_key' => 'download-center'],
            [
                'title' => 'Download Center',
                'subtitle' => 'Dokumen Resmi dan Formulir Sekolah',
                'description' => 'Akses berbagai dokumen resmi, formulir, pedoman akademik, jadwal, dan laporan sekolah yang dapat diunduh secara gratis.',
                'is_active' => true,
                'sort_order' => 7
            ]
        );

        // Sample documents
        $documents = [
            [
                'title' => 'Surat Edaran Penerimaan Siswa Baru 2024/2025',
                'description' => 'Surat edaran resmi mengenai penerimaan siswa baru untuk tahun ajaran 2024/2025.',
                'category' => 'surat_edaran',
                'type' => 'pdf',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now(),
                'file_path' => 'documents/surat_edaran_ppdb_2024.pdf',
                'file_name' => 'Surat Edaran PPDB 2024.pdf',
                'file_size' => 245760, // 240 KB
                'file_type' => 'application/pdf',
                'download_count' => 156,
                'tags' => ['ppdb', 'pendaftaran', '2024']
            ],
            [
                'title' => 'Formulir Cuti/Izin Siswa',
                'description' => 'Formulir untuk mengajukan cuti atau izin tidak masuk sekolah.',
                'category' => 'formulir',
                'type' => 'pdf',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(5),
                'file_path' => 'documents/formulir_cuti_siswa.pdf',
                'file_name' => 'Formulir Cuti Siswa.pdf',
                'file_size' => 128000, // 125 KB
                'file_type' => 'application/pdf',
                'download_count' => 89,
                'tags' => ['formulir', 'cuti', 'izin']
            ],
            [
                'title' => 'Pedoman Akademik SMP Negeri 01 Namrole',
                'description' => 'Pedoman lengkap mengenai sistem akademik, penilaian, dan aturan sekolah.',
                'category' => 'pedoman',
                'type' => 'pdf',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(10),
                'file_path' => 'documents/pedoman_akademik_2024.pdf',
                'file_name' => 'Pedoman Akademik 2024.pdf',
                'file_size' => 1024000, // 1 MB
                'file_type' => 'application/pdf',
                'download_count' => 234,
                'tags' => ['pedoman', 'akademik', 'aturan']
            ],
            [
                'title' => 'Jadwal Ujian Semester Ganjil 2024',
                'description' => 'Jadwal lengkap ujian semester ganjil untuk semua kelas dan mata pelajaran.',
                'category' => 'jadwal',
                'type' => 'pdf',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'file_path' => 'documents/jadwal_ujian_semester_ganjil_2024.pdf',
                'file_name' => 'Jadwal Ujian Semester Ganjil 2024.pdf',
                'file_size' => 512000, // 500 KB
                'file_type' => 'application/pdf',
                'download_count' => 178,
                'tags' => ['jadwal', 'ujian', 'semester']
            ],
            [
                'title' => 'Kurikulum Merdeka Kelas VII',
                'description' => 'Kurikulum Merdeka untuk kelas VII dengan silabus dan RPP lengkap.',
                'category' => 'kurikulum',
                'type' => 'pdf',
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'file_path' => 'documents/kurikulum_merdeka_kelas_7.pdf',
                'file_name' => 'Kurikulum Merdeka Kelas VII.pdf',
                'file_size' => 2048000, // 2 MB
                'file_type' => 'application/pdf',
                'download_count' => 145,
                'tags' => ['kurikulum', 'merdeka', 'kelas_7']
            ],
            [
                'title' => 'Laporan Keuangan Sekolah Triwulan I 2024',
                'description' => 'Laporan keuangan sekolah untuk triwulan pertama tahun 2024.',
                'category' => 'laporan',
                'type' => 'pdf',
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'file_path' => 'documents/laporan_keuangan_triwulan_1_2024.pdf',
                'file_name' => 'Laporan Keuangan Triwulan I 2024.pdf',
                'file_size' => 768000, // 750 KB
                'file_type' => 'application/pdf',
                'download_count' => 67,
                'tags' => ['laporan', 'keuangan', 'triwulan']
            ],
            [
                'title' => 'Formulir Pendaftaran Ekstrakurikuler',
                'description' => 'Formulir untuk mendaftar mengikuti kegiatan ekstrakurikuler.',
                'category' => 'formulir',
                'type' => 'pdf',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'file_path' => 'documents/formulir_ekstrakurikuler.pdf',
                'file_name' => 'Formulir Ekstrakurikuler.pdf',
                'file_size' => 96000, // 94 KB
                'file_type' => 'application/pdf',
                'download_count' => 45,
                'tags' => ['formulir', 'ekstrakurikuler', 'pendaftaran']
            ],
            [
                'title' => 'Jadwal Kegiatan OSIS Bulan Oktober 2024',
                'description' => 'Jadwal kegiatan OSIS untuk bulan Oktober 2024.',
                'category' => 'jadwal',
                'type' => 'pdf',
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'file_path' => 'documents/jadwal_osis_oktober_2024.pdf',
                'file_name' => 'Jadwal OSIS Oktober 2024.pdf',
                'file_size' => 192000, // 188 KB
                'file_type' => 'application/pdf',
                'download_count' => 78,
                'tags' => ['jadwal', 'osis', 'oktober']
            ]
        ];

        foreach ($documents as $documentData) {
            Document::updateOrCreate(
                ['title' => $documentData['title']],
                $documentData
            );
        }
    }
}
