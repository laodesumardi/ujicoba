@extends('layouts.admin')

@section('title', 'Tambah Fasilitas')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Tambah Fasilitas</h1>
                    <p class="text-primary-100 mt-2">Tambahkan fasilitas baru yang akan ditampilkan di landing page</p>
                </div>
                <a href="{{ route('admin.facilities.index') }}" class="bg-white text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center">
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
                <h3 class="text-lg font-semibold text-gray-900">Form Tambah Fasilitas</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Fasilitas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('category') border-red-500 @enderror" required>
                                <option value="">Pilih Kategori</option>
                                <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>Umum</option>
                                <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Akademik</option>
                                <option value="sports" {{ old('category') == 'sports' ? 'selected' : '' }}>Olahraga</option>
                                <option value="library" {{ old('category') == 'library' ? 'selected' : '' }}>Perpustakaan</option>
                                <option value="laboratory" {{ old('category') == 'laboratory' ? 'selected' : '' }}>Laboratorium</option>
                                <option value="technology" {{ old('category') == 'technology' ? 'selected' : '' }}>Teknologi</option>
                                <option value="welfare" {{ old('category') == 'welfare' ? 'selected' : '' }}>Kesejahteraan</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                            <input type="file" name="image" id="image" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('image') border-red-500 @enderror" accept="image/*" onchange="previewImage(this)">
                            <div id="imagePreview" class="mt-4 hidden">
                                <div class="relative w-40 h-40 border border-gray-300 rounded-lg overflow-hidden bg-gray-100">
                                    <img id="previewImg" class="w-full h-full object-cover" alt="Preview" style="display: block;">
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Preview gambar</p>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (CSS Class)</label>
                            <input type="text" name="icon" id="icon" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('icon') border-red-500 @enderror" value="{{ old('icon') }}" placeholder="Contoh: fas fa-book">
                            <p class="mt-1 text-sm text-gray-500">Gunakan class CSS untuk icon (Font Awesome, dll)</p>
                            @error('icon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                            <input type="number" name="sort_order" id="sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('sort_order') border-red-500 @enderror" value="{{ old('sort_order', 0) }}" min="0">
                            <p class="mt-1 text-sm text-gray-500">Angka kecil akan ditampilkan lebih dulu</p>
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label for="is_featured" class="ml-2 block text-sm text-gray-900">Fasilitas Unggulan</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.facilities.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
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

<script>
function previewImage(input) {
    console.log('previewImage called');
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (!preview || !previewImg) {
        console.error('Preview elements not found');
        return;
    }
    
    if (input.files && input.files[0]) {
        console.log('File selected:', input.files[0].name);
        const reader = new FileReader();
        
        reader.onload = function(e) {
            console.log('File read successfully');
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.onerror = function() {
            console.error('Error reading file');
            preview.classList.add('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        console.log('No file selected');
        preview.classList.add('hidden');
    }
}
</script>
@endsection
