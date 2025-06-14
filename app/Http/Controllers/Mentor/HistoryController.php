<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\MentoringSession;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HistoryController extends Controller
{
    /**
     * Display mentor's session history
     */
    public function index(Request $request)
    {
        $mentorId = Auth::id();
        
        // Get filter parameters
        $filter = $request->get('filter', 'all');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $subject = $request->get('subject');
        
        // Build query for sessions
        $query = MentoringSession::with(['student', 'subject'])
                                ->where('mentor_id', $mentorId)
                                ->orderBy('date', 'desc')
                                ->orderBy('start_time', 'desc');
        
        // Apply status filters
        switch ($filter) {
            case 'upcoming':
                $query->whereIn('status', ['confirmed', 'booked'])
                      ->where('date', '>=', now()->toDateString());
                break;
            case 'today':
                $query->whereDate('date', today())
                      ->whereIn('status', ['confirmed', 'booked', 'ongoing']);
                break;
            case 'completed':
                $query->where('status', 'completed');
                break;
            case 'cancelled':
                $query->where('status', 'cancelled');
                break;
            case 'available':
                $query->where('status', 'available')
                      ->whereNull('student_id');
                break;
        }
        
        // Apply date filters
        if ($dateFrom) {
            $query->where('date', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $query->where('date', '<=', $dateTo);
        }
        
        // Apply subject filter
        if ($subject) {
            $query->where('subject_id', $subject);
        }
        
        $sessions = $query->paginate(10)->withQueryString();
        
        // Get subjects for filter dropdown - subjects that mentor has sessions with
        $subjects = Subject::whereHas('sessions', function($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->get();
        
        // Get session statistics
        $stats = $this->getSessionStats();
        
        return view('mentor.history', compact('sessions', 'filter', 'subjects', 'stats', 'dateFrom', 'dateTo', 'subject'));
    }

    /**
     * Show session details
     */
    public function show($sessionId)
    {
        $session = MentoringSession::with(['student', 'subject'])
            ->where('mentor_id', Auth::id())
            ->findOrFail($sessionId);
        
        return view('mentor.session-detail', compact('session'));
    }

    /**
     * Get mentor session statistics
     */
    private function getSessionStats()
    {
        $mentorId = Auth::id();
        
        return [
            'total_sessions' => MentoringSession::where('mentor_id', $mentorId)->count(),
            'available_sessions' => MentoringSession::where('mentor_id', $mentorId)
                ->where('status', 'available')
                ->whereNull('student_id')
                ->count(),
            'confirmed_sessions' => MentoringSession::where('mentor_id', $mentorId)
                ->whereIn('status', ['confirmed', 'booked'])
                ->count(),
            'completed_sessions' => MentoringSession::where('mentor_id', $mentorId)
                ->where('status', 'completed')
                ->count(),
            'cancelled_sessions' => MentoringSession::where('mentor_id', $mentorId)
                ->where('status', 'cancelled')
                ->count(),
            'upcoming_sessions' => MentoringSession::where('mentor_id', $mentorId)
                ->whereIn('status', ['confirmed', 'booked'])
                ->where('date', '>=', today())
                ->count(),
            'today_sessions' => MentoringSession::where('mentor_id', $mentorId)
                ->whereDate('date', today())
                ->whereIn('status', ['confirmed', 'booked', 'ongoing'])
                ->count(),
            'total_earnings' => MentoringSession::where('mentor_id', $mentorId)
                ->where('status', 'completed')
                ->sum('price'),
            'this_month_earnings' => MentoringSession::where('mentor_id', $mentorId)
                ->where('status', 'completed')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->sum('price')
        ];
    }

    /**
     * Update meeting link - Admin functionality accessible by mentor
     */
    public function updateMeetingLink(Request $request, $sessionId)
    {
        $request->validate([
            'meeting_link' => 'required|url'
        ]);

        $session = MentoringSession::where('mentor_id', Auth::id())
            ->where('id', $sessionId)
            ->whereIn('status', ['confirmed', 'booked'])
            ->firstOrFail();

        $session->update([
            'meeting_link' => $request->meeting_link
        ]);

        return redirect()->back()
            ->with('success', 'Meeting link berhasil diperbarui.');
    }

    /**
     * Mark session as completed
     */
    public function markCompleted(Request $request, $sessionId)
    {
        $request->validate([
            'mentor_notes' => 'nullable|string|max:1000'
        ]);

        $session = MentoringSession::where('mentor_id', Auth::id())
            ->where('id', $sessionId)
            ->whereIn('status', ['confirmed', 'booked', 'ongoing'])
            ->firstOrFail();

        $session->update([
            'status' => 'completed',
            'mentor_notes' => $request->mentor_notes,
            'completed_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Session berhasil ditandai sebagai selesai.');
    }

    /**
     * Add mentor notes to session
     */
    public function addNotes(Request $request, $sessionId)
    {
        $request->validate([
            'mentor_notes' => 'required|string|max:1000'
        ]);

        $session = MentoringSession::where('mentor_id', Auth::id())
            ->where('id', $sessionId)
            ->firstOrFail();

        $session->update([
            'mentor_notes' => $request->mentor_notes
        ]);

        return redirect()->back()
            ->with('success', 'Catatan berhasil ditambahkan.');
    }
}