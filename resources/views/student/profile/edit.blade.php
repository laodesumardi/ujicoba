@extends('layouts.student')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

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
                    <h1 class="text-2xl font-bold mb-2">Edit Profil</h1>
                    <p class="text-primary-100">Perbarui informasi profil Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">NIS</label>
                        <input type="text" id="student_id" name="student_id" value="{{ old('student_id', $user->student_id) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('student_id') border-red-500 @enderror">
                        @error('student_id')
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
                        <label for="class_level" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kelas *</label>
                        <select id="class_level" name="class_level" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('class_level') border-red-500 @enderror" required>
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

                <!-- Personal Information -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Informasi Pribadi</h3>
                    
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('date_of_birth') border-red-500 @enderror">
                        @error('date_of_birth')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <select id="gender" name="gender" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('gender') border-red-500 @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                        <select id="religion" name="religion" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('religion') border-red-500 @enderror">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('religion', $user->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('religion', $user->religion) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('religion', $user->religion) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('religion', $user->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('religion', $user->religion) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('religion', $user->religion) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                        @error('religion')
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
                </div>
            </div>

            <!-- Parent Information -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Orang Tua/Wali</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div>
                        <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua/Wali</label>
                        <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name', $user->parent_name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('parent_name') border-red-500 @enderror">
                        @error('parent_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="parent_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" id="parent_phone" name="parent_phone" value="{{ old('parent_phone', $user->parent_phone) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('parent_phone') border-red-500 @enderror">
                        @error('parent_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="parent_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="parent_email" name="parent_email" value="{{ old('parent_email', $user->parent_email) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('parent_email') border-red-500 @enderror">
                        @error('parent_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                <a href="{{ route('student.profile.show') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
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