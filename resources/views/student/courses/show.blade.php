@extends('layouts.student')

@section('title', $course->title)
@section('page-title', $course->title)

@php
    use Illuminate\Support\Facades\Storage;
@endphp

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
                        <i class="fas fa-user mr-2"></i>
                        {{ $course->teacher->name }}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-book mr-2"></i>
                        {{ $course->subject }}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Kelas {{ $course->class_level }}
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        {{ $course->enrollments()->where('status', 'approved')->count() }} siswa
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($course->status === 'active') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ $course->status_label }}
                </span>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <a href="#materials" class="border-b-2 border-primary-500 py-4 px-1 text-sm font-medium text-primary-600">
                    <i class="fas fa-book mr-2"></i>
                    Materi Pembelajaran
                </a>
                <a href="#assignments" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-tasks mr-2"></i>
                    Tugas & Ujian
                </a>
                <a href="#forums" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-comments mr-2"></i>
                    Forum Diskusi
                </a>
                <a href="#grades" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-star mr-2"></i>
                    Nilai
                </a>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Materials Tab -->
            <div id="materials" class="tab-content">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Materi Pembelajaran Digital</h3>
                    <span class="text-sm text-gray-500">{{ $course->lessons->count() }} materi tersedia</span>
                </div>
                
                @if($course->lessons->count() > 0)
                    <div class="space-y-4">
                        @foreach($course->lessons as $lesson)
                        <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $lesson->title }}</h4>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                            {{ $lesson->type_label }}
                                        </span>
                                        @if($lesson->is_published)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Segera Hadir
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($lesson->description, 150) }}</p>
                                    
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        @if($lesson->due_date)
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                Deadline: {{ $lesson->due_date->format('d M Y') }}
                                            </span>
                                        @endif
                                        @if($lesson->points)
                                            <span class="flex items-center">
                                                <i class="fas fa-star mr-1"></i>
                                                {{ $lesson->points }} poin
                                            </span>
                                        @endif
                                        @if($lesson->estimated_time)
                                            <span class="flex items-center">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $lesson->estimated_time }} menit
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    @if($lesson->is_published)
                                        <a href="{{ route('student.courses.lessons.show', [$course, $lesson]) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                            <i class="fas fa-play mr-2"></i>
                                            Mulai Belajar
                                        </a>
                                    @else
                                        <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-medium cursor-not-allowed">
                                            <i class="fas fa-lock mr-2"></i>
                                            Belum Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Lesson Content Preview -->
                            @if($lesson->is_published && $lesson->content)
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <h5 class="text-sm font-medium text-gray-900 mb-2">Preview Materi:</h5>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-sm text-gray-700">{{ Str::limit(strip_tags($lesson->content), 200) }}</p>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Attachments -->
                            @if($lesson->attachments && count($lesson->attachments) > 0)
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <h5 class="text-sm font-medium text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-paperclip mr-2"></i>
                                    Lampiran Materi ({{ count($lesson->attachments) }})
                                </h5>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($lesson->attachments as $attachment)
                                    @php
                                        $extension = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
                                    @endphp
                                    <div class="flex items-center justify-between bg-gray-50 hover:bg-gray-100 rounded-lg p-2 transition-colors duration-200">
                                        <div class="flex items-center flex-1 min-w-0">
                                            @if(in_array($extension, ['pdf']))
                                                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                            @elseif(in_array($extension, ['doc', 'docx']))
                                                <i class="fas fa-file-word text-blue-500 mr-2"></i>
                                            @elseif(in_array($extension, ['ppt', 'pptx']))
                                                <i class="fas fa-file-powerpoint text-orange-500 mr-2"></i>
                                            @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                <i class="fas fa-file-image text-green-500 mr-2"></i>
                                            @else
                                                <i class="fas fa-file text-gray-500 mr-2"></i>
                                            @endif
                                            <span class="text-sm text-gray-700 truncate">{{ basename($attachment) }}</span>
                                        </div>
                                        <a href="{{ route('student.courses.lessons.attachments.download', [$course, $lesson, basename($attachment)]) }}" 
                                           class="text-primary-600 hover:text-primary-700 text-xs font-medium ml-2">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-book text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada materi</h3>
                        <p class="text-gray-600">Materi pembelajaran akan muncul setelah guru menambahkannya.</p>
                    </div>
                @endif
            </div>

            <!-- Assignments Tab -->
            <div id="assignments" class="tab-content hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Tugas & Ujian</h3>
                    <span class="text-sm text-gray-500">{{ $course->assignments->count() }} tugas tersedia</span>
                </div>
                
                @if($course->assignments->count() > 0)
                    <div class="space-y-4">
                        @foreach($course->assignments as $assignment)
                        <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $assignment->title }}</h4>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                            {{ $assignment->type_label }}
                                        </span>
                                        @if($assignment->due_date && $assignment->due_date->isFuture())
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Aktif
                                            </span>
                                        @elseif($assignment->due_date && $assignment->due_date->isPast())
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Deadline Terlewat
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($assignment->description, 150) }}</p>
                                    
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        @if($assignment->due_date)
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                Deadline: {{ $assignment->due_date->format('d M Y H:i') }}
                                            </span>
                                        @endif
                                        @if($assignment->points)
                                            <span class="flex items-center">
                                                <i class="fas fa-star mr-1"></i>
                                                {{ $assignment->points }} poin
                                            </span>
                                        @endif
                                        @if($assignment->estimated_time)
                                            <span class="flex items-center">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $assignment->estimated_time }} menit
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    @if($assignment->due_date && $assignment->due_date->isFuture())
                                        <a href="{{ route('student.assignments.show', $assignment) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                            <i class="fas fa-edit mr-2"></i>
                                            Kerjakan
                                        </a>
                                    @else
                                        <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-medium cursor-not-allowed">
                                            <i class="fas fa-lock mr-2"></i>
                                            Tidak Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-tasks text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada tugas</h3>
                        <p class="text-gray-600">Tugas akan muncul setelah guru menambahkannya.</p>
                    </div>
                @endif
            </div>

            <!-- Forums Tab -->
            <div id="forums" class="tab-content hidden">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Forum Diskusi</h3>
                    <p class="text-sm text-gray-600 mt-1">Berpartisipasi dalam diskusi kelas</p>
                </div>
                
                <div class="space-y-4">
                    <!-- Sample Forum Topics -->
                    <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="text-lg font-semibold text-gray-900">Diskusi Materi Pertama</h4>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-comments mr-1"></i>
                                        Aktif
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-3">Mari kita diskusikan materi yang baru saja dipelajari...</p>
                                
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <i class="fas fa-user mr-1"></i>
                                        Oleh: Guru Matematika
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ \Carbon\Carbon::now()->subHours(2)->diffForHumans() }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-comments mr-1"></i>
                                        {{ rand(3, 8) }} balasan
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('student.courses.forums.show', [$course->id, 1]) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    Lihat Diskusi
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Grades Tab -->
            <div id="grades" class="tab-content hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Nilai & Progress</h3>
                    <span class="text-sm text-gray-500">Progress belajar Anda</span>
                </div>
                
                <!-- Progress Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold mb-2">Progress Materi</h4>
                                <p class="text-3xl font-bold">75%</p>
                                <p class="text-blue-100 text-sm">3 dari 4 materi selesai</p>
                            </div>
                            <i class="fas fa-book text-4xl text-blue-200"></i>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold mb-2">Tugas Selesai</h4>
                                <p class="text-3xl font-bold">5</p>
                                <p class="text-green-100 text-sm">dari 7 tugas</p>
                            </div>
                            <i class="fas fa-tasks text-4xl text-green-200"></i>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold mb-2">Nilai Rata-rata</h4>
                                <p class="text-3xl font-bold">85</p>
                                <p class="text-purple-100 text-sm">Sangat Baik</p>
                            </div>
                            <i class="fas fa-star text-4xl text-purple-200"></i>
                        </div>
                    </div>
                </div>

                <!-- Detailed Grades -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900">Detail Nilai</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas/Ujian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Tugas 1: Aljabar Dasar</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">90</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15 Okt 2024</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Ujian Tengah Semester</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">85</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20 Okt 2024</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Tugas 2: Geometri</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                            Menunggu Penilaian
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25 Okt 2024</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('student.assignments.index') }}" class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 text-center">
            <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-tasks text-blue-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Tugas & Ujian</h3>
            <p class="text-sm text-gray-600">Lihat dan kerjakan tugas dari kelas ini</p>
        </a>
        
        <a href="{{ route('student.forums.index') }}" class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 text-center">
            <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-comments text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Forum Diskusi</h3>
            <p class="text-sm text-gray-600">Diskusi dengan teman dan guru</p>
        </a>
        
        <a href="{{ route('student.grades.index') }}" class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 text-center">
            <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-star text-purple-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Nilai & Progress</h3>
            <p class="text-sm text-gray-600">Lihat nilai dan progress belajar</p>
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
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
                content.classList.add('hidden');
            });
            
            // Show selected tab content
            const targetId = this.getAttribute('href').substring(1);
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });
    
    // Initialize first tab as active
    if (tabLinks.length > 0) {
        tabLinks[0].click();
    }
});
</script>
@endsection