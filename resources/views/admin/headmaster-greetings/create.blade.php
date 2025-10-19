@extends('layouts.admin')

@section('title', 'Tambah Sambutan Kepala Sekolah')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Tambah Sambutan Kepala Sekolah</h4>
                    <p class="text-muted mb-0">Buat sambutan kepala sekolah baru untuk halaman utama</p>
                </div>
                <a href="{{ route('admin.headmaster-greetings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Sambutan Kepala Sekolah</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.headmaster-greetings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="headmaster_name" class="form-label">
                                        Nama Kepala Sekolah <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('headmaster_name') is-invalid @enderror" 
                                           id="headmaster_name" name="headmaster_name" 
                                           value="{{ old('headmaster_name') }}" 
                                           placeholder="Masukkan nama lengkap kepala sekolah" required>
                                    @error('headmaster_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Foto Kepala Sekolah</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                           id="photo" name="photo" accept="image/*" onchange="previewImage(this)">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB.</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="greeting_message" class="form-label">
                                Sambutan Kepala Sekolah <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('greeting_message') is-invalid @enderror" 
                                      id="greeting_message" name="greeting_message" rows="8" 
                                      placeholder="Tuliskan sambutan kepala sekolah yang akan ditampilkan di halaman utama..." required>{{ old('greeting_message') }}</textarea>
                            @error('greeting_message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Tampilkan di halaman utama
                                </label>
                            </div>
                        </div>

                        <!-- Image Preview -->
                        <div class="mb-3" id="image-preview" style="display: none;">
                            <label class="form-label">Preview Foto:</label>
                            <div class="text-center">
                                <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.headmaster-greetings.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview-img');
    const previewContainer = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}
</script>
@endsection
