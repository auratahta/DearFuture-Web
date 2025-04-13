<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MentoringSession;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $upcomingSessions = MentoringSession::where('student_id', $user->id)
                                 ->where('status', 'confirmed')
                                 ->where('date', '>=', now()->format('Y-m-d'))
                                 ->with('mentor', 'subject')
                                 ->orderBy('date')
                                 ->orderBy('start_time')
                                 ->take(5)
                                 ->get();
                                 
        $recommendedMentors = User::where('role', 'mentor')
                               ->whereHas('mentorProfile', function ($query) {
                                   $query->where('is_active', true);
                               })
                               ->with('mentorProfile')
                               ->take(5)
                               ->get();
                               
        $popularSubjects = Subject::withCount('mentors')
                               ->orderBy('mentors_count', 'desc')
                               ->take(5)
                               ->get();
        
        return view('student.dashboard', compact(
            'upcomingSessions',
            'recommendedMentors',
            'popularSubjects'
        ));
    }
}