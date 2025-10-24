<?php
/**
 * Script untuk test akses gambar di hosting
 * Script ini akan test apakah gambar bisa diakses langsung dari public/storage
 */

echo "=== TEST HOSTING IMAGES ===\n";
echo "Script untuk test akses gambar di hosting\n\n";

// Base URL hosting
$baseUrl = 'https://smpnegeri01namrole.sch.id';

// Test URLs
$testUrls = [
    'Home Sections' => '/storage/home-sections/',
    'News' => '/storage/news/',
    'Facilities' => '/storage/facilities/',
    'Galleries' => '/storage/galleries/',
    'Headmaster Greetings' => '/storage/headmaster-greetings/',
    'School Profiles' => '/storage/school-profiles/',
    'Students Photos' => '/storage/students/photos/',
    'Teachers' => '/storage/teachers/'
];

echo "🔗 Testing image access URLs:\n\n";

foreach ($testUrls as $name => $path) {
    $fullUrl = $baseUrl . $path;
    echo "📁 $name:\n";
    echo "   URL: $fullUrl\n";
    
    // Test dengan curl jika tersedia
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            echo "   ✅ Status: OK ($httpCode)\n";
        } elseif ($httpCode == 403) {
            echo "   ❌ Status: Forbidden ($httpCode) - Permission issue\n";
        } elseif ($httpCode == 404) {
            echo "   ❌ Status: Not Found ($httpCode) - Folder tidak ada\n";
        } else {
            echo "   ⚠️  Status: $httpCode\n";
        }
    } else {
        echo "   ⚠️  cURL tidak tersedia, tidak bisa test HTTP\n";
    }
    
    echo "\n";
}

// Test file spesifik
echo "🖼️  Testing specific image files:\n\n";

$testFiles = [
    'Home Sections' => [
        '1760823551_Screenshot_2025-10-17_153943.png',
        '1760829606_academic_calendar.jpeg',
        '1760829884_news_section.jpeg'
    ],
    'News' => [
        '1760827300_penerimaan-peserta-didik-baru-tahun-ajaran-20242025.png',
        '1760856276_argawgwar.png',
        '1760856848_abarba-ajgargiahg.jpeg'
    ],
    'Facilities' => [
        '1760828853_68f41db57d244.png',
        '1760828921_68f41df97e5a5.png',
        '1760829011_68f41e533b7cd.png'
    ],
    'Galleries' => [
        '1760827717_kegiatan-upacara-bendera.jpeg',
        '1760854196_agagaw.jpeg',
        '1760855002_kegiatan-siswa-smp-negeri-01-namrole.png'
    ]
];

foreach ($testFiles as $category => $files) {
    echo "📁 $category:\n";
    foreach ($files as $file) {
        $url = $baseUrl . '/storage/' . strtolower(str_replace(' ', '-', $category)) . '/' . $file;
        echo "   🖼️  $file:\n";
        echo "      URL: $url\n";
        
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode == 200) {
                echo "      ✅ Status: OK ($httpCode)\n";
            } elseif ($httpCode == 403) {
                echo "      ❌ Status: Forbidden ($httpCode) - Permission issue\n";
            } elseif ($httpCode == 404) {
                echo "      ❌ Status: Not Found ($httpCode) - File tidak ada\n";
            } else {
                echo "      ⚠️  Status: $httpCode\n";
            }
        } else {
            echo "      ⚠️  cURL tidak tersedia\n";
        }
        echo "\n";
    }
}

// Test local file existence
echo "📂 Testing local file existence:\n\n";

$localPaths = [
    'public/storage' => __DIR__ . '/public/storage',
    'storage/app/public' => __DIR__ . '/storage/app/public'
];

foreach ($localPaths as $name => $path) {
    echo "📁 $name: $path\n";
    if (is_dir($path)) {
        echo "   ✅ Directory exists\n";
        
        // Count files
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        $fileCount = iterator_count($files);
        echo "   📊 Files count: $fileCount\n";
        
        // Check permissions
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        echo "   🔐 Permissions: $perms\n";
        
        if ($perms != '0755' && $perms != '755') {
            echo "   ⚠️  Warning: Permissions should be 755\n";
        }
    } else {
        echo "   ❌ Directory tidak ada\n";
    }
    echo "\n";
}

echo "✅ Test selesai!\n";
echo "📝 Catatan:\n";
echo "- Jika status 403: Permission issue, jalankan: chmod -R 755 public/storage\n";
echo "- Jika status 404: File tidak ada, jalankan: php hosting_image_fix.php\n";
echo "- Jika status 200: Gambar sudah bisa diakses\n";
?>
