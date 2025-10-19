@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Mata Pelajaran</h1>
        <a href="{{ route('admin.subjects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.subjects.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Kode Mata Pelajaran *</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('code') border-red-500 @enderror" 
                           placeholder="e.g., MAT, BIN, IPA" required>
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Mata Pelajaran *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror" 
                           placeholder="e.g., Matematika, Bahasa Indonesia" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tingkat -->
                <div>
                    <label for="level" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Pendidikan *</label>
                    <select name="level" id="level" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('level') border-red-500 @enderror" required>
                        <option value="">Pilih Tingkat</option>
                        <option value="SD" {{ old('level') == 'SD' ? 'selected' : '' }}>Sekolah Dasar (SD)</option>
                        <option value="SMP" {{ old('level') == 'SMP' ? 'selected' : '' }}>Sekolah Menengah Pertama (SMP)</option>
                        <option value="SMA" {{ old('level') == 'SMA' ? 'selected' : '' }}>Sekolah Menengah Atas (SMA)</option>
                    </select>
                    @error('level')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam per Minggu -->
                <div>
                    <label for="hours_per_week" class="block text-sm font-medium text-gray-700 mb-2">Jam per Minggu *</label>
                    <input type="number" name="hours_per_week" id="hours_per_week" value="{{ old('hours_per_week', 2) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('hours_per_week') border-red-500 @enderror" 
                           min="1" max="10" required>
                    @error('hours_per_week')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warna -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Warna Identifikasi *</label>
                    <div class="flex items-center space-x-4">
                        <input type="color" name="color" id="color" value="{{ old('color', '#3B82F6') }}" 
                               class="w-12 h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('color') border-red-500 @enderror" required>
                        <input type="text" value="{{ old('color', '#3B82F6') }}" 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" 
                               readonly>
                    </div>
                    @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Urutan -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('sort_order') border-red-500 @enderror" 
                           min="0">
                    @error('sort_order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('description') border-red-500 @enderror" 
                              placeholder="Deskripsi mata pelajaran...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} 
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Mata Pelajaran Aktif
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.subjects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Update color text input when color picker changes
document.getElementById('color').addEventListener('input', function() {
    document.querySelector('input[type="text"]').value = this.value;
});
</script>
@endsection




