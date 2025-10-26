@extends('layouts.student')

@section('title', 'Hasil Penilaian')
@section('page-title', 'Hasil Penilaian')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Hasil Penilaian</h1>
                <p class="text-gray-600 mt-1">Tugas yang sudah dinilai oleh guru</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('student.assignments.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Semua Tugas
                </a>
                <a href="{{ route('student.assignments.submitted') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Tugas Dikumpulkan
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                    <i class="fas fa-star text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Dinilai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $submissions->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Rata-rata</p>
                    <p class="text-2xl font-bold text-gray-900">
                        @if($submissions->count() > 0)
                            {{ round($submissions->avg('score'), 1) }}
                        @else
                            0
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                    <i class="fas fa-trophy text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Nilai Tertinggi</p>
                    <p class="text-2xl font-bold text-gray-900">
                        @if($submissions->count() > 0)
                            {{ $submissions->max('score') }}
                        @else
                            0
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-orange-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                    <i class="fas fa-percentage text-orange-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Rata-rata %</p>
                    <p class="text-2xl font-bold text-gray-900">
                        @if($submissions->count() > 0)
                            {{ round(($submissions->avg('score') / $submissions->avg('assignment.points')) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Sort -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <h3 class="text-lg font-semibold text-gray-900">Filter & Urutkan</h3>
            </div>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <select id="gradeFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Nilai</option>
                    <option value="excellent">Sangat Baik (90-100%)</option>
                    <option value="good">Baik (80-89%)</option>
                    <option value="fair">Cukup (70-79%)</option>
                    <option value="poor">Kurang (< 70%)</option>
                </select>
                <select id="sortBy" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="highest">Nilai Tertinggi</option>
                    <option value="lowest">Nilai Terendah</option>
                    <option value="course">Mata Pelajaran</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Graded Submissions List -->
    @if($submissions->count() > 0)
        <div id="submissionsContainer" class="space-y-4">
            @foreach($submissions as $submission)
            @php
                $percentage = round(($submission->score / $submission->assignment->points) * 100);
                $gradeCategory = $percentage >= 90 ? 'excellent' : ($percentage >= 80 ? 'good' : ($percentage >= 70 ? 'fair' : 'poor'));
            @endphp
            <div class="submission-card bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden" 
                 data-grade="{{ $submission->score }}" 
                 data-percentage="{{ $percentage }}" 
                 data-category="{{ $gradeCategory }}"
                 data-course="{{ $submission->assignment->course->title }}"
                 data-graded-at="{{ $submission->graded_at->timestamp }}"
                 data-assignment="{{ $submission->assignment->title }}">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $submission->assignment->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $submission->assignment->course->title }} • {{ $submission->assignment->course->code }}</p>
                            <p class="text-gray-700 mb-4">{{ Str::limit($submission->assignment->description, 150) }}</p>
                            
                            <div class="flex items-center space-x-6 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Dikumpulkan: {{ $submission->submitted_at->format('d M Y, H:i') }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-star mr-2"></i>
                                    Dinilai: {{ $submission->graded_at->format('d M Y, H:i') }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $submission->assignment->points }} poin
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end space-y-2">
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-star mr-1"></i>
                                    Dinilai
                                </span>
                                <span class="px-3 py-1 text-sm font-medium rounded-full
                                    @if($percentage >= 90) bg-green-100 text-green-800
                                    @elseif($percentage >= 80) bg-blue-100 text-blue-800
                                    @elseif($percentage >= 70) bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @if($percentage >= 90) Sangat Baik
                                    @elseif($percentage >= 80) Baik
                                    @elseif($percentage >= 70) Cukup
                                    @else Kurang
                                    @endif
                                </span>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-3xl font-bold 
                                    @if($percentage >= 90) text-green-600
                                    @elseif($percentage >= 80) text-blue-600
                                    @elseif($percentage >= 70) text-yellow-600
                                    @else text-red-600
                                    @endif">
                                    {{ $submission->score }}/{{ $submission->assignment->points }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $percentage }}%
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grade Details -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Detail Penilaian</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Nilai:</span>
                                        <span class="font-medium">{{ $submission->score }}/{{ $submission->assignment->points }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Persentase:</span>
                                        <span class="font-medium">{{ round(($submission->score / $submission->assignment->points) * 100) }}%</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-medium text-green-600">Selesai</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Progress</h4>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($submission->score / $submission->assignment->points) * 100 }}%"></div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">
                                    {{ round(($submission->score / $submission->assignment->points) * 100) }}% dari nilai maksimal
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Feedback -->
                    @if($submission->feedback)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Feedback Guru</h4>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-gray-700">{{ $submission->feedback }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Submission Content -->
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Jawaban Anda</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700">{{ Str::limit($submission->content, 300) }}</p>
                        </div>
                    </div>
                    
                    <!-- Attachments -->
                    @if($submission->attachments && count($submission->attachments) > 0)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Lampiran Anda</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($submission->attachments as $attachment)
                            <span class="inline-flex items-center px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg">
                                <i class="fas fa-paperclip mr-2"></i>
                                {{ basename($attachment) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $submissions->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
            <i class="fas fa-star text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada hasil penilaian</h3>
            <p class="text-gray-600 mb-6">Hasil penilaian akan muncul setelah guru menilai tugas Anda.</p>
            <a href="{{ route('student.assignments.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                Lihat Semua Tugas
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const gradeFilter = document.getElementById('gradeFilter');
    const sortBy = document.getElementById('sortBy');
    const submissionsContainer = document.getElementById('submissionsContainer');
    const submissionCards = document.querySelectorAll('.submission-card');
    
    function filterAndSort() {
        const selectedGrade = gradeFilter.value;
        const selectedSort = sortBy.value;
        
        let filteredCards = Array.from(submissionCards);
        
        // Filter by grade category
        if (selectedGrade) {
            filteredCards = filteredCards.filter(card => {
                return card.dataset.category === selectedGrade;
            });
        }
        
        // Sort cards
        filteredCards.sort((a, b) => {
            switch(selectedSort) {
                case 'newest':
                    return parseInt(b.dataset.gradedAt) - parseInt(a.dataset.gradedAt);
                case 'oldest':
                    return parseInt(a.dataset.gradedAt) - parseInt(b.dataset.gradedAt);
                case 'highest':
                    return parseInt(b.dataset.grade) - parseInt(a.dataset.grade);
                case 'lowest':
                    return parseInt(a.dataset.grade) - parseInt(b.dataset.grade);
                case 'course':
                    return a.dataset.course.localeCompare(b.dataset.course);
                default:
                    return 0;
            }
        });
        
        // Hide all cards first
        submissionCards.forEach(card => {
            card.style.display = 'none';
        });
        
        // Show filtered and sorted cards
        filteredCards.forEach(card => {
            card.style.display = 'block';
        });
        
        // Show no results message if no cards match
        if (filteredCards.length === 0) {
            showNoResultsMessage();
        } else {
            hideNoResultsMessage();
        }
    }
    
    function showNoResultsMessage() {
        let noResults = document.getElementById('noResultsMessage');
        if (!noResults) {
            noResults = document.createElement('div');
            noResults.id = 'noResultsMessage';
            noResults.className = 'bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center';
            noResults.innerHTML = `
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada hasil</h3>
                <p class="text-gray-600 mb-6">Tidak ada tugas yang sesuai dengan filter yang dipilih.</p>
                <button onclick="clearFilters()" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Hapus Filter
                </button>
            `;
            submissionsContainer.appendChild(noResults);
        }
        noResults.style.display = 'block';
    }
    
    function hideNoResultsMessage() {
        const noResults = document.getElementById('noResultsMessage');
        if (noResults) {
            noResults.style.display = 'none';
        }
    }
    
    function clearFilters() {
        gradeFilter.value = '';
        sortBy.value = 'newest';
        filterAndSort();
    }
    
    // Add event listeners
    gradeFilter.addEventListener('change', filterAndSort);
    sortBy.addEventListener('change', filterAndSort);
    
    // Initialize
    filterAndSort();
});

// Make clearFilters available globally
window.clearFilters = function() {
    document.getElementById('gradeFilter').value = '';
    document.getElementById('sortBy').value = 'newest';
    document.dispatchEvent(new Event('DOMContentLoaded'));
};
</script>
@endsection
