@extends('layouts.admin')

@section('title', 'Tambah Visi & Misi Sekolah')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Visi & Misi Sekolah</h1>
                <p class="text-gray-600 mt-1">Buat visi dan misi baru untuk sekolah</p>
            </div>
            <a href="{{ route('admin.vision-missions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <form action="{{ route('admin.vision-missions.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                
                <!-- Images (Upload Only) -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-image text-pink-600 mr-3"></i>
                        Unggah Gambar Visi & Misi
                    </h3>
                    <p class="text-xs text-gray-500 mb-4">Format: JPG, PNG, GIF, WebP. Maks 5MB per gambar.</p>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <label for="image_one" class="block text-sm font-medium text-gray-700 mb-2">Gambar 1</label>
                            <input type="file" id="image_one" name="image_one" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_one') border-red-500 @enderror">
                            @error('image_one')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <label for="image_one_name" class="block text-xs font-medium text-gray-600 mt-3 mb-1">Nama Gambar 1 (opsional)</label>
                            <input type="text" id="image_one_name" name="image_one_name" value="{{ old('image_one_name') }}" placeholder="Contoh: Upacara Bendera" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_one_name') border-red-500 @enderror">
                            @error('image_one_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="image_two" class="block text-sm font-medium text-gray-700 mb-2">Gambar 2</label>
                            <input type="file" id="image_two" name="image_two" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_two') border-red-500 @enderror">
                            @error('image_two')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <label for="image_two_name" class="block text-xs font-medium text-gray-600 mt-3 mb-1">Nama Gambar 2 (opsional)</label>
                            <input type="text" id="image_two_name" name="image_two_name" value="{{ old('image_two_name') }}" placeholder="Contoh: Kegiatan Pramuka" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_two_name') border-red-500 @enderror">
                            @error('image_two_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="image_three" class="block text-sm font-medium text-gray-700 mb-2">Gambar 3</label>
                            <input type="file" id="image_three" name="image_three" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_three') border-red-500 @enderror">
                            @error('image_three')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <label for="image_three_name" class="block text-xs font-medium text-gray-600 mt-3 mb-1">Nama Gambar 3 (opsional)</label>
                            <input type="text" id="image_three_name" name="image_three_name" value="{{ old('image_three_name') }}" placeholder="Contoh: Kegiatan Olahraga" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_three_name') border-red-500 @enderror">
                            @error('image_three_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>



                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-8">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('admin.vision-missions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Visi & Misi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


