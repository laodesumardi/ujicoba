<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Penawaran Harga - Website SMP Negeri 01 Namrole</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            background: white;
            padding: 15mm;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #1e40af;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 22px;
            color: #1e40af;
            margin-bottom: 8px;
        }
        
        .header h2 {
            font-size: 16px;
            color: #374151;
            font-weight: normal;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-row {
            margin-bottom: 6px;
        }
        
        .info-label {
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }
        
        .info-value {
            display: inline-block;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }
        
        table th {
            background: #1e40af;
            color: white !important;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #1e3a8a;
        }
        
        table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
        }
        
        table tr:nth-child(even) {
            background: #f9fafb;
        }
        
        .text-right {
            text-align: right;
        }
        
        .subtotal {
            background: #eff6ff;
            font-weight: bold;
        }
        
        .total-section {
            margin-top: 20px;
            border-top: 2px solid #1e40af;
            padding-top: 15px;
        }
        
        .total-table {
            width: 100%;
            margin-top: 10px;
        }
        
        .total-table td {
            padding: 8px;
            font-size: 11px;
        }
        
        .total-table .label {
            font-weight: bold;
            width: 70%;
        }
        
        .total-table .amount {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            color: #1e40af;
        }
        
        .payment-terms {
            margin-top: 20px;
            background: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #1e40af;
            page-break-inside: avoid;
        }
        
        .payment-terms h3 {
            color: #1e40af;
            margin-bottom: 10px;
            font-size: 12px;
        }
        
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        
        .signature-box {
            width: 45%;
            display: inline-block;
            text-align: center;
            vertical-align: top;
        }
        
        .signature-box .title {
            margin-top: 50px;
            padding-top: 60px;
            border-top: 2px solid #333;
            font-weight: bold;
            margin-bottom: 8px;
        }
        
        .signature-box .name {
            margin-top: 5px;
            font-weight: bold;
        }
        
        .signature-box .position {
            margin-top: 3px;
            font-size: 10px;
            color: #666;
        }
        
        .signature-box .qr-code {
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .signature-box .qr-code img {
            max-width: 120px;
            max-height: 120px;
            width: 120px;
            height: 120px;
        }
        
        .category-header {
            background: #1e40af;
            color: white !important;
            padding: 8px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 8px;
            border-radius: 3px;
        }
        
        .bonus-section {
            background: #ecfdf5;
            border: 2px solid #10b981;
            padding: 12px;
            border-radius: 5px;
            margin-top: 15px;
            page-break-inside: avoid;
        }
        
        .bonus-section h3 {
            color: #059669;
            margin-bottom: 8px;
            font-size: 11px;
        }
        
        .bonus-section ul {
            margin-left: 20px;
            margin-top: 5px;
        }
        
        .bonus-section li {
            margin-bottom: 3px;
            font-size: 10px;
        }
        
        h3 {
            color: #1e40af;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 13px;
        }
        
        @page {
            margin: 15mm;
            size: A4;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>NOTA PENAWARAN HARGA</h1>
        <h2>WEBSITE SMP NEGERI 01 NAMROLE</h2>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Kepada Yth:</span>
            <span class="info-value">{{ $kepada ?? 'Kepala Sekolah SMP Negeri 01 Namrole' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Dari:</span>
            <span class="info-value">{{ $dari ?? 'Tim Pengembang Website' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal:</span>
            <span class="info-value">{{ $tanggal }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">No. Penawaran:</span>
            <span class="info-value">{{ $no_penawaran }}</span>
        </div>
    </div>

    <!-- Rincian Harga -->
    <h3>RINCIAN HARGA PENGEMBANGAN WEBSITE</h3>

    <!-- Kategori 1 -->
    <div class="category-header">1. HALAMAN PUBLIK & INFORMASI SEKOLAH</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Fitur</th>
                <th style="width: 50%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1.1</td>
                <td>Beranda dengan Sections Dinamis</td>
                <td>Halaman utama dengan multiple sections yang dapat dikelola admin</td>
                <td class="text-right">200.000</td>
            </tr>
            <tr>
                <td>1.2</td>
                <td>Profil Sekolah</td>
                <td>Halaman profil dengan tab: Sejarah, Visi & Misi, Struktur Organisasi, Akreditasi & Prestasi</td>
                <td class="text-right">230.000</td>
            </tr>
            <tr>
                <td>1.3</td>
                <td>Sambutan Kepala Sekolah</td>
                <td>Halaman sambutan dengan konten dinamis</td>
                <td class="text-right">90.000</td>
            </tr>
            <tr>
                <td>1.4</td>
                <td>Kalender Akademik</td>
                <td>Sistem kalender dengan event management, filter, dan download</td>
                <td class="text-right">220.000</td>
            </tr>
            <tr>
                <td>1.5</td>
                <td>Berita & Pengumuman</td>
                <td>Sistem CMS berita dengan kategori, featured, pinned, dan SEO</td>
                <td class="text-right">260.000</td>
            </tr>
            <tr>
                <td>1.6</td>
                <td>Prestasi Sekolah</td>
                <td>Halaman prestasi dengan kategori dan filter</td>
                <td class="text-right">120.000</td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Kategori 1:</strong></td>
                <td class="text-right"><strong>1.120.000</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Kategori 2 -->
    <div class="category-header">2. MEDIA & KONTEN</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Fitur</th>
                <th style="width: 50%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2.1</td>
                <td>Galeri Foto</td>
                <td>Gallery dengan kategori, featured, lightbox, dan manajemen foto</td>
                <td class="text-right">250.000</td>
            </tr>
            <tr>
                <td>2.2</td>
                <td>Download Center</td>
                <td>Sistem dokumen dengan kategori, tipe file, featured, dan download counter</td>
                <td class="text-right">240.000</td>
            </tr>
            <tr>
                <td>2.3</td>
                <td>Perpustakaan Digital</td>
                <td>Sistem perpustakaan dengan katalog buku dan manajemen koleksi</td>
                <td class="text-right">210.000</td>
            </tr>
            <tr>
                <td>2.4</td>
                <td>Tenaga Pendidik</td>
                <td>Halaman profil guru dengan foto, informasi lengkap, dan status aktif</td>
                <td class="text-right">200.000</td>
            </tr>
            <tr>
                <td>2.5</td>
                <td>Fasilitas Sekolah</td>
                <td>Halaman fasilitas dengan detail, gambar, dan kategori</td>
                <td class="text-right">170.000</td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Kategori 2:</strong></td>
                <td class="text-right"><strong>1.070.000</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Kategori 3 -->
    <div class="category-header">3. PPDB (PENERIMAAN PESERTA DIDIK BARU)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Fitur</th>
                <th style="width: 50%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>3.1</td>
                <td>Form Pendaftaran Online</td>
                <td>Form pendaftaran lengkap dengan validasi dan upload dokumen</td>
                <td class="text-right">330.000</td>
            </tr>
            <tr>
                <td>3.2</td>
                <td>Cek Status Pendaftaran</td>
                <td>Sistem tracking status pendaftaran untuk calon siswa</td>
                <td class="text-right">120.000</td>
            </tr>
            <tr>
                <td>3.3</td>
                <td>Dashboard Panitia PPDB</td>
                <td>Dashboard khusus panitia untuk manage pendaftaran</td>
                <td class="text-right">290.000</td>
            </tr>
            <tr>
                <td>3.4</td>
                <td>Approve/Reject Pendaftaran</td>
                <td>Sistem approval dengan notifikasi dan email</td>
                <td class="text-right">250.000</td>
            </tr>
            <tr>
                <td>3.5</td>
                <td>Export Data & Download Form</td>
                <td>Export Excel dan download form pendaftaran</td>
                <td class="text-right">180.000</td>
            </tr>
            <tr>
                <td>3.6</td>
                <td>Create Account Manual</td>
                <td>Fitur create account siswa dari pendaftaran</td>
                <td class="text-right">110.000</td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Kategori 3:</strong></td>
                <td class="text-right"><strong>1.280.000</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Kategori 4 -->
    <div class="category-header">4. E-LEARNING / LEARNING MANAGEMENT SYSTEM (LMS)</div>
    
    <strong style="display: block; margin-top: 8px; margin-bottom: 8px; font-size: 11px;">A. Modul Untuk Siswa</strong>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Fitur</th>
                <th style="width: 50%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>4.1</td>
                <td>Dashboard Siswa</td>
                <td>Dashboard dengan statistik, tugas terbaru, dan ringkasan</td>
                <td class="text-right">230.000</td>
            </tr>
            <tr>
                <td>4.2</td>
                <td>Profile Management Siswa</td>
                <td>Edit profil, upload foto, update data pribadi</td>
                <td class="text-right">70.000</td>
            </tr>
            <tr>
                <td>4.3</td>
                <td>Manajemen Kursus</td>
                <td>Lihat kursus, enroll, dan dashboard kursus</td>
                <td class="text-right">240.000</td>
            </tr>
            <tr>
                <td>4.4</td>
                <td>Sistem Lesson/Materi</td>
                <td>Akses materi pembelajaran dengan progress tracking</td>
                <td class="text-right">270.000</td>
            </tr>
            <tr>
                <td>4.5</td>
                <td>Sistem Assignment/Tugas</td>
                <td>Submit tugas, upload file, dan tracking status</td>
                <td class="text-right">300.000</td>
            </tr>
            <tr>
                <td>4.6</td>
                <td>Forum Diskusi</td>
                <td>Forum per kursus dan forum umum dengan reply</td>
                <td class="text-right">250.000</td>
            </tr>
            <tr>
                <td>4.7</td>
                <td>Sistem Nilai/Grades</td>
                <td>Lihat nilai tugas dan raport nilai</td>
                <td class="text-right">170.000</td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Modul Siswa:</strong></td>
                <td class="text-right"><strong>1.530.000</strong></td>
            </tr>
        </tbody>
    </table>

    <strong style="display: block; margin-top: 10px; margin-bottom: 8px; font-size: 11px;">B. Modul Untuk Guru</strong>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Fitur</th>
                <th style="width: 50%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>4.8</td>
                <td>Dashboard Guru</td>
                <td>Dashboard dengan statistik dan aktivitas mengajar</td>
                <td class="text-right">230.000</td>
            </tr>
            <tr>
                <td>4.9</td>
                <td>Profile Management Guru</td>
                <td>Edit profil guru dengan data lengkap</td>
                <td class="text-right">70.000</td>
            </tr>
            <tr>
                <td>4.10</td>
                <td>Manajemen Kursus</td>
                <td>Create, edit, archive, dan toggle status kursus</td>
                <td class="text-right">330.000</td>
            </tr>
            <tr>
                <td>4.11</td>
                <td>Manajemen Lesson</td>
                <td>Create lesson, upload attachment, reorder, publish</td>
                <td class="text-right">310.000</td>
            </tr>
            <tr>
                <td>4.12</td>
                <td>Manajemen Assignment</td>
                <td>Create assignment, grading, download submissions</td>
                <td class="text-right">360.000</td>
            </tr>
            <tr>
                <td>4.13</td>
                <td>Forum Management</td>
                <td>Create forum, pin, lock, dan hapus reply</td>
                <td class="text-right">250.000</td>
            </tr>
            <tr>
                <td>4.14</td>
                <td>Assignment Overview</td>
                <td>Dashboard khusus untuk melihat semua tugas</td>
                <td class="text-right">110.000</td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Modul Guru:</strong></td>
                <td class="text-right"><strong>1.660.000</strong></td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Kategori 4 (LMS):</strong></td>
                <td class="text-right"><strong>3.190.000</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Kategori 5 -->
    <div class="category-header">5. ADMIN DASHBOARD & MANAJEMEN KONTEN</div>
    
    <strong style="display: block; margin-top: 8px; margin-bottom: 8px; font-size: 11px;">A. Manajemen Konten Website</strong>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Fitur</th>
                <th style="width: 50%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>5.1</td>
                <td>Home Section Management</td>
                <td>Kelola semua section di halaman beranda</td>
                <td class="text-right">190.000</td>
            </tr>
            <tr>
                <td>5.2</td>
                <td>School Profile Management</td>
                <td>Kelola profil sekolah (hero, struktur, dll)</td>
                <td class="text-right">230.000</td>
            </tr>
            <tr>
                <td>5.3</td>
                <td>News Management</td>
                <td>CMS berita dengan full features</td>
                <td class="text-right">250.000</td>
            </tr>
            <tr>
                <td>5.4</td>
                <td>Academic Calendar Management</td>
                <td>Admin panel untuk kalender akademik</td>
                <td class="text-right">220.000</td>
            </tr>
            <tr>
                <td>5.5</td>
                <td>Gallery Management</td>
                <td>Admin panel untuk galeri foto</td>
                <td class="text-right">230.000</td>
            </tr>
            <tr>
                <td>5.6</td>
                <td>Document Management</td>
                <td>Admin panel untuk download center</td>
                <td class="text-right">220.000</td>
            </tr>
            <tr>
                <td>5.7</td>
                <td>Achievement Management</td>
                <td>Kelola prestasi sekolah</td>
                <td class="text-right">170.000</td>
            </tr>
            <tr>
                <td>5.8</td>
                <td>Accreditation Management</td>
                <td>Kelola data akreditasi</td>
                <td class="text-right">145.000</td>
            </tr>
            <tr>
                <td>5.9</td>
                <td>Facilities Management</td>
                <td>Kelola fasilitas sekolah</td>
                <td class="text-right">170.000</td>
            </tr>
            <tr>
                <td>5.10</td>
                <td>Library Management</td>
                <td>Kelola koleksi perpustakaan</td>
                <td class="text-right">220.000</td>
            </tr>
            <tr>
                <td>5.11</td>
                <td>Vision & Mission Management</td>
                <td>Kelola visi & misi dengan gambar</td>
                <td class="text-right">120.000</td>
            </tr>
            <tr>
                <td>5.12</td>
                <td>Headmaster Greeting Management</td>
                <td>Kelola sambutan kepala sekolah</td>
                <td class="text-right">110.000</td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Manajemen Konten:</strong></td>
                <td class="text-right"><strong>2.285.000</strong></td>
            </tr>
        </tbody>
    </table>

    <strong style="display: block; margin-top: 10px; margin-bottom: 8px; font-size: 11px;">B. Manajemen Pengguna & Sistem</strong>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Fitur</th>
                <th style="width: 50%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>5.13</td>
                <td>Teacher Management</td>
                <td>CRUD guru, transfer courses, toggle active</td>
                <td class="text-right">270.000</td>
            </tr>
            <tr>
                <td>5.14</td>
                <td>Subject Management</td>
                <td>Kelola mata pelajaran</td>
                <td class="text-right">170.000</td>
            </tr>
            <tr>
                <td>5.15</td>
                <td>User Management</td>
                <td>Manajemen semua user dengan role</td>
                <td class="text-right">300.000</td>
            </tr>
            <tr>
                <td>5.16</td>
                <td>PPDB Management</td>
                <td>Admin panel untuk manage pendaftaran PPDB</td>
                <td class="text-right">310.000</td>
            </tr>
            <tr>
                <td>5.17</td>
                <td>Contact Management</td>
                <td>Kelola informasi kontak sekolah</td>
                <td class="text-right">90.000</td>
            </tr>
            <tr>
                <td>5.18</td>
                <td>Social Media Management</td>
                <td>Kelola link media sosial</td>
                <td class="text-right">60.000</td>
            </tr>
            <tr>
                <td>5.19</td>
                <td>Message Management</td>
                <td>Sistem pesan masuk dengan reply</td>
                <td class="text-right">230.000</td>
            </tr>
            <tr>
                <td>5.20</td>
                <td>Notification System</td>
                <td>Sistem notifikasi real-time</td>
                <td class="text-right">250.000</td>
            </tr>
            <tr>
                <td>5.21</td>
                <td>Dashboard Admin</td>
                <td>Dashboard dengan statistik lengkap</td>
                <td class="text-right">300.000</td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Manajemen Sistem:</strong></td>
                <td class="text-right"><strong>2.080.000</strong></td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Kategori 5:</strong></td>
                <td class="text-right"><strong>4.365.000</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Kategori 6 -->
    <div class="category-header">6. FITUR INTEGRASI & TAMBAHAN</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Fitur</th>
                <th style="width: 50%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>6.1</td>
                <td>Integrasi Link Eksternal</td>
                <td>Integrasi Asesmen, CBT Sekolah, Sarana Guru, E-Library</td>
                <td class="text-right">90.000</td>
            </tr>
            <tr>
                <td>6.2</td>
                <td>Contact Form</td>
                <td>Form kontak dengan validasi dan email notification</td>
                <td class="text-right">110.000</td>
            </tr>
            <tr>
                <td>6.3</td>
                <td>Image Management System</td>
                <td>Upload, manage, dan optimize gambar</td>
                <td class="text-right">170.000</td>
            </tr>
            <tr>
                <td>6.4</td>
                <td>Responsive Design</td>
                <td>Mobile-friendly untuk semua device</td>
                <td class="text-right">240.000</td>
            </tr>
            <tr>
                <td>6.5</td>
                <td>SEO Optimization</td>
                <td>Meta tags, sitemap, dan struktur SEO</td>
                <td class="text-right">220.000</td>
            </tr>
            <tr>
                <td>6.6</td>
                <td>Legal Pages</td>
                <td>Kebijakan privasi, syarat ketentuan, sitemap</td>
                <td class="text-right">70.000</td>
            </tr>
            <tr>
                <td>6.7</td>
                <td>Authentication System</td>
                <td>Universal login dengan role-based access</td>
                <td class="text-right">270.000</td>
            </tr>
            <tr>
                <td>6.8</td>
                <td>Security Features</td>
                <td>Keamanan website dan data protection</td>
                <td class="text-right">300.000</td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Kategori 6:</strong></td>
                <td class="text-right"><strong>1.470.000</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Kategori 7 -->
    <div class="category-header">7. FITUR TEKNIS & SUPPORT</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Fitur</th>
                <th style="width: 50%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>7.1</td>
                <td>Database Design & Setup</td>
                <td>Design database yang optimal dan secure</td>
                <td class="text-right">240.000</td>
            </tr>
            <tr>
                <td>7.2</td>
                <td>Backend API Development</td>
                <td>RESTful API untuk semua fitur</td>
                <td class="text-right">330.000</td>
            </tr>
            <tr>
                <td>7.3</td>
                <td>Frontend Development</td>
                <td>UI/UX development dengan modern framework</td>
                <td class="text-right">360.000</td>
            </tr>
            <tr>
                <td>7.4</td>
                <td>Testing & Quality Assurance</td>
                <td>Testing semua fitur dan bug fixing</td>
                <td class="text-right">270.000</td>
            </tr>
            <tr>
                <td>7.5</td>
                <td>Deployment & Setup Server</td>
                <td>Setup server, domain, dan deployment</td>
                <td class="text-right">180.000</td>
            </tr>
            <tr>
                <td>7.6</td>
                <td>Training & Dokumentasi</td>
                <td>Training admin dan dokumentasi lengkap</td>
                <td class="text-right">230.000</td>
            </tr>
            <tr>
                <td>7.7</td>
                <td>Maintenance 1 Tahun</td>
                <td>Support dan maintenance selama 1 tahun</td>
                <td class="text-right">480.000</td>
            </tr>
            <tr>
                <td>7.8</td>
                <td>Backup System</td>
                <td>Sistem backup otomatis harian</td>
                <td class="text-right">120.000</td>
            </tr>
            <tr class="subtotal">
                <td colspan="3" class="text-right"><strong>Subtotal Kategori 7:</strong></td>
                <td class="text-right"><strong>2.210.000</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Total Section -->
    <div class="total-section">
        <h3>RINGKASAN TOTAL HARGA</h3>
        <table class="total-table">
            <tr>
                <td class="label">1. Halaman Publik & Informasi Sekolah</td>
                <td class="amount">1.120.000</td>
            </tr>
            <tr>
                <td class="label">2. Media & Konten</td>
                <td class="amount">1.070.000</td>
            </tr>
            <tr>
                <td class="label">3. PPDB</td>
                <td class="amount">1.280.000</td>
            </tr>
            <tr>
                <td class="label">4. E-Learning / LMS</td>
                <td class="amount">3.190.000</td>
            </tr>
            <tr>
                <td class="label">5. Admin Dashboard & Manajemen</td>
                <td class="amount">4.365.000</td>
            </tr>
            <tr>
                <td class="label">6. Integrasi & Tambahan</td>
                <td class="amount">1.470.000</td>
            </tr>
            <tr>
                <td class="label">7. Teknis & Support</td>
                <td class="amount">2.210.000</td>
            </tr>
            <tr style="background: #1e40af; color: white; font-size: 14px;">
                <td class="label" style="color: white;"><strong>TOTAL HARGA</strong></td>
                <td class="amount" style="color: white;"><strong>9.000.000</strong></td>
            </tr>
        </table>
    </div>

    <!-- Payment Terms -->
    <div class="payment-terms">
        <h3>KETENTUAN PEMBAYARAN</h3>
        <p><strong>Total: Rp 9.000.000</strong></p>
        <table style="margin-top: 10px;">
            <thead>
                <tr>
                    <th style="width: 30%;">Pembayaran</th>
                    <th style="width: 25%;" class="text-right">Jumlah</th>
                    <th style="width: 15%;" class="text-right">Persentase</th>
                    <th style="width: 30%;">Kondisi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Down Payment</strong></td>
                    <td class="text-right"><strong>Rp 3.600.000</strong></td>
                    <td class="text-right">40%</td>
                    <td>Saat kontrak ditandatangani</td>
                </tr>
                <tr>
                    <td><strong>Progress Payment 1</strong></td>
                    <td class="text-right"><strong>Rp 2.700.000</strong></td>
                    <td class="text-right">30%</td>
                    <td>Saat development 50% selesai</td>
                </tr>
                <tr>
                    <td><strong>Progress Payment 2</strong></td>
                    <td class="text-right"><strong>Rp 1.800.000</strong></td>
                    <td class="text-right">20%</td>
                    <td>Saat development 80% selesai</td>
                </tr>
                <tr>
                    <td><strong>Final Payment</strong></td>
                    <td class="text-right"><strong>Rp 900.000</strong></td>
                    <td class="text-right">10%</td>
                    <td>Saat go live & testing selesai</td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top: 10px;"><strong>Waktu Pengerjaan:</strong> 2-4 minggu dari down payment</p>
    </div>

    <!-- Bonus Section -->
    <div class="bonus-section">
        <h3>BONUS & FREEBIES</h3>
        <ul>
            <li>✅ <strong>Gratis Setup Domain (.sch.id)</strong></li>
            <li>✅ <strong>Gratis Setup Hosting 1 tahun pertama</strong></li>
            <li>✅ <strong>Gratis Training Admin 2x pertemuan</strong></li>
            <li>✅ <strong>Gratis Maintenance & Support 1 tahun</strong></li>
            <li>✅ <strong>Gratis Backup System Harian</strong></li>
            <li>✅ <strong>Gratis SSL Certificate</strong></li>
            <li>✅ <strong>Gratis Email Corporate</strong></li>
        </ul>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="title">Penerima</div>
            <div class="name">________________________</div>
            <div class="position">Kepala Sekolah SMP Negeri 01 Namrole</div>
        </div>
        
        <div class="signature-box">
            <div class="title">Penyedia</div>
            @if(!empty($qr_code))
            <div class="qr-code" style="text-align: center; margin: 10px 0;">
                <img src="{{ $qr_code }}" alt="QR Code" width="120" height="120" style="display: inline-block;" />
            </div>
            @endif
            <div class="name">________________________</div>
            <div class="position">Tim Pengembang Website</div>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 9px; color: #666; text-align: center;">
        <p><strong>Contact:</strong> 📧 Email: info@developer.com | 📱 WhatsApp: 0812-3456-7890</p>
        <p style="margin-top: 8px;"><em>Hormat Kami, Tim Pengembang Website</em></p>
        <p style="margin-top: 10px; color: #999; font-size: 8px;">
            Note: Harga sudah final (termasuk semua fitur). Harga tetap selama masa kontrak. 
            Penawaran ini berlaku selama 30 hari. Semua harga dalam Rupiah (IDR).
        </p>
    </div>
</body>
</html>

