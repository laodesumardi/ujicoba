<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Registrasi Siswa - SMP Negeri 01 Namrole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-primary-600 { background-color: #14213d; }
        .text-primary-600 { color: #14213d; }
        .border-primary-600 { border-color: #14213d; }
        .focus\:ring-primary-500:focus { --tw-ring-color: #14213d; }
        .hover\:bg-primary-700:hover { background-color: #0f1a2e; }
        .bg-gradient-primary { background: linear-gradient(135deg, #14213d 0%, #1e3a8a 100%); }
        .form-section { transition: all 0.3s ease; }
        .form-section:hover { transform: translateY(-2px); }
        .input-focus:focus { box-shadow: 0 0 0 3px rgba(20, 33, 61, 0.1); }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">
    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
                    <div class="flex justify-center mb-6">
                        <div class="bg-gradient-primary rounded-full p-4 shadow-lg">
                            <img src="{{ asset('logo.png') }}" alt="Logo SMP Negeri 01 Namrole" class="h-16 w-auto">
                        </div>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">
                        Form Registrasi Siswa
                    </h1>
                    <p class="text-lg text-gray-600 mb-1">
                        SMP Negeri 01 Namrole
                    </p>
                    <p class="text-sm text-gray-500">
                        Lengkapi data untuk mendaftar sebagai siswa
                    </p>
                </div>
            </div>

            <!-- PPDB Requirement Notice -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6 mb-8 shadow-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="bg-blue-500 rounded-full p-2">
                            <i class="fas fa-info-circle text-white text-lg"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            Persyaratan PPDB
                        </h3>
                        <div class="text-blue-800">
                            <p class="mb-2">Sebelum melakukan registrasi sebagai siswa, Anda harus menyelesaikan pendaftaran PPDB terlebih dahulu.</p>
                            <div class="bg-white rounded-lg p-3 border border-blue-200">
                                <p class="text-sm font-medium text-blue-900 mb-1">Belum melakukan PPDB?</p>
                                <a href="{{ route('ppdb.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Klik di sini untuk mendaftar PPDB
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <form action="{{ route('register.submit') }}" method="POST" class="p-8">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Registrasi Gagal!
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Sections -->
                    <div class="space-y-8">
                        <!-- Personal Information Section -->
                        <div class="form-section bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                            <div class="flex items-center mb-6">
                                <div class="bg-primary-600 rounded-full p-3 mr-4">
                                    <i class="fas fa-user text-white text-lg"></i>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900">
                                    Informasi Pribadi
                                </h4>
                            </div>
                        
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="name" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-user mr-2 text-primary-600"></i>Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus transition-all duration-200 @error('name') border-red-500 @enderror"
                                           placeholder="Masukkan nama lengkap"
                                           required>
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="student_id" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-id-card mr-2 text-primary-600"></i>NIS <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="student_id" 
                                           name="student_id" 
                                           value="{{ old('student_id') }}"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus transition-all duration-200 @error('student_id') border-red-500 @enderror"
                                           placeholder="Contoh: 2024001"
                                           required>
                                    @error('student_id')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-envelope mr-2 text-primary-600"></i>Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus transition-all duration-200 @error('email') border-red-500 @enderror"
                                           placeholder="Masukkan email"
                                           required>
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="class_level" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-graduation-cap mr-2 text-primary-600"></i>Kelas <span class="text-red-500">*</span>
                                    </label>
                                    <select id="class_level" 
                                            name="class_level" 
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus transition-all duration-200 @error('class_level') border-red-500 @enderror"
                                            required>
                                        <option value="">Pilih Kelas</option>
                                        <option value="VII" {{ old('class_level') == 'VII' ? 'selected' : '' }}>Kelas VII</option>
                                        <option value="VIII" {{ old('class_level') == 'VIII' ? 'selected' : '' }}>Kelas VIII</option>
                                        <option value="IX" {{ old('class_level') == 'IX' ? 'selected' : '' }}>Kelas IX</option>
                                    </select>
                                    @error('class_level')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="class_section" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-users mr-2 text-primary-600"></i>Rombel <span class="text-red-500">*</span>
                                    </label>
                                    <select id="class_section" 
                                            name="class_section" 
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus transition-all duration-200 @error('class_section') border-red-500 @enderror"
                                            required>
                                        <option value="">Pilih Rombel</option>
                                        <option value="A" {{ old('class_section') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('class_section') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ old('class_section') == 'C' ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ old('class_section') == 'D' ? 'selected' : '' }}>D</option>
                                    </select>
                                    @error('class_section')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="form-section bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                            <div class="flex items-center mb-6">
                                <div class="bg-green-500 rounded-full p-3 mr-4">
                                    <i class="fas fa-info-circle text-white text-lg"></i>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900">
                                    Informasi Tambahan
                                </h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="phone" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-phone mr-2 text-green-600"></i>Nomor Telepon
                                    </label>
                                    <input type="text" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus transition-all duration-200 @error('phone') border-red-500 @enderror"
                                           placeholder="Contoh: 081234567890">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="date_of_birth" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-calendar mr-2 text-green-600"></i>Tanggal Lahir <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" 
                                           id="date_of_birth" 
                                           name="date_of_birth" 
                                           value="{{ old('date_of_birth') }}"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus transition-all duration-200 @error('date_of_birth') border-red-500 @enderror"
                                           required>
                                    @error('date_of_birth')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="form-section bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                            <div class="flex items-center mb-6">
                                <div class="bg-purple-500 rounded-full p-3 mr-4">
                                    <i class="fas fa-lock text-white text-lg"></i>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900">
                                    Informasi Keamanan
                                </h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-key mr-2 text-purple-600"></i>Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus transition-all duration-200 @error('password') border-red-500 @enderror"
                                           placeholder="Masukkan password"
                                           required>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-key mr-2 text-purple-600"></i>Konfirmasi Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus transition-all duration-200 @error('password_confirmation') border-red-500 @enderror"
                                           placeholder="Konfirmasi password"
                                           required>
                                    @error('password_confirmation')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Personal Details Section -->
                        <div class="form-section bg-gradient-to-r from-orange-50 to-yellow-50 rounded-xl p-6 border border-orange-100">
                            <div class="flex items-center mb-6">
                                <div class="bg-orange-500 rounded-full p-3 mr-4">
                                    <i class="fas fa-user-circle text-white text-lg"></i>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900">
                                    Detail Pribadi
                                </h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="gender" class="block text-sm font-semibold text-gray-700">
                                        <i class="fas fa-venus-mars mr-2 text-orange-600"></i>Jenis Kelamin <span class="text-red-500">*</span>
                                    </label>
                                    <select id="gender" 
                                            name="gender" 
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-focus transition-all duration-200 @error('gender') border-red-500 @enderror"
                                            required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 text-center">
                            <button type="submit" 
                                    class="w-full bg-gradient-primary text-white px-8 py-4 rounded-xl font-semibold text-lg hover:shadow-lg transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center">
                                <i class="fas fa-user-plus mr-3"></i>
                                Daftar sebagai Siswa
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-sm text-gray-500">
                    © 2024 SMP Negeri 01 Namrole. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route("register.submit") }}"]');
            const emailInput = document.querySelector('input[name="email"]');
            const nameInput = document.querySelector('input[name="name"]');
            const submitButton = document.querySelector('button[type="submit"]');
            
            // Add PPDB status check before form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = emailInput.value;
                const name = nameInput.value;
                
                if (!email || !name) {
                    alert('Email dan nama harus diisi terlebih dahulu.');
                    return;
                }
                
                // Show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengecek status PPDB...';
                
                // Check PPDB status
                fetch('{{ route("ppdb.check-status") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'approved') {
                        // PPDB approved, proceed with registration
                        form.submit();
                    } else if (data.status === 'not_found') {
                        alert('Email tidak ditemukan dalam database PPDB. Silakan daftar PPDB terlebih dahulu.');
                        window.location.href = '{{ route("ppdb.index") }}';
                    } else if (data.status === 'pending') {
                        alert('Pendaftaran PPDB Anda masih dalam proses review. Silakan tunggu konfirmasi dari admin.');
                    } else if (data.status === 'rejected') {
                        alert('Pendaftaran PPDB Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.');
                    } else {
                        alert('Status PPDB tidak diketahui. Silakan hubungi admin.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengecek status PPDB. Silakan coba lagi.');
                })
                .finally(() => {
                    // Reset button state
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-user-plus mr-3"></i>Daftar sebagai Siswa';
                });
            });
        });
    </script>
