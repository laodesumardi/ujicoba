@extends('layouts.admin')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Data Perpustakaan</h1>
        <a href="{{ route('admin.libraries.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.libraries.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                </div>

                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Perpustakaan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('location') border-red-500 @enderror">
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="opening_hours" class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional</label>
                    <textarea name="opening_hours" id="opening_hours" rows="2" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('opening_hours') border-red-500 @enderror" 
                              placeholder="Contoh: Senin - Jumat: 08:00 - 16:00">{{ old('opening_hours') }}</textarea>
                    @error('opening_hours')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Librarian Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Informasi Pustakawan</h3>
                </div>

                <div>
                    <label for="librarian_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pustakawan</label>
                    <input type="text" name="librarian_name" id="librarian_name" value="{{ old('librarian_name') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('librarian_name') border-red-500 @enderror">
                    @error('librarian_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="librarian_phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon Pustakawan</label>
                    <input type="text" name="librarian_phone" id="librarian_phone" value="{{ old('librarian_phone') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('librarian_phone') border-red-500 @enderror">
                    @error('librarian_phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="librarian_email" class="block text-sm font-medium text-gray-700 mb-2">Email Pustakawan</label>
                    <input type="email" name="librarian_email" id="librarian_email" value="{{ old('librarian_email') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('librarian_email') border-red-500 @enderror">
                    @error('librarian_email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Organization Chart -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Struktur Organisasi</h3>
                </div>

                <div class="md:col-span-2">
                    <label for="organization_chart" class="block text-sm font-medium text-gray-700 mb-2">Gambar Struktur Organisasi</label>
                    <input type="file" name="organization_chart" id="organization_chart" accept="image/*" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('organization_chart') border-red-500 @enderror"
                           onchange="previewImage(this)">
                    @error('organization_chart')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div class="mt-2">
                        <img id="image-preview" src="" alt="Preview" class="h-32 w-auto rounded-lg border-2 border-gray-200 hidden">
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Informasi Tambahan</h3>
                </div>

                <div class="md:col-span-2">
                    <label for="services" class="block text-sm font-medium text-gray-700 mb-2">Layanan</label>
                    <textarea name="services" id="services" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('services') border-red-500 @enderror" 
                              placeholder="Contoh: Peminjaman buku, Akses internet, Ruang baca, dll">{{ old('services') }}</textarea>
                    @error('services')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="facilities" class="block text-sm font-medium text-gray-700 mb-2">Fasilitas</label>
                    <textarea name="facilities" id="facilities" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('facilities') border-red-500 @enderror" 
                              placeholder="Contoh: Ruang baca, Komputer, WiFi, AC, dll">{{ old('facilities') }}</textarea>
                    @error('facilities')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="collection_info" class="block text-sm font-medium text-gray-700 mb-2">Informasi Koleksi</label>
                    <textarea name="collection_info" id="collection_info" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('collection_info') border-red-500 @enderror" 
                              placeholder="Contoh: Jumlah buku, Jenis koleksi, dll">{{ old('collection_info') }}</textarea>
                    @error('collection_info')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="rules" class="block text-sm font-medium text-gray-700 mb-2">Peraturan</label>
                    <textarea name="rules" id="rules" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('rules') border-red-500 @enderror" 
                              placeholder="Contoh: Dilarang makan di dalam, Wajib menjaga ketenangan, dll">{{ old('rules') }}</textarea>
                    @error('rules')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="membership_info" class="block text-sm font-medium text-gray-700 mb-2">Informasi Keanggotaan</label>
                    <textarea name="membership_info" id="membership_info" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('membership_info') border-red-500 @enderror" 
                              placeholder="Contoh: Syarat keanggotaan, Prosedur pendaftaran, dll">{{ old('membership_info') }}</textarea>
                    @error('membership_info')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} 
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Aktif
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('admin.libraries.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection



