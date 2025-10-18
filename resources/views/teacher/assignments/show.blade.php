@extends('layouts.teacher')

@section('title', 'Detail Tugas')
@section('page-title', 'Detail Tugas')

@section('content')
<div class="space-y-6">
    <!-- Assignment Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $assignment->title }}</h1>
                <p class="text-sm text-gray-600 mb-2">{{ $assignment->course->title }} • {{ $assignment->course->code }}</p>
                <p class="text-gray-700 mb-4">{{ $assignment->description }}</p>
                
                <div class="flex items-center space-x-6 text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Due: {{ $assignment->due_date->format('d M Y, H:i') }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ $assignment->points }} poin
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        {{ $assignment->submissions->count() }} pengumpulan
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($assignment->type === 'assignment') bg-blue-100 text-blue-800
                    @elseif($assignment->type === 'quiz') bg-green-100 text-green-800
                    @elseif($assignment->type === 'exam') bg-red-100 text-red-800
                    @else bg-purple-100 text-purple-800
                    @endif">
                    {{ ucfirst($assignment->type) }}
                </span>
                @if($assignment->is_published)
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                    Aktif
                </span>
                @else
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                    Draft
                </span>
                @endif
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('teacher.courses.assignments.edit', [$course, $assignment]) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                Edit Tugas
            </a>
            
            <form action="{{ route('teacher.courses.assignments.toggle-published', [$course, $assignment]) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    @if($assignment->is_published)
                        Sembunyikan
                    @else
                        Publikasikan
                    @endif
                </button>
            </form>
            
            <button onclick="confirmDelete('{{ $assignment->id }}', '{{ $assignment->title }}', '{{ $course->id }}')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                Hapus Tugas
            </button>
            
            <a href="{{ route('teacher.courses.assignments.index', $course) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                Kembali ke Daftar Tugas
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
                    <p class="text-sm font-medium text-gray-600">Total Pengumpulan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_submissions'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sudah Dinilai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['graded_submissions'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu Penilaian</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_submissions'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Terlambat</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['late_submissions'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignment Instructions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Instruksi Tugas</h2>
        <div class="prose max-w-none">
            {!! nl2br(e($assignment->instructions)) !!}
        </div>
        
        @if($assignment->attachments && count($assignment->attachments) > 0)
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Lampiran</h3>
            <div class="space-y-2">
                @foreach($assignment->attachments as $attachment)
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    <span class="text-sm text-gray-600">{{ basename($attachment) }}</span>
                    <a href="{{ Storage::url($attachment) }}" target="_blank" class="ml-auto text-primary-600 hover:text-primary-700 text-sm">
                        Download
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Submissions List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Pengumpulan Siswa</h2>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('teacher.courses.assignments.download-submissions', [$course, $assignment]) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        Download Semua
                    </a>
                </div>
            </div>
        </div>
        
        <div class="divide-y divide-gray-100">
            @forelse($submissions as $submission)
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $submission->student->name }}</h3>
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                @if($submission->status === 'graded') bg-green-100 text-green-800
                                @elseif($submission->status === 'submitted') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($submission->status) }}
                            </span>
                            @if($submission->is_late)
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                Terlambat
                            </span>
                            @endif
                        </div>
                        
                        <p class="text-gray-600 mb-3">{{ Str::limit($submission->content, 150) }}</p>
                        
                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Dikumpulkan: {{ $submission->submitted_at->format('d M Y, H:i') }}
                            </div>
                            @if($submission->grade !== null)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Nilai: {{ $submission->grade }}/{{ $assignment->points }}
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @if($submission->status === 'submitted')
                        <button onclick="openGradeModal({{ $submission->id }}, '{{ $submission->student->name }}')" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                            Beri Nilai
                        </button>
                        @elseif($submission->status === 'graded')
                        <button onclick="openGradeModal({{ $submission->id }}, '{{ $submission->student->name }}', {{ $submission->grade }}, '{{ $submission->feedback }}')" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                            Edit Nilai
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pengumpulan</h3>
                <p class="mt-1 text-sm text-gray-500">Siswa belum mengumpulkan tugas ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($submissions->hasPages())
    <div class="mt-8">
        {{ $submissions->links() }}
    </div>
    @endif
</div>

<!-- Grade Modal -->
<div id="gradeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
            <form id="gradeForm" method="POST">
                @csrf
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Beri Nilai</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Siswa</label>
                            <p id="studentName" class="text-gray-900"></p>
                        </div>
                        <div>
                            <label for="grade" class="block text-sm font-medium text-gray-700 mb-2">Nilai (0-{{ $assignment->points }})</label>
                            <input type="number" name="grade" id="grade" min="0" max="{{ $assignment->points }}" step="0.1"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   required>
                        </div>
                        <div>
                            <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">Feedback (Opsional)</label>
                            <textarea name="feedback" id="feedback" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                      placeholder="Berikan feedback untuk siswa..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-4">
                    <button type="button" onclick="closeGradeModal()" class="text-gray-600 hover:text-gray-800 font-medium">
                        Batal
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        Simpan Nilai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openGradeModal(submissionId, studentName, currentGrade = '', currentFeedback = '') {
    document.getElementById('studentName').textContent = studentName;
    document.getElementById('grade').value = currentGrade;
    document.getElementById('feedback').value = currentFeedback;
    document.getElementById('gradeForm').action = `/teacher/courses/{{ $course->id }}/assignments/{{ $assignment->id }}/submissions/${submissionId}/grade`;
    document.getElementById('gradeModal').classList.remove('hidden');
}

function closeGradeModal() {
    document.getElementById('gradeModal').classList.add('hidden');
}

function confirmDelete(assignmentId, assignmentTitle, courseId) {
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
</script>
@endsection
