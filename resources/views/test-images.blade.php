<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Images - SMP Negeri 01 Namrole</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; }
        .image-test { margin: 10px 0; }
        img { max-width: 300px; height: auto; border: 1px solid #ccc; }
        .url-display { background: #f5f5f5; padding: 10px; margin: 5px 0; font-family: monospace; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Test Images Access</h1>
    
    <div class="test-section">
        <h2>1. Test dengan asset() helper</h2>
        <div class="image-test">
            <h3>Logo (sudah ada):</h3>
            <div class="url-display">URL: {{ asset('logo.png') }}</div>
            <img src="{{ asset('logo.png') }}" alt="Logo" onerror="this.style.border='2px solid red'; this.alt='ERROR: Image not found';">
        </div>
        
        <div class="image-test">
            <h3>Default Teacher (sudah ada):</h3>
            <div class="url-display">URL: {{ asset('images/default-teacher.png') }}</div>
            <img src="{{ asset('images/default-teacher.png') }}" alt="Default Teacher" onerror="this.style.border='2px solid red'; this.alt='ERROR: Image not found';">
        </div>
        
        <div class="image-test">
            <h3>Test Image (baru dibuat):</h3>
            <div class="url-display">URL: {{ asset('images/test-image.jpg') }}</div>
            <img src="{{ asset('images/test-image.jpg') }}" alt="Test Image" onerror="this.style.border='2px solid red'; this.alt='ERROR: Image not found';">
        </div>
    </div>

    <div class="test-section">
        <h2>2. Test dengan URL langsung</h2>
        <div class="image-test">
            <h3>Logo dengan URL langsung:</h3>
            <div class="url-display">URL: {{ url('logo.png') }}</div>
            <img src="{{ url('logo.png') }}" alt="Logo Direct" onerror="this.style.border='2px solid red'; this.alt='ERROR: Image not found';">
        </div>
        
        <div class="image-test">
            <h3>Images dengan URL langsung:</h3>
            <div class="url-display">URL: {{ url('images/default-teacher.png') }}</div>
            <img src="{{ url('images/default-teacher.png') }}" alt="Default Teacher Direct" onerror="this.style.border='2px solid red'; this.alt='ERROR: Image not found';">
        </div>
    </div>

    <div class="test-section">
        <h2>3. Test dengan Storage (jika ada)</h2>
        <div class="image-test">
            <h3>Storage URL:</h3>
            <div class="url-display">URL: {{ Storage::url('test.txt') }}</div>
            <p>Storage test: {{ Storage::exists('test.txt') ? 'File exists' : 'File not found' }}</p>
        </div>
    </div>

    <div class="test-section">
        <h2>4. Informasi Debug</h2>
        <div class="url-display">
            <strong>APP_URL:</strong> {{ config('app.url') }}<br>
            <strong>Current URL:</strong> {{ request()->url() }}<br>
            <strong>Asset URL:</strong> {{ asset('') }}<br>
            <strong>Public Path:</strong> {{ public_path() }}<br>
        </div>
    </div>

    <div class="test-section">
        <h2>5. Solusi yang Disarankan</h2>
        <h3>Untuk gambar statis (logo, icon):</h3>
        <pre><code>&lt;img src="{{ asset('images/foto.jpg') }}" alt="Foto"&gt;</code></pre>
        
        <h3>Untuk gambar dari storage:</h3>
        <pre><code>&lt;img src="{{ Storage::url('uploads/foto.jpg') }}" alt="Foto"&gt;</code></pre>
        
        <h3>Untuk gambar dengan fallback:</h3>
        <pre><code>&lt;img src="{{ asset('images/foto.jpg') }}" 
     alt="Foto" 
     onerror="this.src='{{ asset('images/default-teacher.png') }}'"&gt;</code></pre>
    </div>
</body>
</html>

