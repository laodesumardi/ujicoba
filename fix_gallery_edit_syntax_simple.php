<?php
/**
 * Fix Gallery Edit Syntax Errors - Simple Version
 * 
 * This script fixes syntax errors in gallery edit views
 * Specifically fixes broken img tags with onerror attributes
 */

echo "🔧 Fixing Gallery Edit Syntax Errors\n";
echo "====================================\n\n";

echo "🔧 Fixing gallery edit view syntax errors...\n";

// 1. Fix gallery edit view
$editViewPath = 'resources/views/admin/gallery/edit.blade.php';
if (file_exists($editViewPath)) {
    echo "📝 Fixing gallery edit view...\n";
    
    $content = file_get_contents($editViewPath);
    
    // Fix broken img tags with onerror attributes
    $content = preg_replace(
        '/src="{{ \$gallery- onerror="this\.src=\'{{ asset\(\'images\/default-gallery\.png\'\) }}\'">cover_image_url\s*}}"/',
        'src="{{ $gallery->cover_image_url }}"',
        $content
    );
    
    $content = preg_replace(
        '/alt="{{ \$gallery- onerror="this\.src=\'{{ asset\(\'images\/default-gallery\.png\'\) }}\'">title\s*}}"/',
        'alt="{{ $gallery->title }}"',
        $content
    );
    
    // Add proper onerror attribute if not present
    if (strpos($content, 'onerror=') === false) {
        $content = preg_replace(
            '/(<img[^>]*src="{{ \$gallery->cover_image_url }}"[^>]*class="[^"]*"[^>]*>)/',
            '$1 onerror="this.src=\'{{ asset(\'images/default-gallery.png\') }}\'"',
            $content
        );
    }
    
    file_put_contents($editViewPath, $content);
    echo "✅ Gallery edit view syntax fixed\n";
} else {
    echo "⚠️ Gallery edit view not found\n";
}

// 2. Fix gallery create view
$createViewPath = 'resources/views/admin/gallery/create.blade.php';
if (file_exists($createViewPath)) {
    echo "📝 Fixing gallery create view...\n";
    
    $content = file_get_contents($createViewPath);
    
    // Fix any broken img tags
    $content = preg_replace(
        '/src="{{ \$gallery- onerror="this\.src=\'{{ asset\(\'images\/default-gallery\.png\'\) }}\'">cover_image_url\s*}}"/',
        'src="{{ $gallery->cover_image_url }}"',
        $content
    );
    
    $content = preg_replace(
        '/alt="{{ \$gallery- onerror="this\.src=\'{{ asset\(\'images\/default-gallery\.png\'\) }}\'">title\s*}}"/',
        'alt="{{ $gallery->title }}"',
        $content
    );
    
    file_put_contents($createViewPath, $content);
    echo "✅ Gallery create view syntax fixed\n";
} else {
    echo "⚠️ Gallery create view not found\n";
}

// 3. Fix gallery show view
$showViewPath = 'resources/views/admin/gallery/show.blade.php';
if (file_exists($showViewPath)) {
    echo "📝 Fixing gallery show view...\n";
    
    $content = file_get_contents($showViewPath);
    
    // Fix any broken img tags
    $content = preg_replace(
        '/src="{{ \$gallery- onerror="this\.src=\'{{ asset\(\'images\/default-gallery\.png\'\) }}\'">cover_image_url\s*}}"/',
        'src="{{ $gallery->cover_image_url }}"',
        $content
    );
    
    $content = preg_replace(
        '/alt="{{ \$gallery- onerror="this\.src=\'{{ asset\(\'images\/default-gallery\.png\'\) }}\'">title\s*}}"/',
        'alt="{{ $gallery->title }}"',
        $content
    );
    
    file_put_contents($showViewPath, $content);
    echo "✅ Gallery show view syntax fixed\n";
} else {
    echo "⚠️ Gallery show view not found\n";
}

// 4. Fix gallery items edit view
$itemsEditViewPath = 'resources/views/admin/gallery/items/edit.blade.php';
if (file_exists($itemsEditViewPath)) {
    echo "📝 Fixing gallery items edit view...\n";
    
    $content = file_get_contents($itemsEditViewPath);
    
    // Fix any broken img tags
    $content = preg_replace(
        '/src="{{ \$item- onerror="this\.src=\'{{ asset\(\'images\/default-gallery-item\.png\'\) }}\'">image_url\s*}}"/',
        'src="{{ $item->image_url }}"',
        $content
    );
    
    $content = preg_replace(
        '/alt="{{ \$item- onerror="this\.src=\'{{ asset\(\'images\/default-gallery-item\.png\'\) }}\'">title\s*}}"/',
        'alt="{{ $item->title }}"',
        $content
    );
    
    file_put_contents($itemsEditViewPath, $content);
    echo "✅ Gallery items edit view syntax fixed\n";
} else {
    echo "⚠️ Gallery items edit view not found\n";
}

// 5. Fix gallery items create view
$itemsCreateViewPath = 'resources/views/admin/gallery/items/create.blade.php';
if (file_exists($itemsCreateViewPath)) {
    echo "📝 Fixing gallery items create view...\n";
    
    $content = file_get_contents($itemsCreateViewPath);
    
    // Fix any broken img tags
    $content = preg_replace(
        '/src="{{ \$item- onerror="this\.src=\'{{ asset\(\'images\/default-gallery-item\.png\'\) }}\'">image_url\s*}}"/',
        'src="{{ $item->image_url }}"',
        $content
    );
    
    $content = preg_replace(
        '/alt="{{ \$item- onerror="this\.src=\'{{ asset\(\'images\/default-gallery-item\.png\'\) }}\'">title\s*}}"/',
        'alt="{{ $item->title }}"',
        $content
    );
    
    file_put_contents($itemsCreateViewPath, $content);
    echo "✅ Gallery items create view syntax fixed\n";
} else {
    echo "⚠️ Gallery items create view not found\n";
}

// 6. Fix gallery items show view
$itemsShowViewPath = 'resources/views/admin/gallery/items/show.blade.php';
if (file_exists($itemsShowViewPath)) {
    echo "📝 Fixing gallery items show view...\n";
    
    $content = file_get_contents($itemsShowViewPath);
    
    // Fix any broken img tags
    $content = preg_replace(
        '/src="{{ \$item- onerror="this\.src=\'{{ asset\(\'images\/default-gallery-item\.png\'\) }}\'">image_url\s*}}"/',
        'src="{{ $item->image_url }}"',
        $content
    );
    
    $content = preg_replace(
        '/alt="{{ \$item- onerror="this\.src=\'{{ asset\(\'images\/default-gallery-item\.png\'\) }}\'">title\s*}}"/',
        'alt="{{ $item->title }}"',
        $content
    );
    
    file_put_contents($itemsShowViewPath, $content);
    echo "✅ Gallery items show view syntax fixed\n";
} else {
    echo "⚠️ Gallery items show view not found\n";
}

echo "\n✅ Gallery edit syntax errors fixed!\n";
echo "🔧 Key fixes applied:\n";
echo "- Fixed broken img tags with onerror attributes\n";
echo "- Corrected src and alt attributes\n";
echo "- Added proper onerror fallback\n\n";

echo "🌐 Test URLs:\n";
echo "- Gallery Edit: http://localhost:8000/admin/gallery/2/edit\n";
echo "- Gallery Create: http://localhost:8000/admin/gallery/create\n";
echo "- Gallery Index: http://localhost:8000/admin/gallery\n\n";

echo "🔑 Admin Login:\n";
echo "- URL: http://localhost:8000/login\n";
echo "- Email: admin@namrole.sch.id\n";
echo "- Password: admin123\n";
