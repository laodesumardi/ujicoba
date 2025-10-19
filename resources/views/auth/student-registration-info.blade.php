<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Siswa - SMP Negeri 01 Namrole</title>
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
                Registrasi Siswa
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                SMP Negeri 01 Namrole
            </p>
            <p class="text-xs text-gray-500 mt-1">
                Daftar sebagai siswa baru
            </p>
        </div>

        <!-- Registration Info Card -->
        <div class="bg-white py-8 px-6 shadow rounded-lg">
            <!-- Important Notice -->
            <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-yellow-800">
                            Perhatian Penting!
                        </h4>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Semua siswa baru <strong>WAJIB</strong> melakukan registrasi melalui form pendaftaran online untuk mendapatkan akses ke portal pembelajaran digital.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Process -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-list-ol mr-2 text-primary-600"></i>
                    Proses Registrasi
                </h4>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="bg-primary-100 rounded-full w-8 h-8 flex items-center justify-center mr-3">
                            <i class="fas fa-user-plus text-primary-600 text-sm"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-900 text-sm">1. Daftar Online</h5>
                            <p class="text-xs text-gray-600">Isi form registrasi dengan data lengkap dan valid</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-primary-100 rounded-full w-8 h-8 flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-primary-600 text-sm"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-900 text-sm">2. Verifikasi Data</h5>
                            <p class="text-xs text-gray-600">Sistem akan memverifikasi data yang diinput</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-primary-100 rounded-full w-8 h-8 flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-primary-600 text-sm"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-900 text-sm">3. Akses Portal</h5>
                            <p class="text-xs text-gray-600">Dapatkan akses ke dashboard siswa</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Required Information -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-clipboard-list mr-2 text-primary-600"></i>
                    Data yang Diperlukan
                </h4>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <h5 class="font-medium text-gray-900 mb-2 text-sm">Informasi Pribadi</h5>
                        <ul class="space-y-1 text-xs text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                Nama lengkap, NIS, Email, Kelas, Rombel
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                Telepon, Tanggal lahir, Jenis kelamin, Agama
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                Alamat lengkap
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h5 class="font-medium text-gray-900 mb-2 text-sm">Informasi Orang Tua/Wali</h5>
                        <ul class="space-y-1 text-xs text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                Nama, telepon, email orang tua/wali
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Benefits -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h4 class="text-lg font-semibold text-blue-900 mb-3 text-sm">
                    <i class="fas fa-star mr-2"></i>
                    Keuntungan Setelah Registrasi
                </h4>
                <div class="grid grid-cols-1 gap-2">
                    <div class="flex items-center text-xs text-blue-800">
                        <i class="fas fa-book text-blue-600 mr-2"></i>
                        Akses materi pembelajaran
                    </div>
                    <div class="flex items-center text-xs text-blue-800">
                        <i class="fas fa-tasks text-blue-600 mr-2"></i>
                        Tugas dan penilaian online
                    </div>
                    <div class="flex items-center text-xs text-blue-800">
                        <i class="fas fa-comments text-blue-600 mr-2"></i>
                        Forum diskusi dengan guru
                    </div>
                    <div class="flex items-center text-xs text-blue-800">
                        <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                        Laporan nilai dan progress
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('register.form') }}" 
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                    <i class="fas fa-user-plus mr-2"></i>
                    Mulai Registrasi Sekarang
                </a>
                
                <a href="{{ route('login') }}" 
                   class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sudah Punya Akun? Login
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-xs text-gray-500">
                © 2024 SMP Negeri 01 Namrole. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>