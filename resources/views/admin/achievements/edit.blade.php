@extends('layouts.admin')

@section('title', 'Edit Prestasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Edit Prestasi</h1>
                <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Prestasi</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.achievements.update', $achievement) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="font-weight-bold">Judul Prestasi <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                           value="{{ old('title', $achievement->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description" class="font-weight-bold">Deskripsi</label>
                                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $achievement->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="category" class="font-weight-bold">Kategori <span class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="academic" {{ old('category', $achievement->category) == 'academic' ? 'selected' : '' }}>Akademik</option>
                                        <option value="sports" {{ old('category', $achievement->category) == 'sports' ? 'selected' : '' }}>Olahraga</option>
                                        <option value="arts" {{ old('category', $achievement->category) == 'arts' ? 'selected' : '' }}>Seni & Budaya</option>
                                        <option value="science" {{ old('category', $achievement->category) == 'science' ? 'selected' : '' }}>Sains & Teknologi</option>
                                        <option value="leadership" {{ old('category', $achievement->category) == 'leadership' ? 'selected' : '' }}>Kepemimpinan</option>
                                        <option value="community" {{ old('category', $achievement->category) == 'community' ? 'selected' : '' }}>Pengabdian Masyarakat</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="level" class="font-weight-bold">Level <span class="text-danger">*</span></label>
                                    <select name="level" id="level" class="form-control @error('level') is-invalid @enderror" required>
                                        <option value="">Pilih Level</option>
                                        <option value="school" {{ old('level', $achievement->level) == 'school' ? 'selected' : '' }}>Sekolah</option>
                                        <option value="district" {{ old('level', $achievement->level) == 'district' ? 'selected' : '' }}>Kecamatan</option>
                                        <option value="provincial" {{ old('level', $achievement->level) == 'provincial' ? 'selected' : '' }}>Provinsi</option>
                                        <option value="national" {{ old('level', $achievement->level) == 'national' ? 'selected' : '' }}>Nasional</option>
                                        <option value="international" {{ old('level', $achievement->level) == 'international' ? 'selected' : '' }}>Internasional</option>
                                    </select>
                                    @error('level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="year" class="font-weight-bold">Tahun <span class="text-danger">*</span></label>
                                    <input type="text" name="year" id="year" class="form-control @error('year') is-invalid @enderror" 
                                           value="{{ old('year', $achievement->year) }}" maxlength="4" required>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Student Information -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_name" class="font-weight-bold">Nama Siswa</label>
                                    <input type="text" name="student_name" id="student_name" class="form-control @error('student_name') is-invalid @enderror" 
                                           value="{{ old('student_name', $achievement->student_name) }}">
                                    @error('student_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="student_class" class="font-weight-bold">Kelas</label>
                                    <input type="text" name="student_class" id="student_class" class="form-control @error('student_class') is-invalid @enderror" 
                                           value="{{ old('student_class', $achievement->student_class) }}">
                                    @error('student_class')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="teacher_name" class="font-weight-bold">Nama Guru Pembimbing</label>
                                    <input type="text" name="teacher_name" id="teacher_name" class="form-control @error('teacher_name') is-invalid @enderror" 
                                           value="{{ old('teacher_name', $achievement->teacher_name) }}">
                                    @error('teacher_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="position" class="font-weight-bold">Posisi/Peringkat</label>
                                    <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror" 
                                           value="{{ old('position', $achievement->position) }}" placeholder="Contoh: Juara 1, Juara 2, Peserta">
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="event_name" class="font-weight-bold">Nama Event/Lomba</label>
                                    <input type="text" name="event_name" id="event_name" class="form-control @error('event_name') is-invalid @enderror" 
                                           value="{{ old('event_name', $achievement->event_name) }}">
                                    @error('event_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="organizer" class="font-weight-bold">Penyelenggara</label>
                                    <input type="text" name="organizer" id="organizer" class="form-control @error('organizer') is-invalid @enderror" 
                                           value="{{ old('organizer', $achievement->organizer) }}">
                                    @error('organizer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- File Uploads -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="certificate_image" class="font-weight-bold">Foto Sertifikat</label>
                                    @if($achievement->certificate_image)
                                        <div class="mb-2">
                                            <img src="{{ $achievement->certificate_image_url }}" alt="Current Certificate" 
                                                 class="img-thumbnail" style="max-width: 200px;">
                                            <p class="text-muted small">Sertifikat saat ini</p>
                                        </div>
                                    @endif
                                    <input type="file" name="certificate_image" id="certificate_image" accept="image/*" 
                                           class="form-control @error('certificate_image') is-invalid @enderror">
                                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                    @error('certificate_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo" class="font-weight-bold">Foto Dokumentasi</label>
                                    @if($achievement->photo)
                                        <div class="mb-2">
                                            <img src="{{ $achievement->photo_url }}" alt="Current Photo" 
                                                 class="img-thumbnail" style="max-width: 200px;">
                                            <p class="text-muted small">Foto saat ini</p>
                                        </div>
                                    @endif
                                    <input type="file" name="photo" id="photo" accept="image/*" 
                                           class="form-control @error('photo') is-invalid @enderror">
                                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_order" class="font-weight-bold">Urutan Tampil</label>
                                    <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                                           value="{{ old('sort_order', $achievement->sort_order) }}" min="0">
                                    <small class="form-text text-muted">Angka lebih kecil akan ditampilkan lebih dulu</small>
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" 
                                               {{ old('is_featured', $achievement->is_featured) ? 'checked' : '' }}>
                                        <label for="is_featured" class="form-check-label font-weight-bold">
                                            Tampilkan di Halaman Utama
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_public" id="is_public" class="form-check-input" 
                                               {{ old('is_public', $achievement->is_public) ? 'checked' : '' }}>
                                        <label for="is_public" class="form-check-label font-weight-bold">
                                            Tampilkan untuk Umum
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Update Prestasi
                            </button>
                            <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

