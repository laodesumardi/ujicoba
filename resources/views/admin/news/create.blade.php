@extends('layouts.admin')

@section('title', 'Tambah Berita')
@section('page-title', 'Tambah Berita')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold text-primary-900 mb-6">Tambah Berita Baru</h2>

                <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Berita *</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror" 
                                       placeholder="Masukkan judul berita..." required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                                <select name="category" id="category" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('category') border-red-500 @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $key => $label)
                                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis *</label>
                                <select name="type" id="type" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('type') border-red-500 @enderror" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="news" {{ old('type') == 'news' ? 'selected' : '' }}>Berita</option>
                                    <option value="announcement" {{ old('type') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                                </select>
                                @error('type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                                <select name="status" id="status" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('status') border-red-500 @enderror" required>
                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Published At -->
                            <div>
                                <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publikasi</label>
                                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('published_at') border-red-500 @enderror">
                                @error('published_at')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Konten</h3>
                        <div class="space-y-6">
                            <!-- Excerpt -->
                            <div>
                                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan</label>
                                <textarea name="excerpt" id="excerpt" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('excerpt') border-red-500 @enderror" 
                                          placeholder="Masukkan ringkasan berita...">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Lengkap *</label>
                                <textarea name="content" id="content" rows="10" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror" 
                                          placeholder="Masukkan konten berita..." required>{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Media -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Media</h3>
                        <div class="space-y-6">
                            <!-- Featured Image -->
                            <div>
                                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Utama</label>
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="mb-4 hidden">
                                    <div class="relative inline-block">
                                        <img id="previewImg" src="" alt="Preview" class="max-w-xs max-h-48 rounded-lg border border-gray-300">
                                        <button type="button" id="removeImage" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600">
                                            ×
                                        </button>
                                    </div>
                                </div>
                                
                                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('featured_image') border-red-500 @enderror"
                                       onchange="previewImage(this)">
                                @error('featured_image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF, WebP. Maksimal 5MB.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Author Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penulis</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Author Name -->
                            <div>
                                <label for="author_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Penulis</label>
                                <input type="text" name="author_name" id="author_name" value="{{ old('author_name') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('author_name') border-red-500 @enderror" 
                                       placeholder="Masukkan nama penulis...">
                                @error('author_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Author Email -->
                            <div>
                                <label for="author_email" class="block text-sm font-medium text-gray-700 mb-2">Email Penulis</label>
                                <input type="email" name="author_email" id="author_email" value="{{ old('author_email') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('author_email') border-red-500 @enderror" 
                                       placeholder="Masukkan email penulis...">
                                @error('author_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tag</h3>
                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tag Berita</label>
                            <input type="text" name="tags" id="tags" value="{{ old('tags') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('tags') border-red-500 @enderror" 
                                   placeholder="Masukkan tag dipisahkan dengan koma (contoh: pendidikan, sekolah, prestasi)">
                            @error('tags')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">Pisahkan tag dengan koma (,)</p>
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Opsi</h3>
                        <div class="space-y-4">
                            <!-- Featured -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="is_featured" class="ml-2 block text-sm font-medium text-gray-900">
                                    Jadikan Berita Utama
                                </label>
                            </div>

                            <!-- Pinned -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_pinned" id="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="is_pinned" class="ml-2 block text-sm font-medium text-gray-900">
                                    Pasang di Atas
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.news.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700">
                            Simpan Berita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removeBtn = document.getElementById('removeImage');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}

// Remove image functionality
document.getElementById('removeImage').addEventListener('click', function() {
    const input = document.getElementById('featured_image');
    const preview = document.getElementById('imagePreview');
    
    input.value = '';
    preview.classList.add('hidden');
});

// Auto-resize textarea
document.getElementById('content').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();
    const category = document.getElementById('category').value;
    const type = document.getElementById('type').value;
    const status = document.getElementById('status').value;
    
    if (!title) {
        e.preventDefault();
        alert('Judul berita harus diisi!');
        document.getElementById('title').focus();
        return;
    }
    
    if (!content) {
        e.preventDefault();
        alert('Konten berita harus diisi!');
        document.getElementById('content').focus();
        return;
    }
    
    if (!category) {
        e.preventDefault();
        alert('Kategori harus dipilih!');
        document.getElementById('category').focus();
        return;
    }
    
    if (!type) {
        e.preventDefault();
        alert('Jenis berita harus dipilih!');
        document.getElementById('type').focus();
        return;
    }
    
    if (!status) {
        e.preventDefault();
        alert('Status berita harus dipilih!');
        document.getElementById('status').focus();
        return;
    }
});
</script>
@endsection
