<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <meta http-equiv="refresh" content="2;url={{ $url }}">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #14213d 0%, #1e3a8a 100%);
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h1 {
            margin: 0 0 1rem 0;
            font-size: 1.5rem;
            font-weight: 600;
        }
        p {
            margin: 0 0 1rem 0;
            opacity: 0.9;
        }
        .url {
            font-family: monospace;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
        .manual-link {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 500;
        }
        .manual-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner"></div>
        <h1>Login Berhasil!</h1>
        <p>{{ $message }}</p>
        <p>Mengarahkan ke dashboard...</p>
        <div class="url">{{ $url }}</div>
        <p>Jika tidak otomatis redirect, <a href="{{ $url }}" class="manual-link">klik di sini</a></p>
    </div>

    <script>
        // Force redirect after 2 seconds
        setTimeout(function() {
            window.location.href = '{{ $url }}';
        }, 2000);
        
        // Also redirect on click anywhere
        document.addEventListener('click', function() {
            window.location.href = '{{ $url }}';
        });
    </script>
</body>
</html>




