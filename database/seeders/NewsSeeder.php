<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsData = [
            [
                'title' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2024/2025',
                'excerpt' => 'Pendaftaran PPDB SMP Negeri 01 Namrole untuk tahun ajaran 2024/2025 telah dibuka. Segera daftarkan putra-putri Anda!',
                'content' => '<p>Kepada Yth. Orang Tua/Wali Siswa,</p><p>Dengan hormat, kami informasikan bahwa Penerimaan Peserta Didik Baru (PPDB) SMP Negeri 01 Namrole untuk Tahun Ajaran 2024/2025 telah dibuka.</p><h3>Persyaratan Pendaftaran:</h3><ul><li>Lulusan SD/MI tahun 2024</li><li>Usia maksimal 15 tahun per 1 Juli 2024</li><li>Membawa fotokopi raport kelas 4, 5, dan 6</li><li>Fotokopi akte kelahiran</li><li>Fotokopi kartu keluarga</li><li>Pas foto 3x4 (2 lembar)</li></ul><h3>Jadwal Pendaftaran:</h3><ul><li>Pendaftaran: 1-15 Juni 2024</li><li>Seleksi: 16-20 Juni 2024</li><li>Pengumuman: 25 Juni 2024</li><li>Daftar Ulang: 26-30 Juni 2024</li></ul><p>Untuk informasi lebih lanjut, silakan hubungi panitia PPDB di sekolah.</p>',
                'category' => 'akademik',
                'type' => 'announcement',
                'status' => 'published',
                'is_featured' => true,
                'is_pinned' => true,
                'published_at' => now(),
                'author_name' => 'Panitia PPDB',
                'author_email' => 'ppdb@smpnamrole.sch.id',
                'tags' => ['ppdb', 'pendaftaran', 'tahun-ajaran-2024']
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler Semester Genap 2024',
                'excerpt' => 'Berbagai kegiatan ekstrakurikuler menarik telah disiapkan untuk semester genap 2024. Daftarkan diri Anda sekarang!',
                'content' => '<p>Kepada seluruh siswa SMP Negeri 01 Namrole,</p><p>Kami informasikan bahwa pendaftaran kegiatan ekstrakurikuler semester genap tahun 2024 telah dibuka.</p><h3>Jenis Ekstrakurikuler yang Tersedia:</h3><ul><li><strong>Olahraga:</strong> Sepak Bola, Basket, Voli, Badminton</li><li><strong>Seni:</strong> Tari Tradisional, Musik, Teater</li><li><strong>Akademik:</strong> Olimpiade Matematika, Sains, Bahasa Inggris</li><li><strong>Teknologi:</strong> Robotik, Programming, Desain Grafis</li><li><strong>Kepemimpinan:</strong> OSIS, Pramuka, PMR</li></ul><h3>Jadwal Pendaftaran:</h3><ul><li>Pendaftaran: 15-25 Januari 2024</li><li>Seleksi: 26-30 Januari 2024</li><li>Pengumuman: 2 Februari 2024</li><li>Mulai Kegiatan: 5 Februari 2024</li></ul><p>Setiap siswa dapat memilih maksimal 2 ekstrakurikuler. Pendaftaran dilakukan di ruang OSIS.</p>',
                'category' => 'ekstrakurikuler',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => true,
                'is_pinned' => false,
                'published_at' => now()->subDays(2),
                'author_name' => 'Pembina OSIS',
                'author_email' => 'osis@smpnamrole.sch.id',
                'tags' => ['ekstrakurikuler', 'semester-genap', 'kegiatan-siswa']
            ],
            [
                'title' => 'Libur Nasional Bulan Februari 2024',
                'excerpt' => 'Informasi jadwal libur nasional bulan Februari 2024 dan penyesuaian kegiatan pembelajaran.',
                'content' => '<p>Kepada seluruh warga sekolah,</p><p>Berikut adalah informasi libur nasional bulan Februari 2024:</p><h3>Jadwal Libur Nasional:</h3><ul><li><strong>14 Februari 2024:</strong> Hari Valentine (Libur Nasional)</li><li><strong>17 Februari 2024:</strong> Hari Raya Imlek (Libur Nasional)</li></ul><h3>Penyesuaian Jadwal:</h3><ul><li>Kegiatan pembelajaran akan disesuaikan dengan jadwal libur</li><li>Ujian tengah semester akan dijadwalkan ulang</li><li>Kegiatan ekstrakurikuler tetap berjalan sesuai jadwal</li></ul><p>Selama masa libur, siswa diharapkan tetap belajar mandiri dan mengerjakan tugas yang diberikan guru.</p>',
                'category' => 'libur',
                'type' => 'announcement',
                'status' => 'published',
                'is_featured' => false,
                'is_pinned' => true,
                'published_at' => now()->subDays(5),
                'author_name' => 'Kepala Sekolah',
                'author_email' => 'kepsek@smpnamrole.sch.id',
                'tags' => ['libur-nasional', 'februari-2024', 'jadwal-sekolah']
            ],
            [
                'title' => 'Perubahan Jadwal Ujian Tengah Semester',
                'excerpt' => 'Jadwal ujian tengah semester genap 2024 mengalami perubahan. Silakan perhatikan jadwal yang telah diperbarui.',
                'content' => '<p>Kepada seluruh siswa dan orang tua/wali,</p><p>Kami informasikan bahwa jadwal ujian tengah semester genap tahun 2024 mengalami perubahan sebagai berikut:</p><h3>Jadwal Ujian Tengah Semester Genap 2024:</h3><ul><li><strong>Tanggal:</strong> 26 Februari - 1 Maret 2024</li><li><strong>Waktu:</strong> 07.30 - 11.30 WIB</li><li><strong>Mata Pelajaran:</strong> Semua mata pelajaran</li></ul><h3>Perubahan dari Jadwal Sebelumnya:</h3><ul><li>Ujian dimajukan 3 hari dari jadwal semula</li><li>Penyesuaian dengan jadwal libur nasional</li><li>Waktu ujian tetap sama</li></ul><h3>Persiapan Ujian:</h3><ul><li>Belajar dengan giat dan teratur</li><li>Mengerjakan latihan soal yang diberikan guru</li><li>Istirahat yang cukup</li><li>Membawa alat tulis yang lengkap</li></ul><p>Semoga semua siswa dapat mengikuti ujian dengan baik dan mendapatkan hasil yang memuaskan.</p>',
                'category' => 'jadwal',
                'type' => 'announcement',
                'status' => 'published',
                'is_featured' => false,
                'is_pinned' => false,
                'published_at' => now()->subDays(3),
                'author_name' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                'author_email' => 'wakakur@smpnamrole.sch.id',
                'tags' => ['ujian', 'tengah-semester', 'jadwal-ujian']
            ],
            [
                'title' => 'Kegiatan OSIS: Bakti Sosial ke Panti Asuhan',
                'excerpt' => 'OSIS SMP Negeri 01 Namrole mengadakan kegiatan bakti sosial ke panti asuhan. Mari bergabung dalam kegiatan mulia ini!',
                'content' => '<p>Kepada seluruh siswa SMP Negeri 01 Namrole,</p><p>OSIS mengundang seluruh siswa untuk berpartisipasi dalam kegiatan bakti sosial ke Panti Asuhan "Kasih Ibu" yang akan dilaksanakan pada:</p><h3>Detail Kegiatan:</h3><ul><li><strong>Tanggal:</strong> 18 Februari 2024</li><li><strong>Waktu:</strong> 08.00 - 12.00 WIB</li><li><strong>Tempat:</strong> Panti Asuhan "Kasih Ibu"</li><li><strong>Alamat:</strong> Jl. Kesehatan No. 15, Namrole</li></ul><h3>Kegiatan yang Akan Dilakukan:</h3><ul><li>Mengajar anak-anak panti asuhan</li><li>Membagikan bingkisan dan donasi</li><li>Bermain dan berinteraksi dengan anak-anak</li><li>Membersihkan lingkungan panti asuhan</li></ul><h3>Cara Mendaftar:</h3><ul><li>Daftar di ruang OSIS</li><li>Membawa donasi (buku, alat tulis, atau makanan)</li><li>Mengisi formulir pendaftaran</li></ul><p>Kegiatan ini akan memberikan pengalaman berharga dan mengajarkan nilai-nilai kepedulian sosial.</p>',
                'category' => 'osis',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => false,
                'is_pinned' => false,
                'published_at' => now()->subDays(1),
                'author_name' => 'Ketua OSIS',
                'author_email' => 'osis@smpnamrole.sch.id',
                'tags' => ['osis', 'bakti-sosial', 'panti-asuhan', 'kegiatan-sosial']
            ],
            [
                'title' => 'Lomba Cerdas Cermat Antar Sekolah 2024',
                'excerpt' => 'SMP Negeri 01 Namrole akan mengikuti lomba cerdas cermat antar sekolah tingkat kabupaten. Dukungan Anda sangat diharapkan!',
                'content' => '<p>Kepada seluruh warga sekolah,</p><p>Kami bangga menginformasikan bahwa SMP Negeri 01 Namrole akan mengikuti Lomba Cerdas Cermat Antar Sekolah tingkat Kabupaten yang akan diselenggarakan pada:</p><h3>Detail Lomba:</h3><ul><li><strong>Tanggal:</strong> 25 Februari 2024</li><li><strong>Waktu:</strong> 08.00 - 16.00 WIB</li><li><strong>Tempat:</strong> Aula Dinas Pendidikan Kabupaten</li><li><strong>Peserta:</strong> 3 siswa terbaik dari setiap sekolah</li></ul><h3>Tim Perwakilan SMP Negeri 01 Namrole:</h3><ul><li><strong>Ketua Tim:</strong> Ahmad Rizki (Kelas 9A)</li><li><strong>Anggota 1:</strong> Siti Nurhaliza (Kelas 9B)</li><li><strong>Anggota 2:</strong> Muhammad Fajar (Kelas 9C)</li></ul><h3>Mata Pelajaran yang Diujikan:</h3><ul><li>Matematika</li><li>IPA (Fisika, Kimia, Biologi)</li><li>IPS (Sejarah, Geografi, Ekonomi)</li><li>Bahasa Indonesia</li><li>Bahasa Inggris</li></ul><p>Mari kita dukung tim perwakilan kita dengan doa dan semangat. Semoga mereka dapat meraih prestasi terbaik!</p>',
                'category' => 'lomba',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => true,
                'is_pinned' => false,
                'published_at' => now()->subHours(12),
                'author_name' => 'Pembina Lomba',
                'author_email' => 'lomba@smpnamrole.sch.id',
                'tags' => ['lomba', 'cerdas-cermat', 'prestasi', 'kompetisi']
            ]
        ];

            foreach ($newsData as $data) {
                $slug = \Illuminate\Support\Str::slug($data['title']);
                $data['slug'] = $slug;
                
                News::updateOrCreate(
                    ['slug' => $slug],
                    $data
                );
            }
    }
}
