@extends('layouts.app')

@section('title', 'Daftar PPDB - Penerimaan Peserta Didik Baru')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 md:mb-4 leading-tight">
                    Formulir Pendaftaran PPDB
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-white opacity-90 leading-relaxed">
                    SMP Negeri 01 Namrole Tahun Ajaran 2024/2025
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-8">
            <form method="POST" action="{{ route('ppdb.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Data Siswa -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Data Siswa</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label for="student_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" name="student_name" id="student_name" value="{{ old('student_name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('student_name') border-red-500 @enderror" required>
                            @error('student_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                            <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('birth_place') border-red-500 @enderror" required>
                            @error('birth_place')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('birth_date') border-red-500 @enderror" required>
                            @error('birth_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                            <select name="gender" id="gender" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('gender') border-red-500 @enderror" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Agama -->
                        <div>
                            <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">Agama *</label>
                            <select name="religion" id="religion" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('religion') border-red-500 @enderror" required>
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

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                            <textarea name="address" id="address" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('address') border-red-500 @enderror" required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon/HP *</label>
                            <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('phone_number') border-red-500 @enderror" required>
                            @error('phone_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email (Opsional)</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Data Orang Tua/Wali</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Orang Tua -->
                        <div>
                            <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua/Wali *</label>
                            <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('parent_name') border-red-500 @enderror" required>
                            @error('parent_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon Orang Tua -->
                        <div>
                            <label for="parent_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon Orang Tua *</label>
                            <input type="tel" name="parent_phone" id="parent_phone" value="{{ old('parent_phone') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('parent_phone') border-red-500 @enderror" required>
                            @error('parent_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pekerjaan Orang Tua -->
                        <div class="md:col-span-2">
                            <label for="parent_occupation" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Orang Tua *</label>
                            <input type="text" name="parent_occupation" id="parent_occupation" value="{{ old('parent_occupation') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('parent_occupation') border-red-500 @enderror" required>
                            @error('parent_occupation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Akademik -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Data Akademik</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sekolah Asal -->
                        <div>
                            <label for="previous_school" class="block text-sm font-medium text-gray-700 mb-2">Sekolah Asal</label>
                            <input type="text" name="previous_school" id="previous_school" value="{{ old('previous_school') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('previous_school') border-red-500 @enderror">
                            @error('previous_school')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prestasi -->
                        <div>
                            <label for="achievements" class="block text-sm font-medium text-gray-700 mb-2">Prestasi (Opsional)</label>
                            <textarea name="achievements" id="achievements" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('achievements') border-red-500 @enderror">{{ old('achievements') }}</textarea>
                            @error('achievements')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Motivasi -->
                        <div class="md:col-span-2">
                            <label for="motivation" class="block text-sm font-medium text-gray-700 mb-2">Motivasi Masuk Sekolah (Opsional)</label>
                            <textarea name="motivation" id="motivation" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('motivation') border-red-500 @enderror">{{ old('motivation') }}</textarea>
                            @error('motivation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Upload Dokumen</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Foto Siswa -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Siswa (Max 2MB)</label>
                            <input type="file" name="photo" id="photo" accept="image/*" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('photo') border-red-500 @enderror">
                            @error('photo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Akte Kelahiran -->
                        <div>
                            <label for="birth_certificate" class="block text-sm font-medium text-gray-700 mb-2">Akte Kelahiran (Max 5MB)</label>
                            <input type="file" name="birth_certificate" id="birth_certificate" accept=".pdf,.jpg,.jpeg,.png" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('birth_certificate') border-red-500 @enderror">
                            @error('birth_certificate')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kartu Keluarga -->
                        <div>
                            <label for="family_card" class="block text-sm font-medium text-gray-700 mb-2">Kartu Keluarga (Max 5MB)</label>
                            <input type="file" name="family_card" id="family_card" accept=".pdf,.jpg,.jpeg,.png" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('family_card') border-red-500 @enderror">
                            @error('family_card')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Raport -->
                        <div>
                            <label for="report_card" class="block text-sm font-medium text-gray-700 mb-2">Raport Terakhir (Max 5MB)</label>
                            <input type="file" name="report_card" id="report_card" accept=".pdf,.jpg,.jpeg,.png" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('report_card') border-red-500 @enderror">
                            @error('report_card')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('ppdb.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        Daftar PPDB
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
