@extends('layouts.student')

@section('title', 'Forum Diskusi')
@section('page-title', 'Forum Diskusi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Forum Diskusi</h1>
                <p class="text-gray-600 mt-1">Diskusi dengan teman sekelas dan guru</p>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
            <button class="flex-1 py-2 px-4 text-sm font-medium rounded-md bg-white text-gray-900 shadow-sm">
                Semua Forum
            </button>
            <button class="flex-1 py-2 px-4 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">
                Pinned
            </button>
            <button class="flex-1 py-2 px-4 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">
                Terbaru
            </button>
            <button class="flex-1 py-2 px-4 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">
                Populer
            </button>
        </div>
    </div>

    <!-- Forums List -->
    @if($forums->count() > 0)
        <div class="space-y-4">
            @foreach($forums as $forum)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $forum->title }}</h3>
                                @if($forum->is_pinned)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-thumbtack mr-1"></i>
                                        Pinned
                                    </span>
                                @endif
                                @if($forum->is_locked)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-lock mr-1"></i>
                                        Locked
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-2">{{ $forum->course->title }} • {{ $forum->course->code }}</p>
                            <p class="text-gray-700 mb-4">{{ Str::limit($forum->description, 150) }}</p>
                            
                            <div class="flex items-center space-x-6 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2"></i>
                                    {{ $forum->author->name }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-comments mr-2"></i>
                                    {{ $forum->replies_count }} balasan
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $forum->last_activity->diffForHumans() }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-tag mr-2"></i>
                                    {{ ucfirst($forum->type) }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end space-y-2">
                            @if($forum->latestReply)
                            <div class="text-right">
                                <p class="text-xs text-gray-500">Balasan terakhir</p>
                                <p class="text-sm font-medium text-gray-900">{{ $forum->latestReply->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $forum->latestReply->created_at->diffForHumans() }}</p>
                            </div>
                            @endif
                            
                            <a href="{{ route('student.forums.show', $forum) }}" 
                               class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                Lihat Diskusi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $forums->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
            <i class="fas fa-comments text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada forum diskusi</h3>
            <p class="text-gray-600 mb-6">Forum diskusi akan muncul setelah Anda mendaftar ke kelas dan guru membuat forum.</p>
            <a href="{{ route('student.courses.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                Lihat Kelas Tersedia
            </a>
        </div>
    @endif
</div>
@endsection
