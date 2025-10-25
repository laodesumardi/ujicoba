@extends('layouts.admin')

@section('title', 'Detail Perpustakaan')
@section('page-title', 'Detail Perpustakaan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Detail Perpustakaan</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $library->name }}</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('admin.libraries.edit', $library) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
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
        
        <div class="p-6 space-y-8">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perpustakaan</label>
                                <p class="text-sm text-gray-900">{{ $library->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                @if($library->is_active)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($library->description)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <p class="text-sm text-gray-900">{{ $library->description }}</p>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                <p class="text-sm text-gray-900">{{ $library->location ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                                <p class="text-sm text-gray-900">{{ $library->phone ?? '-' }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-sm text-gray-900">{{ $library->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Media & Gambar</h3>
                    
                    <div class="space-y-6">
                        @if($library->logo)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                            <div class="text-center">
                                <img src="{{ $library->logo_url }}" alt="Logo" class="mx-auto h-24 w-24 rounded-lg object-cover border border-gray-200">
                            </div>
                        </div>
                        @endif

                        @if($library->banner_image)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Banner</label>
                            <div class="text-center">
                                <img src="{{ $library->banner_image_url }}" alt="Banner" class="mx-auto h-24 w-24 rounded-lg object-cover border border-gray-200">
                            </div>
                        </div>
                        @endif

                        @if($library->organization_chart)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Struktur Organisasi</label>
                            <div class="text-center">
                                <img src="{{ $library->organization_chart_url }}" alt="Struktur Organisasi" class="mx-auto h-24 w-24 rounded-lg object-cover border border-gray-200">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Vision & Mission -->
            @if($library->vision || $library->mission)
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Visi & Misi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($library->vision)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Visi</label>
                        <p class="text-sm text-gray-900">{{ $library->vision }}</p>
                    </div>
                    @endif
                    @if($library->mission)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Misi</label>
                        <p class="text-sm text-gray-900">{{ $library->mission }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Services & Facilities -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Layanan & Fasilitas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($library->services)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Layanan Perpustakaan</label>
                        <ul class="text-sm text-gray-900 space-y-1">
                            @foreach($library->getFormattedServices() as $service)
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $service }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($library->facilities)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fasilitas Perpustakaan</label>
                        <ul class="text-sm text-gray-900 space-y-1">
                            @foreach($library->getFormattedFacilities() as $facility)
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $facility }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Additional Information -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($library->opening_hours)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional</label>
                        <div class="text-sm text-gray-900 whitespace-pre-line">{{ $library->opening_hours }}</div>
                    </div>
                    @endif

                    @if($library->rules)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tata Tertib</label>
                        <ul class="text-sm text-gray-900 space-y-1">
                            @foreach($library->getFormattedRules() as $rule)
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $rule }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Librarian Information -->
            @if($library->librarian_name)
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pustakawan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pustakawan</label>
                        <p class="text-sm text-gray-900">{{ $library->librarian_name }}</p>
                    </div>
                    @if($library->librarian_phone)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <p class="text-sm text-gray-900">{{ $library->librarian_phone }}</p>
                    </div>
                    @endif
                    @if($library->librarian_email)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p class="text-sm text-gray-900">{{ $library->librarian_email }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Collection & Membership Info -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Koleksi & Keanggotaan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($library->collection_info)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Informasi Koleksi</label>
                        <div class="text-sm text-gray-900 whitespace-pre-line">{{ $library->collection_info }}</div>
                    </div>
                    @endif

                    @if($library->membership_info)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Informasi Keanggotaan</label>
                        <div class="text-sm text-gray-900 whitespace-pre-line">{{ $library->membership_info }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Organization Chart -->
            @if($library->organization_chart)
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Struktur Organisasi</h3>
                <div class="text-center">
                    <img src="{{ $library->organization_chart_url }}" 
                         alt="Struktur Organisasi" 
                         class="mx-auto max-w-full h-auto rounded-lg border border-gray-200" 
                         style="max-height: 400px;">
                </div>
            </div>
            @endif

            <!-- Gallery -->
            @if($library->gallery_images && count($library->gallery_images) > 0)
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Galeri Foto</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($library->gallery_images_urls as $index => $imageUrl)
                    <div class="aspect-square overflow-hidden rounded-lg border border-gray-200">
                        <img src="{{ $imageUrl }}" 
                             alt="Galeri {{ $index + 1 }}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                             onclick="openImageModal('{{ $imageUrl }}', 'Galeri {{ $index + 1 }}')">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- System Information -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Sistem</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat</label>
                        <p class="text-sm text-gray-900">{{ $library->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Diperbarui</label>
                        <p class="text-sm text-gray-900">{{ $library->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
function openImageModal(src, alt) {
    document.getElementById('modalImage').src = src;
    document.getElementById('modalImage').alt = alt;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection