<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MentoringSession;
use App\Models\Subject;
use App\Models\Payment;
use App\Models\News;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard
        $totalMentors = User::where('role', 'mentor')->count();
        $totalStudents = User::where('role', 'pelajar')->count();
        $totalSessions = MentoringSession::count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $totalSubjects = Subject::count();
        
        // Daftar user terbaru
        $recentUsers = User::all()
                        ->take(10);
        
        // Daftar sesi terbaru
        $recentSessions = MentoringSession::with(['mentor', 'student', 'subject'])
                            ->latest()
                            ->take(5)
                            ->get();
        
        return view('admin.dashboard', compact(
            'totalMentors',
            'totalStudents',
            'totalSessions',
            'pendingPayments',
            'totalSubjects',
            'recentUsers',
            'recentSessions'
        ));
    }
}