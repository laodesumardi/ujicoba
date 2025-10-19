@extends('layouts.admin')

@section('title', 'Detail Sambutan Kepala Sekolah')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Detail Sambutan Kepala Sekolah</h4>
                    <p class="text-muted mb-0">Informasi lengkap sambutan kepala sekolah</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.headmaster-greetings.index') }}">Sambutan Kepala Sekolah</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Detail Sambutan Kepala Sekolah</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.headmaster-greetings.edit', $headmasterGreeting) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="{{ route('admin.headmaster-greetings.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                @if($headmasterGreeting->photo_url)
                                    <img src="{{ $headmasterGreeting->photo_url }}" alt="{{ $headmasterGreeting->headmaster_name }}" 
                                         class="img-fluid rounded-circle shadow" style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto shadow" 
                                         style="width: 200px; height: 200px;">
                                        <i class="fas fa-user-tie fa-4x text-muted"></i>
                                    </div>
                                @endif
                                <h4 class="mt-3 mb-1">{{ $headmasterGreeting->headmaster_name }}</h4>
                                <p class="text-muted mb-0">Kepala Sekolah</p>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-2">Status</h6>
                                        @if($headmasterGreeting->is_active)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Aktif - Ditampilkan di halaman utama
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-pause-circle me-1"></i>Tidak Aktif - Tidak ditampilkan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-2">Foto</h6>
                                        @if($headmasterGreeting->photo_url)
                                            <span class="badge bg-info">
                                                <i class="fas fa-check me-1"></i>Ada Foto
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Tidak Ada Foto
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-2">Tanggal Dibuat</h6>
                                        <p class="text-muted mb-1">{{ $headmasterGreeting->created_at->format('d F Y') }}</p>
                                        <small class="text-muted">{{ $headmasterGreeting->created_at->format('H:i') }}</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-2">Terakhir Diperbarui</h6>
                                        <p class="text-muted mb-1">{{ $headmasterGreeting->updated_at->format('d F Y') }}</p>
                                        <small class="text-muted">{{ $headmasterGreeting->updated_at->format('H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="mb-4">
                        <h5 class="text-primary mb-3">Sambutan Kepala Sekolah</h5>
                        <div class="bg-light p-4 rounded">
                            <div class="text-justify" style="line-height: 1.8;">
                                {!! nl2br(e($headmasterGreeting->greeting_message)) !!}
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.headmaster-greetings.edit', $headmasterGreeting) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Sambutan
                        </a>
                        <a href="{{ route('admin.headmaster-greetings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                        <form action="{{ route('admin.headmaster-greetings.destroy', $headmasterGreeting) }}" 
                              method="POST" class="d-inline" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus sambutan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