</body>
</html>

                    <!-- Parent Information -->
                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-users mr-2 text-primary-600"></i>
                            Informasi Orang Tua/Wali
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2"></i>Nama Orang Tua/Wali
                                </label>
                                <input type="text" 
                                       id="parent_name" 
                                       name="parent_name" 
                                       value="{{ old('parent_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('parent_name') border-red-500 @enderror"
                                       placeholder="Masukkan nama orang tua/wali">
                                @error('parent_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="parent_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-2"></i>Nomor Telepon Orang Tua/Wali
                                </label>
                                <input type="text" 
                                       id="parent_phone" 
                                       name="parent_phone" 
                                       value="{{ old('parent_phone') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('parent_phone') border-red-500 @enderror"
                                       placeholder="Contoh: 081234567890">
                                @error('parent_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="parent_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2"></i>Email Orang Tua/Wali
                                </label>
                                <input type="email" 
                                       id="parent_email" 
                                       name="parent_email" 
                                       value="{{ old('parent_email') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('parent_email') border-red-500 @enderror"
                                       placeholder="Masukkan email orang tua/wali">
                                @error('parent_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-lock mr-2 text-primary-600"></i>
                            Informasi Akun
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2"></i>Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror"
                                       placeholder="Masukkan password"
                                       required>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2"></i>Konfirmasi Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Konfirmasi password"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 space-y-3">
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar sebagai Siswa
                    </button>
                    
                    <a href="{{ route('register') }}" 
                       class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Informasi
                    </a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route("register") }}"]');
            const emailInput = document.querySelector('input[name="email"]');
            const nameInput = document.querySelector('input[name="name"]');
            const submitButton = document.querySelector('button[type="submit"]');
            
            // Add PPDB status check before form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = emailInput.value;
                const name = nameInput.value;
                
                if (!email || !name) {
                    alert('Email dan nama harus diisi terlebih dahulu.');
                    return;
                }
                
                // Show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengecek status PPDB...';
                
                // Check PPDB status
                fetch('{{ route("ppdb.check-status") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'approved') {
                        // PPDB approved, proceed with registration
                        form.submit();
                    } else if (data.status === 'not_found') {
                        alert('Email tidak ditemukan dalam database PPDB. Silakan daftar PPDB terlebih dahulu.');
                        window.location.href = '{{ route("ppdb.index") }}';
                    } else if (data.status === 'pending') {
                        alert('Pendaftaran PPDB Anda masih dalam proses review. Silakan tunggu konfirmasi dari admin.');
                    } else if (data.status === 'rejected') {
                        alert('Pendaftaran PPDB Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.');
                    } else {
                        alert('Status PPDB tidak diketahui. Silakan hubungi admin.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengecek status PPDB. Silakan coba lagi.');
                })
                .finally(() => {
                    // Reset button state
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Daftar sebagai Siswa';
                });
            });
        });
    </script>
</body>
</html>