<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolProfile;
use App\Models\Accreditation;
use App\Models\Achievement;
use App\Models\VisionMission;

class ProfilController extends Controller
{
    public function index()
    {
        // Ambil data dari database
        $sections = SchoolProfile::where('is_active', true)
                                ->orderBy('sort_order')
                                ->get()
                                ->keyBy('section_key');
        
        // Ambil data akreditasi dan prestasi dari database
        $accreditation = Accreditation::active()->first();
        $achievements = Achievement::active()->orderBy('year', 'desc')->get();

        // Ambil Visi & Misi aktif untuk gambar
        $activeVisionMission = VisionMission::where('is_active', true)->orderBy('created_at', 'desc')->first();
        $visionImages = [];
        if ($activeVisionMission) {
            if (!empty($activeVisionMission->image_one_url)) { $visionImages[] = $activeVisionMission->image_one_url; }
            if (!empty($activeVisionMission->image_two_url)) { $visionImages[] = $activeVisionMission->image_two_url; }
            if (!empty($activeVisionMission->image_three_url)) { $visionImages[] = $activeVisionMission->image_three_url; }
        }
        
        // Data profil sekolah dari database
        $profilData = [
            'hero_title' => $sections->get('hero')->title ?? 'Profil Sekolah',
            'hero_subtitle' => $sections->get('hero')->subtitle ?? $sections->get('hero')->content ?? 'SMP Negeri 01 Namrole - Sekolah Unggul Berkarakter',
            // gunakan URL relatif dari accessor image_url ketika gambar tersedia, selain itu biarkan null agar fallback gradient bekerja
            'hero_background' => ($sections->get('hero') && $sections->get('hero')->image) ? $sections->get('hero')->image_url : null,
            'sejarah' => [
                'judul' => $sections->get('sejarah')->title ?? 'Sejarah Singkat SMP Negeri 01 Namrole',
                'konten' => $sections->get('sejarah')->content ?? 'SMP Negeri 01 Namrole didirikan pada tahun 1985 sebagai salah satu sekolah menengah pertama negeri di Kabupaten Maluku Tengah. Sekolah ini dibangun dengan tujuan untuk memberikan akses pendidikan yang berkualitas kepada masyarakat di wilayah Namrole dan sekitarnya. Sejak berdiri, sekolah ini telah mengalami berbagai perkembangan dan peningkatan fasilitas untuk mendukung proses pembelajaran yang optimal.',
                'tahun_berdiri' => '1985',
                'lokasi' => 'Namrole, Maluku Tengah'
            ],
            'visi_misi' => [
                'images' => $visionImages,
            ],
            'struktur_organisasi' => [
                // gunakan URL relatif dari accessor image_url ketika gambar tersedia; fallback ke gambar default
                'gambar' => ($sections->get('struktur') && $sections->get('struktur')->image) ? $sections->get('struktur')->image_url : asset('images/default-section.png'),
                'judul' => $sections->get('struktur')->title ?? 'Struktur Organisasi SMP Negeri 01 Namrole',
                'deskripsi' => $sections->get('struktur')->content ?? 'Struktur organisasi sekolah yang menunjukkan hierarki kepemimpinan dan pembagian tugas di SMP Negeri 01 Namrole.'
            ],
            'tenaga_pendidik' => [
                'content' => $sections->get('tenaga-pendidik')->content ?? 'SMP Negeri 01 Namrole memiliki tenaga pendidik yang berkualitas dan berpengalaman. Semua guru telah memenuhi kualifikasi akademik dan memiliki sertifikasi pendidik. Mereka berkomitmen untuk memberikan pendidikan terbaik kepada siswa.',
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
                'content' => $sections->get('akreditasi')->content ?? 'SMP Negeri 01 Namrole telah terakreditasi A dengan skor 95. Akreditasi ini menunjukkan kualitas pendidikan yang tinggi dan komitmen sekolah dalam memberikan pelayanan terbaik kepada siswa dan masyarakat.',
                'status' => $accreditation->status ?? 'Terakreditasi A',
                'nomor_akreditasi' => $accreditation->certificate_number ?? 'BAN-SM-2023-001',
                'tahun_akreditasi' => $accreditation->year ?? '2023',
                'skor' => $accreditation->score ?? '95',
                'masa_berlaku' => $accreditation->valid_until ?? '2023-2028'
            ],
            'prestasi' => [
                'akademik' => $achievements->where('type', 'academic')->map(function($achievement) {
                    return [
                        'prestasi' => $achievement->title,
                        'tahun' => $achievement->year,
                        'level' => $achievement->level_label,
                        'position' => $achievement->position,
                        'participant' => $achievement->participant_name
                    ];
                })->toArray(),
                'non_akademik' => $achievements->where('type', 'non_academic')->map(function($achievement) {
                    return [
                        'prestasi' => $achievement->title,
                        'tahun' => $achievement->year,
                        'level' => $achievement->level_label,
                        'position' => $achievement->position,
                        'participant' => $achievement->participant_name
                    ];
                })->toArray()
            ]
        ];

        return view('profil.index', compact('profilData'));
    }
}
