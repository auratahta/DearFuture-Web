<?php
// app/Http/Controllers/Student/SubjectController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\MentoringSession;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubjectController extends Controller
{
    /**
     * Display a listing of all active subjects.
     */
    public function index()
    {
        // Ambil semua mata pelajaran yang aktif dan urutkan berdasarkan display_order
        $subjects = Subject::where('is_active', true)
                           ->withCount('availableSessions')
                           ->orderBy('display_order')
                           ->get();
                           
        return view('student.subjects', compact('subjects'));
    }
    
    /**
     * Show mentors and available sessions for a specific subject
     */
    public function show($id)
    {
        $subject = Subject::findOrFail($id);
        
        if (!$subject->is_active) {
            return redirect()->route('student.subjects')
                             ->with('error', 'Mata pelajaran tidak tersedia.');
        }
        
        // Ambil mentors yang mengajar subject ini dan memiliki available sessions
        $mentorsWithSessions = $subject->getMentorsWithAvailableSessions();
        
        // Jika tidak ada mentors atau sessions tersedia
        if ($mentorsWithSessions->isEmpty()) {
            return redirect()->route('student.subjects')
                             ->with('error', 'Belum ada mentor atau jadwal tersedia untuk mata pelajaran ini.');
        }
        
        return view('student.subject_mentors', compact('subject', 'mentorsWithSessions'));
    }
    
    /**
     * Find mentors for a specific subject (alternative method)
     */
    public function findMentors(Request $request)
    {
        $subjectId = $request->input('subject');
        
        if (!$subjectId) {
            return redirect()->route('student.subjects');
        }
        
        return $this->show($subjectId);
    }
    
    /**
     * Get available sessions for a subject via AJAX
     */
    public function getAvailableSessions($subjectId)
    {
        $subject = Subject::findOrFail($subjectId);
        
        $sessions = MentoringSession::available()
                                   ->where('subject_id', $subjectId)
                                   ->with(['mentor', 'subject'])
                                   ->orderBy('date')
                                   ->orderBy('start_time')
                                   ->get()
                                   ->map(function($session) {
                                       return [
                                           'id' => $session->id,
                                           'mentor_name' => $session->mentor->name,
                                           'mentor_photo' => $session->mentor->photo_url,
                                           'date' => $session->date->format('Y-m-d'),
                                           'date_formatted' => $session->date->format('d M Y'),
                                           'start_time' => $session->start_time,
                                           'end_time' => $session->end_time,
                                           'duration' => $session->duration_formatted,
                                           'price' => $session->formatted_price,
                                           'price_raw' => $session->price
                                       ];
                                   });
        
        return response()->json($sessions);
    }
}