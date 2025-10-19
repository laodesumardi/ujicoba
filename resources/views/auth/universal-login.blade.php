<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMP Negeri 01 Namrole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-primary-600 { background-color: #14213d; }
        .text-primary-600 { color: #14213d; }
        .border-primary-600 { border-color: #14213d; }
        .focus\:ring-primary-500:focus { --tw-ring-color: #14213d; }
        .hover\:bg-primary-700:hover { background-color: #0f1a2e; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('logo.png') }}" alt="Logo SMP Negeri 01 Namrole" class="h-16 w-auto">
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Masuk ke Sistem
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                SMP Negeri 01 Namrole
            </p>
            <p class="text-xs text-gray-500 mt-1">
                Login untuk Admin, Guru, dan Siswa
            </p>
        </div>

        <!-- Login Form -->
        <form class="mt-8 space-y-6" action="{{ route('login.submit') }}" method="POST">
            @csrf
            
            <div class="bg-white py-8 px-6 shadow rounded-lg">
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                            <div>
                                <strong>Login Gagal!</strong>
                                <ul class="mt-1 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror" 
                               placeholder="Masukkan email Anda"
                               required 
                               autofocus>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror" 
                               placeholder="Masukkan password Anda"
                               required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                    </button>
                </div>

                <!-- Role Information -->
                <div class="mt-6 bg-gray-50 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Login
                    </h3>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p><strong>Admin:</strong> Akses dashboard admin</p>
                        <p><strong>Guru:</strong> Akses dashboard guru</p>
                        <p><strong>Siswa:</strong> Akses dashboard siswa</p>
                    </div>
                </div>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-xs text-gray-500">
                © 2024 SMP Negeri 01 Namrole. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>




