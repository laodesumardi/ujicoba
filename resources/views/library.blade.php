@extends('layouts.app')

@section('title', 'Perpustakaan')

@section('content')
<div class="min-h-screen bg-gray-50">
    @if($library)
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="relative container mx-auto px-4 py-16">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $library->name }}</h1>
                    <p class="text-xl text-blue-100 mb-6">{{ $library->description }}</p>
                    <div class="flex flex-wrap justify-center gap-4 text-sm">
                        @if($library->location)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $library->location }}
                            </div>
                        @endif
                        @if($library->phone)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                                {{ $library->phone }}
                            </div>
                        @endif
                        @if($library->email)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                {{ $library->email }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-6xl mx-auto">
                <!-- Vision & Mission Section -->
                @if($library->vision || $library->mission)
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Visi & Misi Perpustakaan</h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        @if($library->vision)
                        <div>
                            <h3 class="text-xl font-semibold text-blue-600 mb-4">Visi</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $library->vision }}</p>
                        </div>
                        @endif
                        @if($library->mission)
                        <div>
                            <h3 class="text-xl font-semibold text-blue-600 mb-4">Misi</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $library->mission }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Organization Chart Section -->
                @if($library->organization_chart)
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Struktur Organisasi Perpustakaan</h2>
                    <div class="text-center">
                        <img src="{{ $library->organization_chart_url }}" 
                             alt="Struktur Organisasi Perpustakaan" 
                             class="w-full max-w-4xl mx-auto rounded-lg border border-gray-200 object-contain" 
                             loading="lazy" 
                             onerror="this.src='{{ asset('images/default-struktur.png') }}'; this.alt='Gambar tidak tersedia';">
                        <p class="text-gray-500 mt-4">Struktur Organisasi Perpustakaan {{ $library->name }}</p>
                    </div>
                </div>
                @endif

                <!-- Services & Facilities -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <!-- Services -->
                    @if($library->services)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Layanan Perpustakaan</h3>
                        <ul class="space-y-3">
                            @foreach($library->getFormattedServices() as $service)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ $service }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Facilities -->
                    @if($library->facilities)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Fasilitas Perpustakaan</h3>
                        <ul class="space-y-3">
                            @foreach($library->getFormattedFacilities() as $facility)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ $facility }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <!-- Opening Hours & Rules -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <!-- Opening Hours -->
                    @if($library->opening_hours)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Jam Operasional</h3>
                        <div class="text-gray-700">
                            {!! $library->getFormattedOpeningHours() !!}
                        </div>
                    </div>
                    @endif

                    <!-- Rules -->
                    @if($library->rules)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Tata Tertib Perpustakaan</h3>
                        <ul class="space-y-3">
                            @foreach($library->getFormattedRules() as $rule)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ $rule }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <!-- Librarian Info -->
                @if($library->librarian_name)
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Informasi Pustakawan</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Nama Pustakawan</h4>
                            <p class="text-gray-700">{{ $library->librarian_name }}</p>
                        </div>
                        @if($library->librarian_phone)
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Telepon</h4>
                            <p class="text-gray-700">{{ $library->librarian_phone }}</p>
                        </div>
                        @endif
                        @if($library->librarian_email)
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Email</h4>
                            <p class="text-gray-700">{{ $library->librarian_email }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Collection & Membership Info -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    @if($library->collection_info)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Informasi Koleksi</h3>
                        <div class="text-gray-700">
                            {!! nl2br($library->collection_info) !!}
                        </div>
                    </div>
                    @endif

                    @if($library->membership_info)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Informasi Keanggotaan</h3>
                        <div class="text-gray-700">
                            {!! nl2br($library->membership_info) !!}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Gallery Section -->
                @if($library->gallery_images && count($library->gallery_images) > 0)
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Galeri Perpustakaan</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($library->gallery_images_urls as $index => $imageUrl)
                        <div class="aspect-square overflow-hidden rounded-lg">
                            <img src="{{ $imageUrl }}" 
                                 alt="Galeri Perpustakaan {{ $index + 1 }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                 onclick="openImageModal('{{ $imageUrl }}', 'Galeri Perpustakaan {{ $index + 1 }}')">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    @else
        <!-- No Library Found -->
        <div class="min-h-screen flex items-center justify-center">
            <div class="text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Perpustakaan Tidak Ditemukan</h2>
                <p class="mt-2 text-gray-600">Informasi perpustakaan belum tersedia.</p>
            </div>
        </div>
    @endif
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
