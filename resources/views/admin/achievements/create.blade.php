@extends('layouts.admin')

@section('title', 'Tambah Prestasi')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Tambah Prestasi</h1>
                    <p class="text-primary-100 mt-2">Tambahkan prestasi baru ke dalam sistem</p>
                </div>
                <a href="{{ route('admin.achievements.index') }}" class="bg-white text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-6 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Form Tambah Prestasi</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.achievements.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Prestasi <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('type') border-red-500 @enderror" required>
                                <option value="">Pilih Tipe</option>
                                <option value="academic" {{ old('type') == 'academic' ? 'selected' : '' }}>Akademik</option>
                                <option value="non_academic" {{ old('type') == 'non_academic' ? 'selected' : '' }}>Non-Akademik</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-2">
                                Level <span class="text-red-500">*</span>
                            </label>
                            <select name="level" id="level" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('level') border-red-500 @enderror" required>
                                <option value="">Pilih Level</option>
                                <option value="kabupaten" {{ old('level') == 'kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                                <option value="provinsi" {{ old('level') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                                <option value="nasional" {{ old('level') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="internasional" {{ old('level') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                            @error('level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Prestasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="year" id="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('year') border-red-500 @enderror" value="{{ old('year') }}" min="2000" max="2030" required>
                            @error('year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Posisi/Juara</label>
                            <input type="text" name="position" id="position" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('position') border-red-500 @enderror" value="{{ old('position') }}" placeholder="Contoh: Juara 1, Juara 2, dll">
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="participant_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Peserta/Kelompok</label>
                            <input type="text" name="participant_name" id="participant_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('participant_name') border-red-500 @enderror" value="{{ old('participant_name') }}">
                            @error('participant_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif</label>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.achievements.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection