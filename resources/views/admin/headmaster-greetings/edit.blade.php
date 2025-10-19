@extends('layouts.admin')

@section('title', 'Edit Sambutan Kepala Sekolah')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Edit Sambutan Kepala Sekolah</h1>
                    <p class="text-primary-100 mt-2">Perbarui sambutan kepala sekolah: {{ $headmasterGreeting->headmaster_name }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.headmaster-greetings.show', $headmasterGreeting) }}" class="bg-primary-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-400 transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat
                    </a>
                    <a href="{{ route('admin.headmaster-greetings.index') }}" class="bg-white text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-6 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Form Edit Sambutan Kepala Sekolah</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.headmaster-greetings.update', $headmasterGreeting) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="headmaster_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kepala Sekolah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="headmaster_name" id="headmaster_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('headmaster_name') border-red-500 @enderror" value="{{ old('headmaster_name', $headmasterGreeting->headmaster_name) }}" required>
                            @error('headmaster_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Kepala Sekolah</label>
                            @if($headmasterGreeting->photo_url)
                            <div class="mb-4">
                                <div class="w-40 h-40 border border-gray-300 rounded-lg overflow-hidden bg-gray-100 relative">
                                    <img src="{{ $headmasterGreeting->photo_url }}" alt="{{ $headmasterGreeting->headmaster_name }}" 
                                         class="w-full h-full object-cover"
                                         style="max-width: 100% !important; max-height: 100% !important; display: block !important; width: 160px !important; height: 160px !important;"
                                         onerror="console.error('Image failed to load:', this.src); this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                         onload="console.log('Image loaded successfully:', this.src);">
                                    <div class="absolute inset-0 bg-gray-100 flex items-center justify-center hidden">
                                        <div class="text-center">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <p class="text-gray-500 text-xs">Gambar tidak dapat dimuat</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Foto saat ini</p>
                            </div>
                            @else
                            <div class="mb-4">
                                <div class="w-40 h-40 border border-gray-300 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-xs">Tidak ada foto</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Belum ada foto</p>
                            </div>
                            @endif
                            <input type="file" name="photo" id="photo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('photo') border-red-500 @enderror" accept="image/*" onchange="previewImage(this)">
                            <div id="imagePreview" class="mt-4 hidden">
                                <div class="relative w-40 h-40 border border-gray-300 rounded-lg overflow-hidden bg-gray-100">
                                    <img id="previewImg" class="w-full h-full object-cover" alt="Preview" style="display: block;">
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Preview foto baru</p>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB</p>
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="greeting_message" class="block text-sm font-medium text-gray-700 mb-2">
                            Sambutan Kepala Sekolah <span class="text-red-500">*</span>
                        </label>
                        <textarea name="greeting_message" id="greeting_message" rows="8" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('greeting_message') border-red-500 @enderror" required>{{ old('greeting_message', $headmasterGreeting->greeting_message) }}</textarea>
                        @error('greeting_message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" value="1" {{ old('is_active', $headmasterGreeting->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Tampilkan di halaman utama</label>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.headmaster-greetings.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update
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
