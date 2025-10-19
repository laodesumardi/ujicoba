<?php

namespace Database\Seeders;

use App\Models\Library;
use Illuminate\Database\Seeder;

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
            'phone' => '(0381) 123456',
            'email' => 'perpustakaan@smpn01namrole.sch.id',
            'opening_hours' => "Senin - Jumat: 07:00 - 15:00\nSabtu: 08:00 - 12:00\nMinggu: Tutup",
            'services' => "• Peminjaman buku\n• Baca di tempat\n• Akses internet\n• Fotokopi\n• Konsultasi literasi\n• Program literasi sekolah",
            'rules' => "1. Dilarang makan dan minum di dalam perpustakaan\n2. Harus menjaga ketenangan\n3. Buku yang dipinjam harus dikembalikan tepat waktu\n4. Dilarang merusak atau mencoret-coret buku\n5. Wajib menjaga kebersihan perpustakaan",
            'librarian_name' => 'Siti Aminah, S.Pd',
            'librarian_phone' => '081234567890',
            'librarian_email' => 'siti.aminah@smpn01namrole.sch.id',
            'facilities' => "• Ruang baca dengan kapasitas 50 orang\n• 10 unit komputer untuk akses digital\n• Ruang diskusi kelompok\n• Area koleksi referensi\n• Ruang multimedia",
            'collection_info' => "• Total koleksi: 5.000+ buku\n• Buku pelajaran: 2.500 eksemplar\n• Buku referensi: 1.000 eksemplar\n• Buku fiksi: 1.000 eksemplar\n• Majalah dan koran: 500 eksemplar\n• Koleksi digital: 500 judul",
            'membership_info' => "• Gratis untuk semua siswa dan guru SMP Negeri 01 Namrole\n• Pendaftaran keanggotaan dilakukan di perpustakaan\n• Membawa kartu pelajar/guru untuk pendaftaran\n• Masa berlaku keanggotaan: 1 tahun akademik",
            'is_active' => true,
        ]);
    }
}


