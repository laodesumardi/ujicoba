@extends('layouts.admin')

@section('title', 'Edit Sambutan Kepala Sekolah')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-4 sm:px-6 py-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl sm:text-3xl font-bold">Edit Sambutan Kepala Sekolah</h1>
                    <p class="text-primary-100 mt-1 sm:mt-2">Perbarui informasi sambutan kepala sekolah yang akan ditampilkan di landing page</p>
                </div>
                <a href="{{ route('admin.headmaster-greetings.index') }}" class="bg-white text-primary-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Form Edit Sambutan</h3>
            </div>

            <div class="p-4 sm:p-6">
                <form action="{{ route('admin.headmaster-greetings.update', $headmasterGreeting) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Foto Kepala Sekolah -->
                        <div class="lg:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kepala Sekolah</label>
                            <div class="rounded-lg border-2 border-dashed border-gray-300 p-4 flex flex-col items-center justify-center bg-gray-50">
                                @if($headmasterGreeting->photo)
                                    <img id="photoPreview" 
                                         src="{{ route('image.serve.model', ['model' => 'headmaster-greeting', 'id' => $headmasterGreeting->id, 'field' => 'photo', 'v' => $headmasterGreeting->updated_at->timestamp]) }}" 
                                         alt="{{ $headmasterGreeting->headmaster_name }}" 
                                         class="w-48 h-48 object-cover rounded-lg mb-4 border border-gray-200"
                                         onerror="this.src='{{ asset('images/fallbacks/headmaster.png') }}'">
                                @else
                                    <img id="photoPreview" src="{{ asset('images/fallbacks/headmaster.png') }}" alt="Preview Foto" class="w-48 h-48 object-cover rounded-lg mb-4 border border-gray-200">
                                @endif

                                <input type="file" name="photo" id="photo" accept="image/*" class="mt-2">
                                @error('photo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Sambutan -->
                        <div class="lg:col-span-2">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Kepala Sekolah</label>
                                    <input type="text" name="headmaster_name" value="{{ old('headmaster_name', $headmasterGreeting->headmaster_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    @error('headmaster_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="is_active" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <option value="1" {{ old('is_active', $headmasterGreeting->is_active) ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active', $headmasterGreeting->is_active) ? '' : 'selected' }}>Tidak Aktif</option>
                                    </select>
                                    @error('is_active')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700">Sambutan</label>
                                <textarea name="greeting_message" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('greeting_message', $headmasterGreeting->greeting_message) }}</textarea>
                                @error('greeting_message')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6 flex items-center justify-end space-x-3">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.headmaster-greetings.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm bg-white hover:bg-gray-50">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview file lokal
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('photoPreview');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('photo').addEventListener('change', previewImage);
</script>
@endpush
