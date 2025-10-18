@extends('layouts.student')

@section('title', 'Nilai & Rapor')
@section('page-title', 'Nilai & Rapor')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Nilai & Rapor</h1>
                <p class="text-gray-600 mt-1">Lihat progress pembelajaran dan nilai Anda</p>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                    <i class="fas fa-star text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Tugas Dinilai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_assignments'] }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['average_grade'] }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['highest_grade'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-orange-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                    <i class="fas fa-chart-bar text-orange-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Nilai Terendah</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['lowest_grade'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grades by Course -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Nilai per Kelas</h2>
        
        @if($gradesByCourse->count() > 0)
            <div class="space-y-4">
                @foreach($gradesByCourse as $gradeData)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $gradeData['course']->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $gradeData['course']->code }} • {{ $gradeData['course']->subject }}</p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>{{ $gradeData['assignments_count'] }} tugas dinilai</span>
                                <span>{{ $gradeData['total_points'] }}/{{ $gradeData['max_points'] }} poin</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-blue-600">{{ $gradeData['percentage'] }}%</div>
                            <div class="text-sm text-gray-500">Persentase</div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mt-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $gradeData['percentage'] }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada nilai</h3>
                <p class="text-gray-600">Nilai akan muncul setelah guru menilai tugas Anda.</p>
            </div>
        @endif
    </div>

    <!-- Recent Grades -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Nilai Terbaru</h2>
        
        @if($submissions->count() > 0)
            <div class="space-y-4">
                @foreach($submissions as $submission)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $submission->assignment->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $submission->assignment->course->title }} • {{ $submission->assignment->course->code }}</p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>Dinilai: {{ $submission->graded_at->format('d M Y, H:i') }}</span>
                                <span>{{ $submission->assignment->points }} poin</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $submission->grade }}/{{ $submission->assignment->points }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ round(($submission->grade / $submission->assignment->points) * 100) }}%
                            </div>
                        </div>
                    </div>
                    
                    @if($submission->feedback)
                    <div class="mt-3 p-3 bg-yellow-50 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-1">Feedback Guru:</h4>
                        <p class="text-sm text-gray-700">{{ $submission->feedback }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $submissions->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-star text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada nilai</h3>
                <p class="text-gray-600">Nilai akan muncul setelah guru menilai tugas Anda.</p>
            </div>
        @endif
    </div>

    <!-- Performance Chart -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Grafik Performance</h2>
        
        @if($submissions->count() > 0)
            <div class="h-64 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600">Grafik performance akan ditampilkan di sini</p>
                    <p class="text-sm text-gray-500">Fitur ini akan dikembangkan lebih lanjut</p>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data</h3>
                <p class="text-gray-600">Grafik akan muncul setelah ada nilai yang tercatat.</p>
            </div>
        @endif
    </div>
</div>
@endsection
