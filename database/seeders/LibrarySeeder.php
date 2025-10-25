<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Library;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Library::create([
            'name' => 'Perpustakaan SMP Negeri 01 Namrole',
            'description' => 'Perpustakaan sekolah yang menyediakan berbagai koleksi buku dan sumber belajar untuk mendukung proses pembelajaran siswa.',
            'location' => 'Gedung Utama Lantai 2, SMP Negeri 01 Namrole',
            'phone' => '(0910) 123456',
            'email' => 'perpustakaan@smpn01namrole.sch.id',
            'opening_hours' => "Senin - Jumat: 07:00 - 15:00\nSabtu: 07:00 - 12:00\nMinggu: Tutup",
            'services' => "Peminjaman Buku\nPengembalian Buku\nKonsultasi Literasi\nAkses Internet\nFotokopi\nLayanan Referensi",
            'rules' => "Wajib membawa kartu anggota\nMaksimal 3 buku per peminjaman\nDurasi peminjaman 7 hari\nDenda keterlambatan Rp 500/hari\nDilarang makan dan minum di dalam\nWajib menjaga ketenangan",
            'librarian_name' => 'Ibu Sari Indah, S.Pd',
            'librarian_phone' => '081234567890',
            'librarian_email' => 'sari.indah@smpn01namrole.sch.id',
            'facilities' => "Ruang Baca\nRuang Diskusi\nKomputer dengan Internet\nPrinter dan Fotokopi\nRak Buku Terorganisir\nAC dan Pencahayaan Memadai",
            'collection_info' => "Koleksi buku meliputi:\n- Buku Pelajaran (Kurikulum 2013)\n- Buku Referensi\n- Ensiklopedia\n- Novel dan Cerpen\n- Majalah dan Koran\n- Buku Digital\n\nTotal koleksi: 2.500+ judul buku",
            'membership_info' => "Keanggotaan terbuka untuk:\n- Semua siswa SMP Negeri 01 Namrole\n- Guru dan staf sekolah\n- Alumni (dengan syarat tertentu)\n\nProsedur pendaftaran:\n1. Mengisi formulir keanggotaan\n2. Menyerahkan fotokopi KTP/KK\n3. Membayar biaya pendaftaran\n4. Mengambil kartu anggota",
            'vision' => 'Menjadi pusat informasi dan literasi yang mendukung terwujudnya budaya membaca dan pembelajaran yang berkualitas di SMP Negeri 01 Namrole.',
            'mission' => 'Menyediakan akses informasi yang mudah, cepat, dan akurat; mengembangkan koleksi yang relevan dengan kebutuhan pembelajaran; serta membina budaya membaca dan literasi digital.',
            'goals' => 'Meningkatkan minat baca siswa, mendukung proses pembelajaran, mengembangkan keterampilan literasi, dan menciptakan lingkungan belajar yang kondusif.',
            'is_active' => true,
        ]);
    }
}