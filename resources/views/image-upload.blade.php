<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload Test - SMP Negeri 01 Namrole</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .upload-section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="file"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin: 5px; }
        button:hover { background: #0056b3; }
        .result { margin: 10px 0; padding: 10px; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .image-preview { max-width: 300px; margin: 10px 0; }
        .url-display { background: #f8f9fa; padding: 10px; margin: 5px 0; font-family: monospace; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Image Upload Test</h1>
        
        <div class="upload-section">
            <h2>1. Upload ke Public/Images</h2>
            <form id="publicUploadForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="publicImage">Pilih Gambar:</label>
                    <input type="file" id="publicImage" name="image" accept="image/*" required>
                </div>
                <button type="submit">Upload ke Public/Images</button>
            </form>
            <div id="publicResult"></div>
        </div>

        <div class="upload-section">
            <h2>2. Upload ke Storage</h2>
            <form id="storageUploadForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="storageImage">Pilih Gambar:</label>
                    <input type="file" id="storageImage" name="image" accept="image/*" required>
                </div>
                <button type="submit">Upload ke Storage</button>
            </form>
            <div id="storageResult"></div>
        </div>

        <div class="upload-section">
            <h2>3. Contoh Penggunaan di Blade Template</h2>
            <h3>Untuk gambar di public/images:</h3>
            <pre><code>&lt;img src="{{ asset('images/foto.jpg') }}" alt="Foto"&gt;</code></pre>
            
            <h3>Untuk gambar di storage:</h3>
            <pre><code>&lt;img src="{{ Storage::url('uploads/foto.jpg') }}" alt="Foto"&gt;</code></pre>
            
            <h3>Dengan fallback jika gambar tidak ada:</h3>
            <pre><code>&lt;img src="{{ asset('images/foto.jpg') }}" 
     alt="Foto" 
     onerror="this.src='{{ asset('images/default-teacher.png') }}'"&gt;</code></pre>
        </div>

        <div class="upload-section">
            <h2>4. Perbedaan Public/Images vs Storage</h2>
            <table border="1" style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="padding: 10px;">Aspek</th>
                    <th style="padding: 10px;">Public/Images</th>
                    <th style="padding: 10px;">Storage</th>
                </tr>
                <tr>
                    <td style="padding: 10px;"><strong>Lokasi</strong></td>
                    <td style="padding: 10px;">public/images/</td>
                    <td style="padding: 10px;">storage/app/public/</td>
                </tr>
                <tr>
                    <td style="padding: 10px;"><strong>URL Helper</strong></td>
                    <td style="padding: 10px;">asset('images/foto.jpg')</td>
                    <td style="padding: 10px;">Storage::url('uploads/foto.jpg')</td>
                </tr>
                <tr>
                    <td style="padding: 10px;"><strong>Keamanan</strong></td>
                    <td style="padding: 10px;">Akses langsung</td>
                    <td style="padding: 10px;">Lebih aman, bisa dikontrol</td>
                </tr>
                <tr>
                    <td style="padding: 10px;"><strong>Penggunaan</strong></td>
                    <td style="padding: 10px;">Gambar statis (logo, icon)</td>
                    <td style="padding: 10px;">Gambar dinamis (upload user)</td>
                </tr>
            </table>
        </div>

        <div class="upload-section">
            <h2>5. Troubleshooting</h2>
            <h3>Jika gambar tidak muncul:</h3>
            <ul>
                <li>Pastikan file ada di folder yang benar</li>
                <li>Periksa permission folder (755 untuk folder, 644 untuk file)</li>
                <li>Pastikan APP_URL di .env sudah benar</li>
                <li>Jalankan: <code>php artisan storage:link</code> untuk storage</li>
                <li>Clear cache: <code>php artisan config:clear</code></li>
            </ul>
        </div>
    </div>

    <script>
        // Handle public upload
        document.getElementById('publicUploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('image', document.getElementById('publicImage').files[0]);
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            
            fetch('/upload-public', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('publicResult');
                if (data.success) {
                    resultDiv.innerHTML = `
                        <div class="result success">
                            <strong>Berhasil!</strong> ${data.message}<br>
                            <div class="url-display">URL: ${data.url}</div>
                            <img src="${data.url}" alt="Uploaded Image" class="image-preview">
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `<div class="result error"><strong>Error:</strong> ${data.message}</div>`;
                }
            })
            .catch(error => {
                document.getElementById('publicResult').innerHTML = `<div class="result error"><strong>Error:</strong> ${error.message}</div>`;
            });
        });

        // Handle storage upload
        document.getElementById('storageUploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('image', document.getElementById('storageImage').files[0]);
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            
            fetch('/upload-storage', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('storageResult');
                if (data.success) {
                    resultDiv.innerHTML = `
                        <div class="result success">
                            <strong>Berhasil!</strong> ${data.message}<br>
                            <div class="url-display">URL: ${data.url}</div>
                            <img src="${data.url}" alt="Uploaded Image" class="image-preview">
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `<div class="result error"><strong>Error:</strong> ${data.message}</div>`;
                }
            })
            .catch(error => {
                document.getElementById('storageResult').innerHTML = `<div class="result error"><strong>Error:</strong> ${error.message}</div>`;
            });
        });
    </script>
</body>
</html>

