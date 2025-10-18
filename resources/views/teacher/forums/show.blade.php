@extends('layouts.teacher')

@section('title', $forum->title)
@section('page-title', $forum->title)

@section('content')
<div class="space-y-6">
    <!-- Forum Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $forum->title }}</h1>
                    @if($forum->is_pinned)
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                            <i class="fas fa-thumbtack mr-1"></i>
                            Dipasang
                        </span>
                    @endif
                    @if($forum->is_locked)
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">
                            <i class="fas fa-lock mr-1"></i>
                            Dikunci
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-comments mr-1"></i>
                            Aktif
                        </span>
                    @endif
                </div>
                
                <p class="text-gray-700 mb-4">{{ $forum->description }}</p>
                
                <div class="flex items-center space-x-6 text-sm text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2"></i>
                        {{ $forum->author->name ?? 'Unknown' }}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-reply mr-2"></i>
                        {{ $forum->replies_count }} balasan
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        Terakhir: {{ $forum->last_activity->format('d M Y, H:i') }}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        Dibuat: {{ $forum->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('teacher.courses.forums.edit', [$course, $forum]) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Edit Forum
                </a>
                <button onclick="confirmDeleteForum('{{ $forum->id }}', '{{ $forum->title }}', '{{ $course->id }}')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Hapus Forum
                </button>
                <a href="{{ route('teacher.courses.forums.index', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- Forum Content -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Konten Forum</h2>
        <div class="prose max-w-none">
            {!! nl2br(e($forum->content ?? $forum->description)) !!}
        </div>
    </div>

    <!-- Attachments -->
    @if($forum->attachments && count($forum->attachments) > 0)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Lampiran Forum</h2>
        <div class="space-y-3">
            @foreach($forum->attachments as $attachment)
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md hover:border-primary-300 transition-all duration-300 bg-gradient-to-r from-white to-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        @php
                            $extension = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
                        @endphp
                        
                        @if(in_array($extension, ['pdf']))
                            <div class="bg-red-100 rounded-lg p-3 mr-4">
                                <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                            </div>
                        @elseif(in_array($extension, ['doc', 'docx']))
                            <div class="bg-blue-100 rounded-lg p-3 mr-4">
                                <i class="fas fa-file-word text-blue-600 text-xl"></i>
                            </div>
                        @elseif(in_array($extension, ['ppt', 'pptx']))
                            <div class="bg-orange-100 rounded-lg p-3 mr-4">
                                <i class="fas fa-file-powerpoint text-orange-600 text-xl"></i>
                            </div>
                        @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                            <div class="bg-green-100 rounded-lg p-3 mr-4">
                                <i class="fas fa-file-image text-green-600 text-xl"></i>
                            </div>
                        @else
                            <div class="bg-gray-100 rounded-lg p-3 mr-4">
                                <i class="fas fa-file text-gray-600 text-xl"></i>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ basename($attachment) }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ $extension }} • Lampiran Forum</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <a href="{{ Storage::url($attachment) }}" target="_blank" 
                           class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-download mr-1"></i>
                            Download
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Replies Section -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Balasan Forum</h2>
            <span class="text-sm text-gray-500">{{ $forum->replies_count }} balasan</span>
        </div>
        
        @if($forum->replies_count > 0)
            <div class="space-y-4">
                @foreach($forum->replies as $reply)
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <div class="flex items-start space-x-3">
                        <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                            <span class="text-sm font-medium text-primary-600">{{ substr($reply->user->name ?? 'U', 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $reply->user->name ?? 'Unknown' }}</h4>
                                    <span class="text-xs text-gray-500">{{ $reply->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <button onclick="confirmDeleteReply({{ $reply->id }}, '{{ $reply->user->name ?? 'Unknown' }}', {{ $course->id }}, {{ $forum->id }})" 
                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus
                                </button>
                            </div>
                            <p class="text-sm text-gray-700">{{ $reply->content }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-comments text-3xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Belum ada balasan di forum ini.</p>
            </div>
        @endif
    </div>

    <!-- Reply Form -->
    @if(!$forum->is_locked)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Kirim Balasan</h2>
        
        <form action="{{ route('teacher.courses.forums.replies.store', [$course, $forum]) }}" method="POST">
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
                <a href="{{ route('teacher.courses.forums.index', $course) }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Kembali ke Forum
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Balasan
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
        <div class="flex items-center">
            <i class="fas fa-lock text-red-500 mr-3"></i>
            <p class="text-red-700 font-medium">Forum ini dikunci. Tidak dapat mengirim balasan.</p>
        </div>
    </div>
    @endif
</div>

<!-- Delete Forms (Hidden) -->
<form id="delete-forum-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="delete-reply-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDeleteForum(forumId, forumTitle, courseId) {
    if (confirm(`Apakah Anda yakin ingin menghapus forum "${forumTitle}"?\n\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua balasan di forum ini.`)) {
        const form = document.getElementById('delete-forum-form');
        form.action = `/teacher/courses/${courseId}/forums/${forumId}`;
        form.submit();
    }
}

function confirmDeleteReply(replyId, userName, courseId, forumId) {
    if (confirm(`Apakah Anda yakin ingin menghapus balasan dari "${userName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
        const form = document.getElementById('delete-reply-form');
        form.action = `/teacher/courses/${courseId}/forums/${forumId}/replies/${replyId}`;
        form.submit();
    }
}
</script>
@endsection
