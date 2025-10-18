@extends('layouts.admin')

@section('title', 'Detail Prestasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Detail Prestasi</h1>
                <div>
                    <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-warning">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Prestasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold text-primary">{{ $achievement->title }}</h5>
                                    @if($achievement->event_name)
                                        <p class="text-muted">{{ $achievement->event_name }}</p>
                                    @endif
                                    
                                    @if($achievement->description)
                                        <div class="mt-3">
                                            <h6 class="font-weight-bold">Deskripsi:</h6>
                                            <p>{{ $achievement->description }}</p>
                                        </div>
                                    @endif

                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                            <h6 class="font-weight-bold">Kategori:</h6>
                                            <span class="badge badge-info">{{ $achievement->category_label }}</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <h6 class="font-weight-bold">Level:</h6>
                                            <span class="badge badge-secondary">{{ $achievement->level_label }}</span>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                            <h6 class="font-weight-bold">Tahun:</h6>
                                            <p>{{ $achievement->year }}</p>
                                        </div>
                                        @if($achievement->position)
                                            <div class="col-sm-6">
                                                <h6 class="font-weight-bold">Posisi:</h6>
                                                <span class="badge badge-success">{{ $achievement->position }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    @if($achievement->student_name)
                                        <h6 class="font-weight-bold">Siswa:</h6>
                                        <p>{{ $achievement->student_name }}</p>
                                        @if($achievement->student_class)
                                            <p class="text-muted">Kelas {{ $achievement->student_class }}</p>
                                        @endif
                                    @endif

                                    @if($achievement->teacher_name)
                                        <h6 class="font-weight-bold">Guru Pembimbing:</h6>
                                        <p>{{ $achievement->teacher_name }}</p>
                                    @endif

                                    @if($achievement->organizer)
                                        <h6 class="font-weight-bold">Penyelenggara:</h6>
                                        <p>{{ $achievement->organizer }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Status Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Featured:</span>
                                <span class="badge {{ $achievement->is_featured ? 'badge-warning' : 'badge-secondary' }}">
                                    {{ $achievement->is_featured ? 'Ya' : 'Tidak' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Public:</span>
                                <span class="badge {{ $achievement->is_public ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $achievement->is_public ? 'Ya' : 'Tidak' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Urutan:</span>
                                <span class="badge badge-info">{{ $achievement->sort_order }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Images -->
                    @if($achievement->photo || $achievement->certificate_image)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Dokumentasi</h6>
                            </div>
                            <div class="card-body">
                                @if($achievement->photo)
                                    <div class="mb-3">
                                        <h6 class="font-weight-bold">Foto Dokumentasi:</h6>
                                        <img src="{{ $achievement->photo_url }}" alt="Achievement Photo" 
                                             class="img-fluid rounded" style="max-width: 100%;">
                                    </div>
                                @endif

                                @if($achievement->certificate_image)
                                    <div>
                                        <h6 class="font-weight-bold">Sertifikat:</h6>
                                        <img src="{{ $achievement->certificate_image_url }}" alt="Certificate" 
                                             class="img-fluid rounded" style="max-width: 100%;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-warning">
                                    <i class="fas fa-edit mr-2"></i>Edit Prestasi
                                </a>
                                
                                <form action="{{ route('admin.achievements.toggle-featured', $achievement) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn {{ $achievement->is_featured ? 'btn-secondary' : 'btn-primary' }} w-100">
                                        <i class="fas fa-star mr-2"></i>
                                        {{ $achievement->is_featured ? 'Sembunyikan dari Featured' : 'Tampilkan di Featured' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus prestasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-trash mr-2"></i>Hapus Prestasi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

