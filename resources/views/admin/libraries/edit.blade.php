@extends('layouts.admin')

@section('title', 'Edit Perpustakaan')
@section('page-title', 'Edit Perpustakaan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Edit Perpustakaan</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $library->name }}</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('admin.libraries.show', $library) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat
                    </a>
                    <a href="{{ route('admin.libraries.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
        
        <form action="{{ route('admin.libraries.update', $library) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-8">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Perpustakaan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $library->name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-300 @enderror"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                <textarea id="description" 
                                          name="description" 
                                          rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-300 @enderror">{{ old('description', $library->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                                    <input type="text" 
                                           id="location" 
                                           name="location" 
                                           value="{{ old('location', $library->location) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('location') border-red-300 @enderror">
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                                    <input type="text" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', $library->phone) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-300 @enderror">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $library->email) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-300 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Media & Gambar</h3>
                        
                        <div class="space-y-6">
                            @if($library->logo)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Logo Saat Ini</label>
                                <div class="text-center">
                                    <img src="{{ $library->logo_url }}" alt="Logo" class="mx-auto h-16 w-16 rounded-lg object-cover border border-gray-200">
                                </div>
                            </div>
                            @endif
                            
                            <div>
                                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo Perpustakaan</label>
                                <input type="file" 
                                       id="logo" 
                                       name="logo" 
                                       accept="image/*" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('logo') border-red-300 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 1MB</p>
                                @error('logo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            @if($library->banner_image)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Banner Saat Ini</label>
                                <div class="text-center">
                                    <img src="{{ $library->banner_image_url }}" alt="Banner" class="mx-auto h-16 w-16 rounded-lg object-cover border border-gray-200">
                                </div>
                            </div>
                            @endif

                            <div>
                                <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                                <input type="file" 
                                       id="banner_image" 
                                       name="banner_image" 
                                       accept="image/*" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('banner_image') border-red-300 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                                @error('banner_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            @if($library->organization_chart)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Struktur Organisasi Saat Ini</label>
                                <div class="text-center">
                                    <img src="{{ $library->organization_chart_url }}" alt="Struktur Organisasi" class="mx-auto h-16 w-16 rounded-lg object-cover border border-gray-200">
                                </div>
                            </div>
                            @endif

                            <div>
                                <label for="organization_chart" class="block text-sm font-medium text-gray-700 mb-2">Struktur Organisasi</label>
                                <input type="file" 
                                       id="organization_chart" 
                                       name="organization_chart" 
                                       accept="image/*" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('organization_chart') border-red-300 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                                @error('organization_chart')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            @if($library->gallery_images && count($library->gallery_images) > 0)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Saat Ini</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($library->gallery_images_urls as $index => $imageUrl)
                                    <div class="aspect-square overflow-hidden rounded-lg border border-gray-200">
                                        <img src="{{ $imageUrl }}" alt="Galeri {{ $index + 1 }}" class="w-full h-full object-cover">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div>
                                <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-2">Galeri Foto</label>
                                <input type="file" 
                                       id="gallery_images" 
                                       name="gallery_images[]" 
                                       accept="image/*" 
                                       multiple 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('gallery_images.*') border-red-300 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Pilih beberapa foto. Format: JPG, PNG, GIF. Maksimal 2MB per foto</p>
                                @error('gallery_images.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vision & Mission -->
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Visi & Misi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="vision" class="block text-sm font-medium text-gray-700 mb-2">Visi</label>
                            <textarea id="vision" 
                                      name="vision" 
                                      rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('vision') border-red-300 @enderror">{{ old('vision', $library->vision) }}</textarea>
                            @error('vision')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="mission" class="block text-sm font-medium text-gray-700 mb-2">Misi</label>
                            <textarea id="mission" 
                                      name="mission" 
                                      rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('mission') border-red-300 @enderror">{{ old('mission', $library->mission) }}</textarea>
                            @error('mission')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Services & Facilities -->
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Layanan & Fasilitas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="services" class="block text-sm font-medium text-gray-700 mb-2">Layanan Perpustakaan</label>
                            <textarea id="services" 
                                      name="services" 
                                      rows="4" 
                                      placeholder="Satu layanan per baris" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('services') border-red-300 @enderror">{{ old('services', $library->services) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Satu layanan per baris</p>
                            @error('services')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="facilities" class="block text-sm font-medium text-gray-700 mb-2">Fasilitas Perpustakaan</label>
                            <textarea id="facilities" 
                                      name="facilities" 
                                      rows="4" 
                                      placeholder="Satu fasilitas per baris" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('facilities') border-red-300 @enderror">{{ old('facilities', $library->facilities) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Satu fasilitas per baris</p>
                            @error('facilities')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="opening_hours" class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional</label>
                            <textarea id="opening_hours" 
                                      name="opening_hours" 
                                      rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('opening_hours') border-red-300 @enderror">{{ old('opening_hours', $library->opening_hours) }}</textarea>
                            @error('opening_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="rules" class="block text-sm font-medium text-gray-700 mb-2">Tata Tertib</label>
                            <textarea id="rules" 
                                      name="rules" 
                                      rows="3" 
                                      placeholder="Satu aturan per baris" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('rules') border-red-300 @enderror">{{ old('rules', $library->rules) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Satu aturan per baris</p>
                            @error('rules')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Librarian Information -->
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pustakawan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="librarian_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pustakawan</label>
                            <input type="text" 
                                   id="librarian_name" 
                                   name="librarian_name" 
                                   value="{{ old('librarian_name', $library->librarian_name) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('librarian_name') border-red-300 @enderror">
                            @error('librarian_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="librarian_phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon Pustakawan</label>
                            <input type="text" 
                                   id="librarian_phone" 
                                   name="librarian_phone" 
                                   value="{{ old('librarian_phone', $library->librarian_phone) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('librarian_phone') border-red-300 @enderror">
                            @error('librarian_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="librarian_email" class="block text-sm font-medium text-gray-700 mb-2">Email Pustakawan</label>
                            <input type="email" 
                                   id="librarian_email" 
                                   name="librarian_email" 
                                   value="{{ old('librarian_email', $library->librarian_email) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('librarian_email') border-red-300 @enderror">
                            @error('librarian_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Collection & Membership Info -->
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Koleksi & Keanggotaan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="collection_info" class="block text-sm font-medium text-gray-700 mb-2">Informasi Koleksi</label>
                            <textarea id="collection_info" 
                                      name="collection_info" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('collection_info') border-red-300 @enderror">{{ old('collection_info', $library->collection_info) }}</textarea>
                            @error('collection_info')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="membership_info" class="block text-sm font-medium text-gray-700 mb-2">Informasi Keanggotaan</label>
                            <textarea id="membership_info" 
                                      name="membership_info" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('membership_info') border-red-300 @enderror">{{ old('membership_info', $library->membership_info) }}</textarea>
                            @error('membership_info')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="border-t border-gray-200 pt-8">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $library->is_active) ? 'checked' : '' }} 
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Aktif
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('admin.libraries.show', $library) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Lihat
                </a>
                <a href="{{ route('admin.libraries.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
