@extends('layouts.admin')

@section('title', 'Edit Acara Kalender Akademik')
@section('page-title', 'Edit Acara Kalender Akademik')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-primary-900">Edit Acara Kalender Akademik</h2>
                        <p class="text-gray-600 mt-1">Edit acara: {{ $academicCalendar->title }}</p>
                    </div>
                    <a href="{{ route('admin.academic-calendar.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.academic-calendar.update', $academicCalendar) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul Acara <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title', $academicCalendar->title) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                                       placeholder="Masukkan judul acara" required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi
                                </label>
                                <textarea name="description" id="description" rows="4" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                                          placeholder="Masukkan deskripsi acara">{{ old('description', $academicCalendar->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $academicCalendar->start_date->format('Y-m-d')) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('start_date') border-red-500 @enderror" required>
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Selesai
                                </label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $academicCalendar->end_date ? $academicCalendar->end_date->format('Y-m-d') : '') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('end_date') border-red-500 @enderror">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Time -->
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Waktu Mulai
                                </label>
                                <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $academicCalendar->start_time ? $academicCalendar->start_time->format('H:i') : '') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('start_time') border-red-500 @enderror">
                                @error('start_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Time -->
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Waktu Selesai
                                </label>
                                <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $academicCalendar->end_time ? $academicCalendar->end_time->format('H:i') : '') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('end_time') border-red-500 @enderror">
                                @error('end_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Acara <span class="text-red-500">*</span>
                                </label>
                                <select name="type" id="type" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('type') border-red-500 @enderror" required>
                                    <option value="">Pilih jenis acara</option>
                                    <option value="semester" {{ old('type', $academicCalendar->type) == 'semester' ? 'selected' : '' }}>Semester</option>
                                    <option value="ujian" {{ old('type', $academicCalendar->type) == 'ujian' ? 'selected' : '' }}>Ujian</option>
                                    <option value="libur" {{ old('type', $academicCalendar->type) == 'libur' ? 'selected' : '' }}>Libur</option>
                                    <option value="hari_besar" {{ old('type', $academicCalendar->type) == 'hari_besar' ? 'selected' : '' }}>Hari Besar</option>
                                    <option value="kegiatan" {{ old('type', $academicCalendar->type) == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                    <option value="lainnya" {{ old('type', $academicCalendar->type) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Priority -->
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                                    Prioritas <span class="text-red-500">*</span>
                                </label>
                                <select name="priority" id="priority" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('priority') border-red-500 @enderror" required>
                                    <option value="">Pilih prioritas</option>
                                    <option value="low" {{ old('priority', $academicCalendar->priority) == 'low' ? 'selected' : '' }}>Rendah</option>
                                    <option value="medium" {{ old('priority', $academicCalendar->priority) == 'medium' ? 'selected' : '' }}>Sedang</option>
                                    <option value="high" {{ old('priority', $academicCalendar->priority) == 'high' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="critical" {{ old('priority', $academicCalendar->priority) == 'critical' ? 'selected' : '' }}>Kritis</option>
                                </select>
                                @error('priority')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lokasi
                                </label>
                                <input type="text" name="location" id="location" value="{{ old('location', $academicCalendar->location) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('location') border-red-500 @enderror"
                                       placeholder="Masukkan lokasi acara">
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Organizer -->
                            <div>
                                <label for="organizer" class="block text-sm font-medium text-gray-700 mb-2">
                                    Penyelenggara
                                </label>
                                <input type="text" name="organizer" id="organizer" value="{{ old('organizer', $academicCalendar->organizer) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('organizer') border-red-500 @enderror"
                                       placeholder="Masukkan penyelenggara acara">
                                @error('organizer')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Color -->
                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                                    Warna <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-4">
                                    <input type="color" name="color" id="color" value="{{ old('color', $academicCalendar->color) }}" 
                                           class="w-12 h-10 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('color') border-red-500 @enderror" required>
                                    <input type="text" name="color_text" id="color_text" value="{{ old('color', $academicCalendar->color) }}" 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('color') border-red-500 @enderror"
                                           placeholder="#3B82F6">
                                </div>
                                @error('color')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Catatan
                                </label>
                                <textarea name="notes" id="notes" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('notes') border-red-500 @enderror"
                                          placeholder="Masukkan catatan tambahan">{{ old('notes', $academicCalendar->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Checkboxes -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_all_day" id="is_all_day" value="1" {{ old('is_all_day', $academicCalendar->is_all_day) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_all_day" class="ml-2 block text-sm text-gray-900">
                                Sepanjang Hari
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public', $academicCalendar->is_public) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_public" class="ml-2 block text-sm text-gray-900">
                                Publik
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_downloadable" id="is_downloadable" value="1" {{ old('is_downloadable', $academicCalendar->is_downloadable) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_downloadable" class="ml-2 block text-sm text-gray-900">
                                Dapat Diunduh
                            </label>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mt-6" id="file-upload-section" style="display: {{ $academicCalendar->is_downloadable ? 'block' : 'none' }};">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                            File Dokumen
                        </label>
                        @if($academicCalendar->file_path)
                        <div class="mb-2">
                            <p class="text-sm text-gray-600">File saat ini: 
                                <a href="{{ $academicCalendar->file_url }}" target="_blank" class="text-primary-600 hover:text-primary-800">
                                    {{ basename($academicCalendar->file_path) }}
                                </a>
                            </p>
                        </div>
                        @endif
                        <input type="file" name="file" id="file" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 @error('file') border-red-500 @enderror"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX</p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('admin.academic-calendar.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-md text-sm font-medium transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Acara
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Color picker synchronization
document.getElementById('color').addEventListener('input', function() {
    document.getElementById('color_text').value = this.value;
});

document.getElementById('color_text').addEventListener('input', function() {
    if (this.value.match(/^#[0-9A-F]{6}$/i)) {
        document.getElementById('color').value = this.value;
    }
});

// Show/hide file upload based on downloadable checkbox
document.getElementById('is_downloadable').addEventListener('change', function() {
    const fileSection = document.getElementById('file-upload-section');
    if (this.checked) {
        fileSection.style.display = 'block';
    } else {
        fileSection.style.display = 'none';
    }
});

// Auto-fill end date when start date changes
document.getElementById('start_date').addEventListener('change', function() {
    const endDate = document.getElementById('end_date');
    if (!endDate.value) {
        endDate.value = this.value;
    }
});
</script>
@endsection
