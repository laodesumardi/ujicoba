<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        // Data profil sekolah
        $profilData = [
            'sejarah' => [
                'judul' => 'Sejarah Singkat SMP Negeri 01 Namrole',
                'konten' => 'SMP Negeri 01 Namrole didirikan pada tahun 1985 sebagai salah satu sekolah menengah pertama negeri di Kabupaten Maluku Tengah. Sekolah ini dibangun dengan tujuan untuk memberikan akses pendidikan yang berkualitas kepada masyarakat di wilayah Namrole dan sekitarnya. Sejak berdiri, sekolah ini telah mengalami berbagai perkembangan dan peningkatan fasilitas untuk mendukung proses pembelajaran yang optimal.',
                'tahun_berdiri' => '1985',
                'lokasi' => 'Namrole, Maluku Tengah'
            ],
            'visi_misi' => [
                'visi' => 'Menjadi sekolah unggul yang menghasilkan lulusan berkarakter, berprestasi, dan berdaya saing global',
                'misi' => [
                    'Menyelenggarakan pendidikan yang berkualitas dengan mengintegrasikan nilai-nilai karakter',
                    'Mengembangkan potensi siswa melalui pembelajaran yang kreatif dan inovatif',
                    'Membina hubungan yang harmonis antara sekolah, orang tua, dan masyarakat',
                    'Menyediakan fasilitas pembelajaran yang memadai dan modern',
                    'Membentuk siswa yang memiliki kepedulian sosial dan lingkungan'
                ]
            ],
            'struktur_organisasi' => [
                'gambar' => 'Struktur Organisasi.png',
                'judul' => 'Struktur Organisasi SMP Negeri 01 Namrole',
                'deskripsi' => 'Struktur organisasi sekolah yang menunjukkan hierarki kepemimpinan dan pembagian tugas di SMP Negeri 01 Namrole.'
            ],
            'tenaga_pendidik' => [
                'guru_mata_pelajaran' => [
                    ['nama' => 'Dr. Maria Magdalena, M.Pd', 'mata_pelajaran' => 'Matematika', 'pendidikan' => 'S3 Pendidikan Matematika'],
                    ['nama' => 'Ahmad Fauzi, S.Pd', 'mata_pelajaran' => 'Bahasa Indonesia', 'pendidikan' => 'S1 Pendidikan Bahasa Indonesia'],
                    ['nama' => 'Sarah Johnson, S.Pd', 'mata_pelajaran' => 'Bahasa Inggris', 'pendidikan' => 'S1 Pendidikan Bahasa Inggris'],
                    ['nama' => 'Prof. Dr. Budi Hartono, M.Pd', 'mata_pelajaran' => 'IPA', 'pendidikan' => 'S3 Pendidikan IPA'],
                    ['nama' => 'Siti Aminah, S.Pd', 'mata_pelajaran' => 'IPS', 'pendidikan' => 'S1 Pendidikan IPS'],
                    ['nama' => 'Muhammad Ali, S.Pd', 'mata_pelajaran' => 'Pendidikan Agama Islam', 'pendidikan' => 'S1 Pendidikan Agama Islam'],
                    ['nama' => 'Eka Sari, S.Pd', 'mata_pelajaran' => 'Seni Budaya', 'pendidikan' => 'S1 Pendidikan Seni'],
                    ['nama' => 'Rudi Hartono, S.Pd', 'mata_pelajaran' => 'PJOK', 'pendidikan' => 'S1 Pendidikan Olahraga']
                ],
                'tenaga_kependidikan' => [
                    ['nama' => 'Sari Indah, S.Pd', 'jabatan' => 'Tata Usaha', 'pendidikan' => 'S1 Administrasi Pendidikan'],
                    ['nama' => 'Bambang Sutrisno', 'jabatan' => 'Petugas Kebersihan', 'pendidikan' => 'SMA'],
                    ['nama' => 'Dewi Kartika, S.Pd', 'jabatan' => 'Pustakawan', 'pendidikan' => 'S1 Ilmu Perpustakaan'],
                    ['nama' => 'Ahmad Rifai', 'jabatan' => 'Satpam', 'pendidikan' => 'SMA']
                ]
            ],
            'akreditasi' => [
                'status' => 'Terakreditasi A',
                'nomor_akreditasi' => 'BAN-SM-2023-001',
                'tahun_akreditasi' => '2023',
                'skor' => '95',
                'masa_berlaku' => '2023-2028'
            ],
            'prestasi' => [
                'akademik' => [
                    ['prestasi' => 'Juara 1 Olimpiade Matematika Tingkat Kabupaten', 'tahun' => '2023'],
                    ['prestasi' => 'Juara 2 Lomba Cerdas Cermat Tingkat Provinsi', 'tahun' => '2023'],
                    ['prestasi' => 'Juara 1 Olimpiade IPA Tingkat Kabupaten', 'tahun' => '2022'],
                    ['prestasi' => 'Juara 3 Lomba Debat Bahasa Inggris Tingkat Provinsi', 'tahun' => '2022']
                ],
                'non_akademik' => [
                    ['prestasi' => 'Juara 1 Lomba Pidato Tingkat Kabupaten', 'tahun' => '2023'],
                    ['prestasi' => 'Juara 2 Lomba Tari Tradisional Tingkat Provinsi', 'tahun' => '2023'],
                    ['prestasi' => 'Juara 1 Lomba Paduan Suara Tingkat Kabupaten', 'tahun' => '2022'],
                    ['prestasi' => 'Juara 3 Lomba Futsal Tingkat Kabupaten', 'tahun' => '2022']
                ]
            ]
        ];

        return view('profil.index', compact('profilData'));
    }
}
