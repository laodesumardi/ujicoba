<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Siswa - SMP Negeri 01 Namrole</title>
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
    <div class="max-w-2xl w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('logo.png') }}" alt="Logo SMP Negeri 01 Namrole" class="h-16 w-auto">
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Form Registrasi Siswa
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                SMP Negeri 01 Namrole
            </p>
            <p class="text-xs text-gray-500 mt-1">
                Lengkapi data untuk mendaftar sebagai siswa
            </p>
        </div>

        <!-- Registration Form -->
        <form action="{{ route('register') }}" method="POST" class="mt-8 space-y-6">
            @csrf
            
            <div class="bg-white py-8 px-6 shadow rounded-lg">
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                            <div>
                                <strong>Registrasi Gagal!</strong>
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
                    <!-- Personal Information -->
                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-user mr-2 text-primary-600"></i>
                            Informasi Pribadi
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2"></i>Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-id-card mr-2"></i>NIS <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="student_id" 
                                       name="student_id" 
                                       value="{{ old('student_id') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('student_id') border-red-500 @enderror"
                                       placeholder="Contoh: 2024001"
                                       required>
                                @error('student_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2"></i>Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                                       placeholder="Masukkan email"
                                       required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="class_level" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-graduation-cap mr-2"></i>Kelas <span class="text-red-500">*</span>
                                </label>
                                <select id="class_level" 
                                        name="class_level" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('class_level') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="VII" {{ old('class_level') == 'VII' ? 'selected' : '' }}>Kelas VII</option>
                                    <option value="VIII" {{ old('class_level') == 'VIII' ? 'selected' : '' }}>Kelas VIII</option>
                                    <option value="IX" {{ old('class_level') == 'IX' ? 'selected' : '' }}>Kelas IX</option>
                                </select>
                                @error('class_level')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="class_section" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-users mr-2"></i>Rombel <span class="text-red-500">*</span>
                                </label>
                                <select id="class_section" 
                                        name="class_section" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('class_section') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Rombel</option>
                                    <option value="A" {{ old('class_section') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('class_section') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('class_section') == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="D" {{ old('class_section') == 'D' ? 'selected' : '' }}>D</option>
                                </select>
                                @error('class_section')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-2"></i>Nomor Telepon
                                </label>
                                <input type="text" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror"
                                       placeholder="Contoh: 081234567890">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar mr-2"></i>Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       id="date_of_birth" 
                                       name="date_of_birth" 
                                       value="{{ old('date_of_birth') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('date_of_birth') border-red-500 @enderror"
                                       required>
                                @error('date_of_birth')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-venus-mars mr-2"></i>Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select id="gender" 
                                        name="gender" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('gender') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-pray mr-2"></i>Agama <span class="text-red-500">*</span>
                                </label>
                                <select id="religion" 
                                        name="religion" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('religion') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('religion')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" 
                                      name="address" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('address') border-red-500 @enderror"
                                      placeholder="Masukkan alamat lengkap"
                                      required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

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
</body>
</html>