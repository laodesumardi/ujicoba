@extends('layouts.student')

@section('title', $forum->title)
@section('page-title', $forum->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Forum Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $forum->title }}</h1>
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
                <p class="text-gray-700 mb-4">{{ $forum->description }}</p>
                
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
                        {{ $forum->created_at->format('d M Y, H:i') }}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-tag mr-2"></i>
                        {{ ucfirst($forum->type) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forum Content -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-start space-x-4">
            <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center">
                <span class="text-white font-semibold text-sm">{{ substr($forum->author->name, 0, 1) }}</span>
            </div>
            <div class="flex-1">
                <div class="flex items-center space-x-2 mb-2">
                    <h3 class="font-semibold text-gray-900">{{ $forum->author->name }}</h3>
                    <span class="text-sm text-gray-500">{{ $forum->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="prose max-w-none">
                    {!! nl2br(e($forum->content)) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Replies Section -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Balasan ({{ $forum->replies_count }})</h2>
        
        @if($replies->count() > 0)
            <div class="space-y-4">
                @foreach($replies as $reply)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-xs">{{ substr($reply->user->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <h4 class="font-medium text-gray-900">{{ $reply->user->name }}</h4>
                                <span class="text-sm text-gray-500">{{ $reply->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="prose max-w-none">
                                {!! nl2br(e($reply->content)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $replies->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada balasan</h3>
                <p class="text-gray-600">Jadilah yang pertama membalas diskusi ini!</p>
            </div>
        @endif
    </div>

    <!-- Reply Form -->
    @if(!$forum->is_locked)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Kirim Balasan</h2>
        
        <form action="{{ route('student.forums.replies.store', $forum) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Balasan Anda <span class="text-red-500">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('content') border-red-500 @enderror"
                          placeholder="Tulis balasan Anda di sini..."
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('student.forums.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Kembali ke Forum
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors duration-200">
                    Kirim Balasan
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="text-center py-8">
            <i class="fas fa-lock text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Forum Dikunci</h3>
            <p class="text-gray-600">Forum ini dikunci oleh guru, tidak dapat membalas.</p>
        </div>
    </div>
    @endif
</div>
@endsection
