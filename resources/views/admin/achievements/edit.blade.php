@extends('layouts.admin')

@section('title', 'Edit Prestasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Prestasi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.achievements.update', $achievement) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Tipe Prestasi <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="academic" {{ old('type', $achievement->type) == 'academic' ? 'selected' : '' }}>Akademik</option>
                                        <option value="non_academic" {{ old('type', $achievement->type) == 'non_academic' ? 'selected' : '' }}>Non-Akademik</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level">Level <span class="text-danger">*</span></label>
                                    <select name="level" id="level" class="form-control @error('level') is-invalid @enderror" required>
                                        <option value="">Pilih Level</option>
                                        <option value="kabupaten" {{ old('level', $achievement->level) == 'kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                                        <option value="provinsi" {{ old('level', $achievement->level) == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                                        <option value="nasional" {{ old('level', $achievement->level) == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                        <option value="internasional" {{ old('level', $achievement->level) == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                    </select>
                                    @error('level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Judul Prestasi <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $achievement->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $achievement->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="year">Tahun <span class="text-danger">*</span></label>
                                    <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', $achievement->year) }}" min="2000" max="2030" required>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="position">Posisi/Juara</label>
                                    <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $achievement->position) }}" placeholder="Contoh: Juara 1, Juara 2, dll">
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="participant_name">Nama Peserta/Kelompok</label>
                                    <input type="text" name="participant_name" id="participant_name" class="form-control @error('participant_name') is-invalid @enderror" value="{{ old('participant_name', $achievement->participant_name) }}">
                                    @error('participant_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $achievement->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $achievement->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="form-check-label">Aktif</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection