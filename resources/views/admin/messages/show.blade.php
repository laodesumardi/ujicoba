@extends('layouts.admin')

@section('title', 'Detail Pesan')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Detail Pesan</h1>
                    <p class="text-primary-100 mt-2">Lihat dan balas pesan dari pengunjung</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.messages.index') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-6 py-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Message Details -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <!-- Message Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-12 w-12">
                            <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                                <span class="text-lg font-medium text-primary-600">
                                    {{ strtoupper(substr($message->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $message->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $message->email }}</p>
                            @if($message->phone)
                            <p class="text-sm text-gray-600">{{ $message->phone }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $message->status_color === 'red' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $message->status_color === 'blue' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $message->status_color === 'green' ? 'bg-green-100 text-green-800' : '' }}">
                            {{ $message->status_label }}
                        </span>
                        <p class="text-sm text-gray-500 mt-1">{{ $message->created_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div class="px-6 py-6">
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Subjek</h4>
                    <p class="text-gray-700">{{ $message->subject }}</p>
                </div>

                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Pesan</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                    </div>
                </div>

                @if($message->admin_reply)
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Balasan Admin</h4>
                    <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-400">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $message->admin_reply }}</p>
                        <p class="text-sm text-gray-500 mt-2">Dibalas pada: {{ $message->replied_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Reply Form -->
        @if($message->status !== 'replied')
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Balas Pesan</h3>
            </div>
            
            <form action="{{ route('admin.messages.update', $message) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="admin_reply" class="block text-sm font-medium text-gray-700 mb-2">
                        Balasan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="admin_reply" 
                        id="admin_reply" 
                        rows="6" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('admin_reply') border-red-500 @enderror"
                        placeholder="Tulis balasan untuk {{ $message->name }}..."
                        required
                    >{{ old('admin_reply') }}</textarea>
                    @error('admin_reply')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        Kirim Balasan
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-green-800 font-medium">Pesan ini sudah dibalas</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

