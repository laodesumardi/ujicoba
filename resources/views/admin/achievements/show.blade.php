@extends('layouts.admin')

@section('title', 'Detail Prestasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Detail Prestasi</h3>
                        <div>
                            <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="200">Judul Prestasi</th>
                                    <td>{{ $achievement->title }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe</th>
                                    <td>
                                        <span class="badge badge-{{ $achievement->type == 'academic' ? 'primary' : 'success' }}">
                                            {{ $achievement->type_label }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Level</th>
                                    <td>{{ $achievement->level_label }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td>{{ $achievement->year }}</td>
                                </tr>
                                <tr>
                                    <th>Posisi/Juara</th>
                                    <td>{{ $achievement->position ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Peserta/Kelompok</th>
                                    <td>{{ $achievement->participant_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $achievement->is_active ? 'success' : 'secondary' }}">
                                            {{ $achievement->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                </tr>
                                @if($achievement->description)
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $achievement->description }}</td>
                                </tr>
                                @endif
                                @if($achievement->notes)
                                <tr>
                                    <th>Catatan</th>
                                    <td>{{ $achievement->notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Informasi Prestasi</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Dibuat:</strong> {{ $achievement->created_at->format('d M Y H:i') }}</p>
                                    <p><strong>Diupdate:</strong> {{ $achievement->updated_at->format('d M Y H:i') }}</p>
                                    
                                    <div class="mt-3">
                                        <h6>Statistik</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-calendar text-primary"></i> Tahun: {{ $achievement->year }}</li>
                                            <li><i class="fas fa-trophy text-warning"></i> Level: {{ $achievement->level_label }}</li>
                                            <li><i class="fas fa-tag text-info"></i> Tipe: {{ $achievement->type_label }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection