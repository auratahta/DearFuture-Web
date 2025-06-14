<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MentoringSession;
use App\Models\Subject;
use App\Models\Payment;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Statistik untuk dashboard dengan error handling
            $totalMentors = User::where('role', 'mentor')->count();
            $totalStudents = User::where('role', 'pelajar')->count();
            
            // PERBAIKAN: Safe counting untuk models yang mungkin belum ada
            $totalSessions = $this->safeModelCount(MentoringSession::class);
            $pendingPayments = $this->safeModelCount(Payment::class, ['status' => 'pending']);
            $totalSubjects = $this->safeModelCount(Subject::class);
            
            // Additional statistics
            $stats = [
                'total_mentors' => $totalMentors,
                'total_students' => $totalStudents,
                'total_sessions' => $totalSessions,
                'pending_payments' => $pendingPayments,
                'total_subjects' => $totalSubjects,
                // Additional stats
                'active_mentors' => User::where('role', 'mentor')->where('is_active', true)->count(),
                'active_students' => User::where('role', 'pelajar')->where('is_active', true)->count(),
                'active_subjects' => $this->safeModelCount(Subject::class, ['is_active' => true]),
                'today_sessions' => $this->safeModelCount(MentoringSession::class, ['date' => Carbon::today()]),
                'this_week_sessions' => $this->getThisWeekSessions(),
                'this_month_sessions' => $this->getThisMonthSessions(),
                'available_slots' => $this->getAvailableSlots(),
                'confirmed_sessions' => $this->safeModelCount(MentoringSession::class, ['status' => 'confirmed']),
                'completed_sessions' => $this->safeModelCount(MentoringSession::class, ['status' => 'completed']),
                'cancelled_sessions' => $this->safeModelCount(MentoringSession::class, ['status' => 'cancelled']),
            ];
            
            // PERBAIKAN: Safe query untuk recent users
            $recentUsers = User::with(['mentorProfile'])
                              ->latest()
                              ->limit(10)
                              ->get();
            
            // PERBAIKAN: Safe query untuk recent sessions dengan proper eager loading
            $recentSessions = $this->getRecentSessions();
            
            // Recent news if exists
            $recentNews = $this->getRecentNews();
            
            // Recent payments if exists
            $recentPayments = $this->getRecentPayments();
            
            return view('admin.dashboard', compact(
                'stats',
                'recentUsers',
                'recentSessions',
                'recentNews',
                'recentPayments',
                // Legacy support - pass individual stats as well
                'totalMentors',
                'totalStudents',
                'totalSessions',
                'pendingPayments',
                'totalSubjects'
            ));
            
        } catch (\Exception $e) {
            // Log error and return with empty data
            \Log::error('Dashboard loading error: ' . $e->getMessage());
            
            return view('admin.dashboard', [
                'stats' => $this->getEmptyStats(),
                'recentUsers' => collect(),
                'recentSessions' => collect(),
                'recentNews' => collect(),
                'recentPayments' => collect(),
                'totalMentors' => 0,
                'totalStudents' => 0,
                'totalSessions' => 0,
                'pendingPayments' => 0,
                'totalSubjects' => 0,
                'error' => 'Error loading dashboard data. Please check system configuration.'
            ]);
        }
    }
    
    /**
     * Safe model counting with error handling
     */
    private function safeModelCount($modelClass, $conditions = [])
    {
        try {
            if (!class_exists($modelClass)) {
                return 0;
            }
            
            $query = $modelClass::query();
            
            foreach ($conditions as $field => $value) {
                if ($field === 'date' && $value instanceof Carbon) {
                    $query->whereDate($field, $value);
                } else {
                    $query->where($field, $value);
                }
            }
            
            return $query->count();
        } catch (\Exception $e) {
            \Log::warning("Error counting {$modelClass}: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get recent sessions safely
     */
    private function getRecentSessions()
    {
        try {
            if (!class_exists(MentoringSession::class)) {
                return collect();
            }
            
            return MentoringSession::with(['student', 'mentor', 'subject'])
                                  ->latest()
                                  ->limit(5)
                                  ->get()
                                  ->map(function ($session) {
                                      // Ensure all relationships are loaded properly
                                      return (object) [
                                          'id' => $session->id,
                                          'student' => $session->student,
                                          'mentor' => $session->mentor,
                                          'subject' => $session->subject,
                                          'date' => $session->date,
                                          'start_time' => $session->start_time,
                                          'end_time' => $session->end_time,
                                          'status' => $session->status,
                                          'formatted_start_time' => $session->formatted_start_time ?? '--:--',
                                          'formatted_end_time' => $session->formatted_end_time ?? '--:--',
                                          'status_text' => $session->status_text ?? ucfirst($session->status),
                                          'status_badge_class' => $session->status_badge_class ?? 'bg-secondary',
                                          'canBeModified' => method_exists($session, 'canBeModified') ? $session->canBeModified() : false
                                      ];
                                  });
        } catch (\Exception $e) {
            \Log::warning('Error loading recent sessions: ' . $e->getMessage());
            return collect();
        }
    }
    
    /**
     * Get recent news safely
     */
    private function getRecentNews()
    {
        try {
            if (!class_exists(News::class)) {
                return collect();
            }
            
            return News::latest()
                      ->limit(5)
                      ->get();
        } catch (\Exception $e) {
            \Log::warning('Error loading recent news: ' . $e->getMessage());
            return collect();
        }
    }
    
    /**
     * Get recent payments safely
     */
    private function getRecentPayments()
    {
        try {
            if (!class_exists(Payment::class)) {
                return collect();
            }
            
            return Payment::with(['student', 'session'])
                         ->latest()
                         ->limit(5)
                         ->get();
        } catch (\Exception $e) {
            \Log::warning('Error loading recent payments: ' . $e->getMessage());
            return collect();
        }
    }
    
    /**
     * Get this week sessions count
     */
    private function getThisWeekSessions()
    {
        try {
            if (!class_exists(MentoringSession::class)) {
                return 0;
            }
            
            return MentoringSession::whereBetween('date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get this month sessions count
     */
    private function getThisMonthSessions()
    {
        try {
            if (!class_exists(MentoringSession::class)) {
                return 0;
            }
            
            return MentoringSession::whereMonth('date', Carbon::now()->month)
                                  ->whereYear('date', Carbon::now()->year)
                                  ->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get available slots count
     */
    private function getAvailableSlots()
    {
        try {
            if (!class_exists(MentoringSession::class)) {
                return 0;
            }
            
            return MentoringSession::where('status', 'available')
                                  ->whereNull('student_id')
                                  ->where('date', '>', Carbon::today())
                                  ->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get empty stats array for error fallback
     */
    private function getEmptyStats()
    {
        return [
            'total_mentors' => 0,
            'total_students' => 0,
            'total_sessions' => 0,
            'pending_payments' => 0,
            'total_subjects' => 0,
            'active_mentors' => 0,
            'active_students' => 0,
            'active_subjects' => 0,
            'today_sessions' => 0,
            'this_week_sessions' => 0,
            'this_month_sessions' => 0,
            'available_slots' => 0,
            'confirmed_sessions' => 0,
            'completed_sessions' => 0,
            'cancelled_sessions' => 0,
        ];
    }
    
    /**
     * Get dashboard statistics for API or AJAX calls
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_mentors' => User::where('role', 'mentor')->count(),
                'total_students' => User::where('role', 'pelajar')->count(),
                'total_sessions' => $this->safeModelCount(MentoringSession::class),
                'pending_payments' => $this->safeModelCount(Payment::class, ['status' => 'pending']),
                'total_subjects' => $this->safeModelCount(Subject::class),
                'today_sessions' => $this->safeModelCount(MentoringSession::class, ['date' => Carbon::today()]),
                'available_slots' => $this->getAvailableSlots(),
            ];
            
            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to load statistics'], 500);
        }
    }
}