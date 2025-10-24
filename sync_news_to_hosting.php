<?php
/**
 * Script untuk sinkronisasi data berita ke hosting
 * Jalankan script ini di hosting untuk memastikan data berita tersedia
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\News;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

echo "=== SYNC NEWS TO HOSTING ===\n";

try {
    // Clear all caches first
    echo "Clearing caches...\n";
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    echo "Caches cleared successfully!\n";
    
    // Check current news count
    $totalNews = News::count();
    $publishedNews = News::where('status', 'published')->count();
    
    echo "\nCurrent database status:\n";
    echo "Total news: $totalNews\n";
    echo "Published news: $publishedNews\n";
    
    // If no news, create comprehensive sample data
    if ($totalNews == 0) {
        echo "\nNo news found. Creating comprehensive sample data...\n";
        
        $comprehensiveNews = [
            [
                'title' => 'Selamat Datang di SMP Negeri 01 Namrole',
                'excerpt' => 'SMP Negeri 01 Namrole adalah sekolah menengah pertama yang berkomitmen untuk memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul.',
                'content' => '<p>SMP Negeri 01 Namrole adalah sekolah menengah pertama yang berkomitmen untuk memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul.</p><p>Dengan visi "Menjadi sekolah unggul yang berkarakter, berprestasi, dan berdaya saing global", kami berusaha memberikan pendidikan terbaik untuk masa depan siswa.</p><p>Misi kami adalah menyelenggarakan pendidikan berkualitas, mengembangkan karakter siswa, dan meningkatkan prestasi akademik dan non-akademik.</p>',
                'category' => 'akademik',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => true,
                'is_pinned' => true,
                'published_at' => now(),
                'author_name' => 'Admin SMP Negeri 01 Namrole',
                'author_email' => 'admin@smpnegeri01namrole.sch.id',
                'views' => 0
            ],
            [
                'title' => 'Penerimaan Siswa Baru Tahun Ajaran 2025/2026',
                'excerpt' => 'Informasi lengkap mengenai pendaftaran siswa baru untuk tahun ajaran 2025/2026. Pendaftaran dibuka mulai tanggal 1 Januari 2025.',
                'content' => '<p>Kepada seluruh calon siswa dan orang tua, kami informasikan bahwa pendaftaran siswa baru untuk tahun ajaran 2025/2026 akan dibuka mulai tanggal 1 Januari 2025.</p><p><strong>Persyaratan pendaftaran:</strong></p><ul><li>Fotocopy akta kelahiran</li><li>Fotocopy kartu keluarga</li><li>Pas foto 3x4 sebanyak 4 lembar</li><li>Surat keterangan sehat dari dokter</li></ul><p>Untuk informasi lebih lanjut, silakan hubungi panitia PPDB di nomor 081234567890.</p>',
                'category' => 'akademik',
                'type' => 'announcement',
                'status' => 'published',
                'is_featured' => true,
                'is_pinned' => true,
                'published_at' => now(),
                'author_name' => 'Admin SMP Negeri 01 Namrole',
                'author_email' => 'admin@smpnegeri01namrole.sch.id',
                'views' => 0
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler Semester Genap',
                'excerpt' => 'Daftar kegiatan ekstrakurikuler yang akan dimulai pada semester genap tahun ajaran 2024/2025.',
                'content' => '<p>Berikut adalah daftar kegiatan ekstrakurikuler yang akan dimulai pada semester genap:</p><ul><li>Pramuka - Setiap hari Sabtu</li><li>Paskibra - Setiap hari Jumat</li><li>Basket - Setiap hari Selasa dan Kamis</li><li>Voli - Setiap hari Senin dan Rabu</li><li>Paduan Suara - Setiap hari Jumat</li><li>Teater - Setiap hari Sabtu</li></ul><p>Pendaftaran dibuka mulai tanggal 15 Januari 2025.</p>',
                'category' => 'ekstrakurikuler',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => false,
                'is_pinned' => false,
                'published_at' => now()->subDays(2),
                'author_name' => 'Guru Pembina',
                'author_email' => 'guru@smpnegeri01namrole.sch.id',
                'views' => 0
            ],
            [
                'title' => 'Libur Nasional Bulan Februari 2025',
                'excerpt' => 'Informasi jadwal libur nasional pada bulan Februari 2025 yang akan mempengaruhi kegiatan belajar mengajar.',
                'content' => '<p>Berikut adalah jadwal libur nasional pada bulan Februari 2025:</p><ul><li>17 Februari 2025 - Tahun Baru Imlek</li><li>28 Februari 2025 - Isra Miraj Nabi Muhammad SAW</li></ul><p>Selama hari libur nasional, kegiatan belajar mengajar akan diliburkan. Siswa diharapkan memanfaatkan waktu libur untuk belajar di rumah.</p>',
                'category' => 'libur',
                'type' => 'announcement',
                'status' => 'published',
                'is_featured' => false,
                'is_pinned' => false,
                'published_at' => now()->subDays(5),
                'author_name' => 'Admin SMP Negeri 01 Namrole',
                'author_email' => 'admin@smpnegeri01namrole.sch.id',
                'views' => 0
            ],
            [
                'title' => 'Perubahan Jadwal Ujian Tengah Semester',
                'excerpt' => 'Perubahan jadwal ujian tengah semester genap tahun ajaran 2024/2025 karena adanya kegiatan lain.',
                'content' => '<p>Dengan hormat, kami informasikan bahwa jadwal ujian tengah semester genap tahun ajaran 2024/2025 mengalami perubahan sebagai berikut:</p><p><strong>Jadwal Lama:</strong> 15-20 Maret 2025<br><strong>Jadwal Baru:</strong> 22-27 Maret 2025</p><p>Perubahan jadwal ini dilakukan karena adanya kegiatan lomba tingkat kabupaten yang akan diikuti oleh siswa-siswi SMP Negeri 01 Namrole.</p>',
                'category' => 'jadwal',
                'type' => 'announcement',
                'status' => 'published',
                'is_featured' => false,
                'is_pinned' => true,
                'published_at' => now()->subDays(1),
                'author_name' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                'author_email' => 'wakasek@smpnegeri01namrole.sch.id',
                'views' => 0
            ],
            [
                'title' => 'Kegiatan OSIS Bulan Januari 2025',
                'excerpt' => 'Rangkaian kegiatan OSIS yang akan dilaksanakan pada bulan Januari 2025 untuk meningkatkan kreativitas dan kepemimpinan siswa.',
                'content' => '<p>OSIS SMP Negeri 01 Namrole akan mengadakan berbagai kegiatan pada bulan Januari 2025:</p><ul><li>Rapat OSIS - 5 Januari 2025</li><li>Kegiatan Bakti Sosial - 12 Januari 2025</li><li>Lomba Kreativitas Siswa - 19 Januari 2025</li><li>Pelatihan Kepemimpinan - 26 Januari 2025</li></ul><p>Semua siswa diharapkan berpartisipasi aktif dalam kegiatan-kegiatan tersebut.</p>',
                'category' => 'osis',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => false,
                'is_pinned' => false,
                'published_at' => now()->subDays(3),
                'author_name' => 'Ketua OSIS',
                'author_email' => 'osis@smpnegeri01namrole.sch.id',
                'views' => 0
            ],
            [
                'title' => 'Lomba Matematika Tingkat Kabupaten',
                'excerpt' => 'Siswa SMP Negeri 01 Namrole berhasil meraih juara 1 dalam lomba matematika tingkat kabupaten Buru Selatan.',
                'content' => '<p>Kami bangga mengumumkan bahwa siswa SMP Negeri 01 Namrole berhasil meraih prestasi gemilang dalam lomba matematika tingkat kabupaten Buru Selatan.</p><p><strong>Prestasi yang diraih:</strong></p><ul><li>Juara 1 - Ahmad Fauzi (Kelas 9A)</li><li>Juara 2 - Siti Aminah (Kelas 8B)</li><li>Juara 3 - Muhammad Ali (Kelas 9C)</li></ul><p>Prestasi ini merupakan bukti bahwa kualitas pendidikan di SMP Negeri 01 Namrole terus meningkat. Selamat kepada para pemenang!</p>',
                'category' => 'lomba',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => true,
                'is_pinned' => false,
                'published_at' => now()->subDays(7),
                'author_name' => 'Guru Matematika',
                'author_email' => 'matematika@smpnegeri01namrole.sch.id',
                'views' => 0
            ]
        ];
        
        foreach ($comprehensiveNews as $newsData) {
            $news = News::create($newsData);
            echo "Created: {$news->title}\n";
        }
        
        echo "Comprehensive news data created successfully!\n";
    } else {
        echo "\nNews data already exists. Checking for any issues...\n";
        
        // Check for unpublished news and publish them
        $unpublishedNews = News::where('status', '!=', 'published')->get();
        if ($unpublishedNews->count() > 0) {
            echo "Found {$unpublishedNews->count()} unpublished news. Publishing them...\n";
            foreach ($unpublishedNews as $news) {
                $news->update([
                    'status' => 'published',
                    'published_at' => now()
                ]);
                echo "Published: {$news->title}\n";
            }
        }
        
        // Check for news with null published_at
        $nullPublishedAt = News::where('status', 'published')->whereNull('published_at')->get();
        if ($nullPublishedAt->count() > 0) {
            echo "Found {$nullPublishedAt->count()} published news with null published_at. Fixing...\n";
            foreach ($nullPublishedAt as $news) {
                $news->update(['published_at' => now()]);
                echo "Fixed: {$news->title}\n";
            }
        }
    }
    
    // Final verification
    echo "\n=== FINAL VERIFICATION ===\n";
    $finalTotal = News::count();
    $finalPublished = News::where('status', 'published')->count();
    $finalFeatured = News::where('status', 'published')->where('is_featured', true)->count();
    $finalPinned = News::where('status', 'published')->where('is_pinned', true)->count();
    
    echo "Total news: $finalTotal\n";
    echo "Published news: $finalPublished\n";
    echo "Featured news: $finalFeatured\n";
    echo "Pinned news: $finalPinned\n";
    
    // Test the exact query used in the controller
    $controllerQuery = News::published()->latest('published_at')->get();
    echo "Controller query result: " . $controllerQuery->count() . " news\n";
    
    if ($controllerQuery->count() > 0) {
        echo "Sample news from controller query:\n";
        foreach ($controllerQuery->take(3) as $news) {
            echo "- {$news->title} ({$news->category}) - {$news->published_at}\n";
        }
    }
    
    // Show categories
    echo "\nCategories:\n";
    $categories = News::selectRaw('category, COUNT(*) as count')
        ->where('status', 'published')
        ->groupBy('category')
        ->get();
    foreach ($categories as $cat) {
        echo "- {$cat->category}: {$cat->count} articles\n";
    }
    
    echo "\n=== SYNC COMPLETED ===\n";
    echo "News data should now be available at:\n";
    echo "https://smpnegeri01namrole.sch.id/berita\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== END SYNC NEWS TO HOSTING ===\n";
?>
