@extends('layouts.admin')

@section('title', 'Detail Dokumen')
@section('page-title', 'Detail Dokumen')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-primary-900">Detail Dokumen</h2>
                        <p class="text-gray-600 mt-1">{{ $document->title }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.documents.edit', $document) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Dokumen
                        </a>
                        <a href="{{ route('admin.documents.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Document Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dokumen</h3>
                        <dl class="divide-y divide-gray-200">
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Judul</dt>
                                <dd class="text-gray-900">{{ $document->title }}</dd>
                            </div>
                            @if($document->description)
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Deskripsi</dt>
                                <dd class="text-gray-900">{{ $document->description }}</dd>
                            </div>
                            @endif
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Kategori</dt>
                                <dd class="text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $document->category == 'surat_edaran' ? 'bg-blue-100 text-blue-800' : 
                                           ($document->category == 'formulir' ? 'bg-green-100 text-green-800' : 
                                           ($document->category == 'pedoman' ? 'bg-purple-100 text-purple-800' : 
                                           ($document->category == 'jadwal' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($document->category == 'kurikulum' ? 'bg-indigo-100 text-indigo-800' : 
                                           ($document->category == 'laporan' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))))) }}">
                                        {{ $document->category_label }}
                                    </span>
                                </dd>
                            </div>
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Tipe File</dt>
                                <dd class="text-gray-900">{{ $document->type_label }}</dd>
                            </div>
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Status</dt>
                                <dd class="text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $document->status === 'published' ? 'bg-green-100 text-green-800' : 
                                           ($document->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $document->status_label }}
                                    </span>
                                </dd>
                            </div>
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Unggulan</dt>
                                <dd class="text-gray-900">
                                    @if($document->is_featured)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            Unggulan
                                        </span>
                                    @else
                                        <span class="text-gray-500">Tidak</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Jumlah Download</dt>
                                <dd class="text-gray-900">{{ $document->download_count }} kali</dd>
                            </div>
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Ukuran File</dt>
                                <dd class="text-gray-900">{{ $document->file_size_formatted }}</dd>
                            </div>
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Dibuat</dt>
                                <dd class="text-gray-900">{{ $document->created_at->format('d M Y H:i') }}</dd>
                            </div>
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Diperbarui</dt>
                                <dd class="text-gray-900">{{ $document->updated_at->format('d M Y H:i') }}</dd>
                            </div>
                            @if($document->published_at)
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Dipublikasi</dt>
                                <dd class="text-gray-900">{{ $document->published_at->format('d M Y H:i') }}</dd>
                            </div>
                            @endif
                            @if($document->expires_at)
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Kedaluwarsa</dt>
                                <dd class="text-gray-900">{{ $document->expires_at->format('d M Y H:i') }}</dd>
                            </div>
                            @endif
                        </dl>

                        @if($document->tags && count($document->tags) > 0)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($document->tags as $tag)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $tag }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- File Preview -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">File Dokumen</h3>
                        <div class="border border-gray-200 rounded-lg p-6">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h4 class="mt-2 text-sm font-medium text-gray-900">{{ $document->file_name }}</h4>
                                <p class="mt-1 text-sm text-gray-500">{{ $document->file_size_formatted }}</p>
                                <div class="mt-4">
                                    <a href="{{ $document->file_url }}" target="_blank" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download File
                                    </a>
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




