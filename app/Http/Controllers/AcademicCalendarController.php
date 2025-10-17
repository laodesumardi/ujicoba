<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicCalendar;
use App\Models\HomeSection;
use Carbon\Carbon;

class AcademicCalendarController extends Controller
{
    /**
     * Display the academic calendar.
     */
    public function index(Request $request)
    {
        $query = AcademicCalendar::active()->public();

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->byType($request->type);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->byPriority($request->priority);
        }

        // Filter by month
        if ($request->has('month') && $request->month) {
            $query->whereMonth('start_date', $request->month);
        }

        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->whereYear('start_date', $request->year);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        $events = $query->orderBy('start_date')->get();

        // Get current month and year
        $currentMonth = $request->get('month', now()->month);
        $currentYear = $request->get('year', now()->year);

        // Get months for filter
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Get years for filter (current year ± 2)
        $years = [];
        for ($i = now()->year - 2; $i <= now()->year + 2; $i++) {
            $years[$i] = $i;
        }

        // Get event types
        $types = [
            'semester' => 'Semester',
            'ujian' => 'Ujian',
            'libur' => 'Libur',
            'hari_besar' => 'Hari Besar',
            'kegiatan' => 'Kegiatan',
            'lainnya' => 'Lainnya'
        ];

        // Get priorities
        $priorities = [
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'critical' => 'Kritis'
        ];

        // Get academic calendar section data
        $academicCalendarSection = HomeSection::where('section_key', 'academic-calendar')->first();

        return view('academic-calendar.index', compact(
            'events', 'months', 'years', 'types', 'priorities',
            'currentMonth', 'currentYear', 'academicCalendarSection'
        ));
    }

    /**
     * Display calendar view.
     */
    public function calendar(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // Get events for the month
        $events = AcademicCalendar::active()
            ->public()
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->orderBy('start_date')
            ->get();

        // Get calendar data
        $calendarData = $this->generateCalendarData($month, $year, $events);

        // Get months and years for navigation
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $years = [];
        for ($i = now()->year - 2; $i <= now()->year + 2; $i++) {
            $years[$i] = $i;
        }

        // Get academic calendar section data
        $academicCalendarSection = HomeSection::where('section_key', 'academic-calendar')->first();

        return view('academic-calendar.calendar', compact(
            'calendarData', 'events', 'months', 'years', 'month', 'year', 'academicCalendarSection'
        ));
    }

    /**
     * Display upcoming events.
     */
    public function upcoming()
    {
        $events = AcademicCalendar::active()
            ->public()
            ->upcoming(30)
            ->orderBy('start_date')
            ->get();

        // Get academic calendar section data
        $academicCalendarSection = HomeSection::where('section_key', 'academic-calendar')->first();

        return view('academic-calendar.upcoming', compact('events', 'academicCalendarSection'));
    }

    /**
     * Download calendar file.
     */
    public function download($id)
    {
        $event = AcademicCalendar::active()->public()->findOrFail($id);

        if (!$event->is_downloadable || !$event->file_path) {
            abort(404, 'File tidak tersedia untuk diunduh');
        }

        $filePath = storage_path('app/public/' . $event->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath);
    }

    /**
     * Generate calendar data for a specific month.
     */
    private function generateCalendarData($month, $year, $events)
    {
        $firstDay = Carbon::create($year, $month, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        $startOfWeek = $firstDay->copy()->startOfWeek();
        $endOfWeek = $lastDay->copy()->endOfWeek();

        $calendar = [];
        $current = $startOfWeek->copy();

        while ($current->lte($endOfWeek)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dayEvents = $events->filter(function ($event) use ($current) {
                    return $event->start_date->isSameDay($current) ||
                           ($event->end_date && $current->between($event->start_date, $event->end_date));
                });

                $week[] = [
                    'date' => $current->copy(),
                    'events' => $dayEvents,
                    'is_current_month' => $current->month == $month,
                    'is_today' => $current->isToday()
                ];

                $current->addDay();
            }
            $calendar[] = $week;
        }

        return $calendar;
    }
}