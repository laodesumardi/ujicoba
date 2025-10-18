@extends('layouts.teacher')

@section('title', 'Forum Diskusi')
@section('page-title', 'Forum Diskusi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Forum Diskusi</h1>
                <p class="text-gray-600">Kelola forum diskusi untuk kelas {{ $course->title }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('teacher.courses.forums.create', $course) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Forum
                </a>
                <a href="{{ route('teacher.courses.show', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Kelas
                </a>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-lg p-3">
                    <i class="fas fa-comments text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Forum</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $forums->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-lg p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Forum Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $forums->where('is_locked', false)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-yellow-100 rounded-lg p-3">
                    <i class="fas fa-thumbtack text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Forum Dipasang</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $forums->where('is_pinned', true)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Forums List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Forum</h3>
        </div>
        
        @if($forums->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($forums as $forum)
                <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $forum->title }}</h4>
                                @if($forum->is_pinned)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-thumbtack mr-1"></i>
                                        Dipasang
                                    </span>
                                @endif
                                @if($forum->is_locked)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-lock mr-1"></i>
                                        Dikunci
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-comments mr-1"></i>
                                        Aktif
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($forum->description, 150) }}</p>
                            
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <i class="fas fa-reply mr-1"></i>
                                    {{ $forum->replies_count }} balasan
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    Terakhir: {{ $forum->last_activity->format('d M Y, H:i') }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Dibuat: {{ $forum->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('teacher.courses.forums.show', [$course, $forum]) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                Lihat
                            </a>
                            <a href="{{ route('teacher.courses.forums.edit', [$course, $forum]) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                                Edit
                            </a>
                            <button onclick="confirmDeleteForum('{{ $forum->id }}', '{{ $forum->title }}', '{{ $course->id }}')" class="text-red-600 hover:text-red-800 font-medium">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada forum</h3>
                <p class="text-gray-600 mb-6">Mulai dengan membuat forum diskusi pertama.</p>
                <a href="{{ route('teacher.courses.forums.create', $course) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Forum Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="delete-forum-form" method="POST" style="display: none;">
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
</script>
@endsection
