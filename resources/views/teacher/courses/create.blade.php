@extends('layouts.teacher')

@section('title', 'Buat Kelas Baru')
@section('page-title', 'Buat Kelas Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('teacher.courses.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Kelas</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Kelas *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror" 
                           placeholder="Masukkan judul kelas">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Kode Kelas *</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('code') border-red-500 @enderror" 
                           placeholder="Contoh: MAT-IX-A">
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kelas *</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror" 
                          placeholder="Jelaskan tentang kelas ini">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran *</label>
                    <select name="subject" id="subject" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('subject') border-red-500 @enderror">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->name }}" {{ old('subject') == $subject->name ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="class_level" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kelas *</label>
                    <select name="class_level" id="class_level" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('class_level') border-red-500 @enderror">
                        <option value="">Pilih Tingkat Kelas</option>
                        <option value="VII" {{ old('class_level') == 'VII' ? 'selected' : '' }}>Kelas VII</option>
                        <option value="VIII" {{ old('class_level') == 'VIII' ? 'selected' : '' }}>Kelas VIII</option>
                        <option value="IX" {{ old('class_level') == 'IX' ? 'selected' : '' }}>Kelas IX</option>
                    </select>
                    @error('class_level')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="class_section" class="block text-sm font-medium text-gray-700 mb-2">Rombel</label>
                    <select name="class_section" id="class_section" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('class_section') border-red-500 @enderror">
                        <option value="">Semua Rombel</option>
                        <option value="A" {{ old('class_section') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('class_section') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('class_section') == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ old('class_section') == 'D' ? 'selected' : '' }}>D</option>
                    </select>
                    @error('class_section')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Pengaturan Kelas</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai *</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('start_date') border-red-500 @enderror">
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Berakhir</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('end_date') border-red-500 @enderror">
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="max_students" class="block text-sm font-medium text-gray-700 mb-2">Maksimal Siswa</label>
                <input type="number" name="max_students" id="max_students" value="{{ old('max_students') }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('max_students') border-red-500 @enderror" 
                       placeholder="Kosongkan untuk tidak ada batasan">
                @error('max_students')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}
                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="is_public" class="ml-2 block text-sm text-gray-900">
                        Kelas Publik (Siswa dapat bergabung sendiri)
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="allow_discussions" id="allow_discussions" value="1" {{ old('allow_discussions', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="allow_discussions" class="ml-2 block text-sm text-gray-900">
                        Izinkan diskusi di forum
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="allow_announcements" id="allow_announcements" value="1" {{ old('allow_announcements', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="allow_announcements" class="ml-2 block text-sm text-gray-900">
                        Izinkan pengumuman
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="auto_enroll" id="auto_enroll" value="1" {{ old('auto_enroll') ? 'checked' : '' }}
                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="auto_enroll" class="ml-2 block text-sm text-gray-900">
                        Auto-enroll siswa (tidak perlu persetujuan)
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('teacher.courses.index') }}" 
               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors duration-200">
                Buat Kelas
            </button>
        </div>
    </form>
</div>
@endsection
