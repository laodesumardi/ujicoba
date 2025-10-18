@extends('layouts.teacher')

@section('title', 'Detail Kelas')
@section('page-title', 'Detail Kelas')

@section('content')
<div class="space-y-6">
    <!-- Course Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $course->title }}</h1>
                <p class="text-sm text-gray-600 mb-2">{{ $course->code }}</p>
                <p class="text-gray-700 mb-4">{{ $course->description }}</p>
                
                <div class="flex items-center space-x-6 text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        {{ $course->subject }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ $course->class_level }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $course->start_date->format('d M Y') }} - {{ $course->end_date ? $course->end_date->format('d M Y') : 'Tidak ditentukan' }}
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($course->status === 'active') bg-green-100 text-green-800
                    @elseif($course->status === 'draft') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ $course->status_label }}
                </span>
                @if($course->is_public)
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                    Publik
                </span>
                @endif
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('teacher.courses.edit', $course) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                Edit Kelas
            </a>
            
            <form action="{{ route('teacher.courses.toggle-status', $course) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    @if($course->status === 'active')
                        Nonaktifkan
                    @else
                        Aktifkan
                    @endif
                </button>
            </form>
            
            <button onclick="confirmDelete('{{ $course->id }}', '{{ $course->title }}')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                Hapus Kelas
            </button>
            
            <a href="{{ route('teacher.courses.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                Kembali ke Daftar Kelas
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Materi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_lessons'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Materi Dipublikasikan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['published_lessons'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-2-2V10a2 2 0 012-2h2m3-4h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-2-2V6a2 2 0 012-2h2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Forum Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_forums'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <a href="#lessons" class="border-b-2 border-primary-500 py-4 px-1 text-sm font-medium text-primary-600">
                    Materi
                </a>
                <a href="#assignments" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Tugas
                </a>
                <a href="#forums" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Forum
                </a>
                <a href="#students" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Siswa
                </a>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Lessons Tab -->
            <div id="lessons" class="tab-content">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Materi Kelas</h3>
                    <a href="{{ route('teacher.courses.lessons.create', $course) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Tambah Materi
                    </a>
                </div>
                
                @if($course->lessons->count() > 0)
                    <div class="space-y-4">
                        @foreach($course->lessons as $lesson)
                        <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $lesson->title }}</h4>
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($lesson->description, 100) }}</p>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span class="px-2 py-1 bg-gray-100 rounded-full">{{ $lesson->type_label }}</span>
                                        @if($lesson->is_published)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">Dipublikasikan</span>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Draft</span>
                                        @endif
                                        @if($lesson->due_date)
                                            <span>Deadline: {{ $lesson->due_date->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('teacher.courses.lessons.show', [$course, $lesson]) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                        Lihat
                                    </a>
                                    <a href="{{ route('teacher.courses.lessons.edit', [$course, $lesson]) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada materi</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan materi pertama.</p>
                        <div class="mt-6">
                            <a href="{{ route('teacher.courses.lessons.create', $course) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                Tambah Materi
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Assignments Tab -->
            <div id="assignments" class="tab-content" style="display: none;">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Tugas Kelas</h3>
                    <a href="{{ route('teacher.courses.assignments.create', $course) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Tambah Tugas
                    </a>
                </div>
                
                @if($course->assignments->count() > 0)
                    <div class="space-y-4">
                        @foreach($course->assignments as $assignment)
                        <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $assignment->title }}</h4>
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($assignment->description, 100) }}</p>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">{{ $assignment->type_label }}</span>
                                        @if($assignment->is_published)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">Dipublikasikan</span>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Draft</span>
                                        @endif
                                        @if($assignment->due_date)
                                            <span>Deadline: {{ $assignment->due_date->format('d M Y, H:i') }}</span>
                                        @endif
                                        @if($assignment->points)
                                            <span>{{ $assignment->points }} poin</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('teacher.courses.assignments.show', [$course, $assignment]) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                        Lihat
                                    </a>
                                    <a href="{{ route('teacher.courses.assignments.edit', [$course, $assignment]) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                                        Edit
                                    </a>
                                    <button onclick="confirmDeleteAssignment('{{ $assignment->id }}', '{{ $assignment->title }}', '{{ $course->id }}')" class="text-red-600 hover:text-red-800 font-medium">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada tugas</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan tugas pertama.</p>
                        <div class="mt-6">
                            <a href="{{ route('teacher.courses.assignments.create', $course) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                Tambah Tugas
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Forums Tab -->
            <div id="forums" class="tab-content" style="display: none;">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Forum Diskusi</h3>
                    <a href="{{ route('teacher.courses.forums.create', $course) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Buat Forum
                    </a>
                </div>
                
                @if($course->forums->count() > 0)
                    <div class="space-y-4">
                        @foreach($course->forums as $forum)
                        <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $forum->title }}</h4>
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($forum->description, 100) }}</p>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        @if($forum->is_pinned)
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Dipasang</span>
                                        @endif
                                        @if($forum->is_locked)
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">Dikunci</span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">Aktif</span>
                                        @endif
                                        <span>{{ $forum->replies_count }} balasan</span>
                                        <span>Terakhir: {{ $forum->last_activity->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('teacher.courses.forums.show', [$course, $forum]) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                        Lihat
                                    </a>
                                    <a href="{{ route('teacher.courses.forums.edit', [$course, $forum]) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada forum</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat forum diskusi pertama.</p>
                        <div class="mt-6">
                            <a href="{{ route('teacher.courses.forums.create', $course) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                Buat Forum
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Students Tab -->
            <div id="students" class="tab-content" style="display: none;">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Siswa Terdaftar</h3>
                    <span class="text-sm text-gray-500">{{ $stats['total_students'] }} siswa terdaftar</span>
                </div>
                
                @if($stats['total_students'] > 0)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h4 class="text-sm font-medium text-gray-900">Daftar Siswa</h4>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach($course->enrollments as $enrollment)
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                        <span class="text-sm font-medium text-primary-600">{{ substr($enrollment->student->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $enrollment->student->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $enrollment->student->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($enrollment->status === 'approved') bg-green-100 text-green-800
                                        @elseif($enrollment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $enrollment->enrolled_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada siswa</h3>
                        <p class="mt-1 text-sm text-gray-500">Siswa akan muncul setelah mereka mendaftar di kelas ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete(courseId, courseTitle) {
    if (confirm(`Apakah Anda yakin ingin menghapus kelas "${courseTitle}"?\n\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait kelas ini.`)) {
        const form = document.getElementById('delete-form');
        form.action = `/teacher/courses/${courseId}`;
        form.submit();
    }
}

function confirmDeleteAssignment(assignmentId, assignmentTitle, courseId) {
    if (confirm(`Apakah Anda yakin ingin menghapus tugas "${assignmentTitle}"?\n\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait tugas ini termasuk pengumpulan siswa.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/teacher/courses/${courseId}/assignments/${assignmentId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Tab navigation
document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('nav a[href^="#"]');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            tabLinks.forEach(l => {
                l.classList.remove('border-primary-500', 'text-primary-600');
                l.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Add active class to clicked link
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-primary-500', 'text-primary-600');
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.style.display = 'none';
            });
            
            // Show selected tab content
            const targetId = this.getAttribute('href').substring(1);
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.style.display = 'block';
            }
        });
    });
    
    // Show first tab by default
    if (tabLinks.length > 0) {
        tabLinks[0].click();
    }
});
</script>
@endsection
