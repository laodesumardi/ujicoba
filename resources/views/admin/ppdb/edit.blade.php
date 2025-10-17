@extends('layouts.admin')

@section('title', 'Edit Informasi PPDB')
@section('page-title', 'Edit Informasi PPDB')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold text-primary-900 mb-6">Edit Informasi PPDB</h2>

                <form method="POST" action="{{ route('admin.ppdb.update', $ppdb) }}">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul PPDB *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $ppdb->title) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                <textarea name="description" id="description" rows="4" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror">{{ old('description', $ppdb->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Registration Period -->
                            <div>
                                <label for="registration_start" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai Pendaftaran</label>
                                <input type="date" name="registration_start" id="registration_start" value="{{ old('registration_start', $ppdb->registration_start?->format('Y-m-d')) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('registration_start') border-red-500 @enderror">
                                @error('registration_start')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="registration_end" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai Pendaftaran</label>
                                <input type="date" name="registration_end" id="registration_end" value="{{ old('registration_end', $ppdb->registration_end?->format('Y-m-d')) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('registration_end') border-red-500 @enderror">
                                @error('registration_end')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quota -->
                            <div>
                                <label for="quota" class="block text-sm font-medium text-gray-700 mb-2">Kuota Penerimaan</label>
                                <input type="number" name="quota" id="quota" value="{{ old('quota', $ppdb->quota) }}" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('quota') border-red-500 @enderror">
                                @error('quota')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Is Active -->
                            <div class="flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $ppdb->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm font-medium text-gray-900">
                                    Aktifkan PPDB
                                </label>
                                @error('is_active')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Content Sections -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Konten PPDB</h3>
                        <div class="space-y-6">
                            <!-- Requirements -->
                            <div>
                                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">Persyaratan Pendaftaran</label>
                                <textarea name="requirements" id="requirements" rows="6" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('requirements') border-red-500 @enderror" 
                                          placeholder="Masukkan persyaratan pendaftaran...">{{ old('requirements', $ppdb->requirements) }}</textarea>
                                @error('requirements')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Schedule -->
                            <div>
                                <label for="schedule" class="block text-sm font-medium text-gray-700 mb-2">Jadwal Penting</label>
                                <textarea name="schedule" id="schedule" rows="6" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('schedule') border-red-500 @enderror" 
                                          placeholder="Masukkan jadwal penting...">{{ old('schedule', $ppdb->schedule) }}</textarea>
                                @error('schedule')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Technical Guide -->
                            <div>
                                <label for="technical_guide" class="block text-sm font-medium text-gray-700 mb-2">Petunjuk Teknis</label>
                                <textarea name="technical_guide" id="technical_guide" rows="6" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('technical_guide') border-red-500 @enderror" 
                                          placeholder="Masukkan petunjuk teknis...">{{ old('technical_guide', $ppdb->technical_guide) }}</textarea>
                                @error('technical_guide')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- FAQ -->
                            <div>
                                <label for="faq" class="block text-sm font-medium text-gray-700 mb-2">Frequently Asked Questions (FAQ)</label>
                                <textarea name="faq" id="faq" rows="6" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('faq') border-red-500 @enderror" 
                                          placeholder="Masukkan FAQ...">{{ old('faq', $ppdb->faq) }}</textarea>
                                @error('faq')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Contact Person -->
                            <div>
                                <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-2">Nama Panitia</label>
                                <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $ppdb->contact_person) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('contact_person') border-red-500 @enderror">
                                @error('contact_person')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact Phone -->
                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="tel" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $ppdb->contact_phone) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('contact_phone') border-red-500 @enderror">
                                @error('contact_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact Email -->
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $ppdb->contact_email) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('contact_email') border-red-500 @enderror">
                                @error('contact_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Registration Link -->
                            <div>
                                <label for="registration_link" class="block text-sm font-medium text-gray-700 mb-2">Link Formulir Online (Opsional)</label>
                                <input type="url" name="registration_link" id="registration_link" value="{{ old('registration_link', $ppdb->registration_link) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('registration_link') border-red-500 @enderror" 
                                       placeholder="https://example.com/form">
                                @error('registration_link')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.ppdb.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700">
                            Update Informasi PPDB
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
