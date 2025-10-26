@extends('layouts.teacher')

@section('title', 'Edit Profil Guru')
@section('page-title', 'Edit Profil Guru')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl shadow-lg text-white p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Avatar -->
                <div class="relative">
                    @if($user->photo)
                        <img src="{{ $user->photo_url }}" alt="Foto Profil" 
                             class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    @endif
                    <div class="w-20 h-20 bg-primary-200 rounded-full flex items-center justify-center shadow-lg {{ $user->photo ? 'hidden' : 'flex' }}">
                        <span class="text-primary-600 font-bold text-2xl">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                </div>
                
                <div>
                    <h1 class="text-2xl font-bold mb-2">Edit Profil Guru</h1>
                    <p class="text-primary-100">Perbarui informasi profil guru</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <form action="{{ route('teacher.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Basic Information -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Informasi Dasar</h3>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea id="address" name="address" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                        <textarea id="bio" name="bio" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('bio') border-red-500 @enderror" placeholder="Tuliskan bio singkat tentang Anda...">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Informasi Profesional</h3>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject', $user->subject) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('subject') border-red-500 @enderror" 
                               placeholder="Contoh: Matematika, IPA, Bahasa Indonesia">
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="class_level" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kelas</label>
                            <select id="class_level" name="class_level" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('class_level') border-red-500 @enderror">
                                <option value="">Pilih Tingkat Kelas</option>
                                <option value="VII" {{ old('class_level', $user->class_level) == 'VII' ? 'selected' : '' }}>VII</option>
                                <option value="VIII" {{ old('class_level', $user->class_level) == 'VIII' ? 'selected' : '' }}>VIII</option>
                                <option value="IX" {{ old('class_level', $user->class_level) == 'IX' ? 'selected' : '' }}>IX</option>
                            </select>
                            @error('class_level')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="class_section" class="block text-sm font-medium text-gray-700 mb-2">Rombongan Belajar</label>
                            <select id="class_section" name="class_section" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('class_section') border-red-500 @enderror">
                                <option value="">Pilih Rombongan</option>
                                <option value="A" {{ old('class_section', $user->class_section) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('class_section', $user->class_section) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('class_section', $user->class_section) == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ old('class_section', $user->class_section) == 'D' ? 'selected' : '' }}>D</option>
                            </select>
                            @error('class_section')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                        <input type="text" id="position" name="position" value="{{ old('position', $user->position) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('position') border-red-500 @enderror" 
                               placeholder="Contoh: Guru Mata Pelajaran, Wali Kelas">
                        @error('position')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="employment_status" class="block text-sm font-medium text-gray-700 mb-2">Status Kepegawaian</label>
                        <select id="employment_status" name="employment_status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('employment_status') border-red-500 @enderror">
                            <option value="">Pilih Status Kepegawaian</option>
                            <option value="full-time" {{ old('employment_status', $user->employment_status) == 'full-time' ? 'selected' : '' }}>Pegawai Tetap</option>
                            <option value="part-time" {{ old('employment_status', $user->employment_status) == 'part-time' ? 'selected' : '' }}>Pegawai Tidak Tetap</option>
                            <option value="contract" {{ old('employment_status', $user->employment_status) == 'contract' ? 'selected' : '' }}>Kontrak</option>
                        </select>
                        @error('employment_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="education" class="block text-sm font-medium text-gray-700 mb-2">Pendidikan</label>
                        <input type="text" id="education" name="education" value="{{ old('education', $user->education) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('education') border-red-500 @enderror" 
                               placeholder="Contoh: S1 Pendidikan Matematika">
                        @error('education')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="certification" class="block text-sm font-medium text-gray-700 mb-2">Sertifikasi</label>
                        <textarea id="certification" name="certification" rows="2" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('certification') border-red-500 @enderror" 
                                  placeholder="Contoh: Sertifikat Pendidik, Sertifikat Kompetensi">{{ old('certification', $user->certification) }}</textarea>
                        @error('certification')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-2">Pengalaman Mengajar (Tahun)</label>
                        <input type="number" id="experience_years" name="experience_years" value="{{ old('experience_years', $user->experience_years) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('experience_years') border-red-500 @enderror" 
                               min="0" max="50" placeholder="Contoh: 5">
                        @error('experience_years')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Photo and Security -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Foto & Keamanan</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Photo Upload -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                        <div class="flex items-center space-x-4">
                            @if($user->photo)
                                <img src="{{ $user->photo_url }}" alt="Foto Profil" class="w-16 h-16 rounded-full object-cover border-2 border-gray-300">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" id="photo" name="photo" accept="image/*" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('photo') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB</p>
                                @error('photo')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Password Change -->
                    <div>
                        <h4 class="text-md font-semibold text-gray-900 mb-4">Ubah Password</h4>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                                <input type="password" id="current_password" name="current_password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('current_password') border-red-500 @enderror" 
                                       placeholder="Masukkan password lama">
                                @error('current_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                <input type="password" id="password" name="password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror" 
                                       placeholder="Masukkan password baru">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                       placeholder="Konfirmasi password baru">
                            </div>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-blue-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Catatan:</strong> Kosongkan field password jika tidak ingin mengubah password.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                <a href="{{ route('teacher.profile') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
