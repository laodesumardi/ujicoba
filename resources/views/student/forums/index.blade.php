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
                <p class="text-gray-600 mt-1">Berpartisipasi dalam diskusi dengan guru dan teman sekelas</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $forums->total() }} Forum
                </span>
            </div>
        </div>
    </div>

    <!-- Forums List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Forum</h2>
        </div>
        
        @if($forums->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($forums as $forum)
                <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-comments text-primary-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">
                                    {{ $forum->title }}
                                </h3>
                                <div class="flex items-center space-x-2">
                                    @if($forum->is_pinned)
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-thumbtack mr-1"></i>Pinned
                                        </span>
                                    @endif
                                    @if($forum->is_locked)
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-lock mr-1"></i>Locked
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="text-gray-600 mt-2 line-clamp-2">
                                {{ $forum->description }}
                            </p>
                            
                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-user"></i>
                                        <span>{{ $forum->user->name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ $forum->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-comments"></i>
                                        <span>{{ $forum->replies_count ?? 0 }} balasan</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 bg-{{ $forum->type === 'general' ? 'blue' : ($forum->type === 'announcement' ? 'green' : 'purple') }}-100 text-{{ $forum->type === 'general' ? 'blue' : ($forum->type === 'announcement' ? 'green' : 'purple') }}-800 rounded-full text-xs font-medium">
                                        {{ $forum->type_label }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $forums->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-comments text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada forum</h3>
                <p class="text-gray-500">Guru belum membuat forum diskusi untuk kelas ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection