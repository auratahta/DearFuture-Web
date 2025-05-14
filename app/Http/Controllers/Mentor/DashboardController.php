<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\MentoringSession;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Load user with mentorProfile relation to reduce database queries
        $user = Auth::user()->load('mentorProfile');
        
        // Check if the user is a mentor
        if (!$user->isMentor()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        $upcomingSessions = MentoringSession::where('mentor_id', $user->id)
                                 ->where('status', 'confirmed')
                                 ->where('date', '>=', now()->format('Y-m-d'))
                                 ->with('student', 'subject')
                                 ->orderBy('date')
                                 ->orderBy('start_time')
                                 ->take(5)
                                 ->get();
                                 
        $recentReviews = Review::where('mentor_id', $user->id)
                             ->with('student')
                             ->latest()
                             ->take(5)
                             ->get();
        
        $totalSessions = MentoringSession::where('mentor_id', $user->id)->count();
        $totalStudents = MentoringSession::where('mentor_id', $user->id)
                                      ->distinct('student_id')
                                      ->count('student_id');
        
        return view('mentor.dashboard_mentor', compact(
            'user', // Pass user data to the view
            'upcomingSessions',
            'recentReviews',
            'totalSessions',
            'totalStudents'
        ));
    }
}