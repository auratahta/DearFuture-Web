<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'bio',
        'school',
        'birthdate',
        'parent_name',
        'parent_phone',
        'photo',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthdate' => 'date',
        'is_active' => 'boolean',
    ];

    // ===== SUBJECT RELATIONSHIPS =====

    /**
     * Get the subjects taught by this mentor.
     */
    public function taughtSubjects()
    {
        if ($this->role !== 'mentor') {
            return null;
        }
        
        return $this->belongsToMany(Subject::class, 'mentor_subjects', 'user_id', 'subject_id')
                   ->withTimestamps();
    }

    /**
     * PERBAIKAN: Mentor subjects relationship untuk SessionController
     * Sesuaikan dengan foreign key yang benar
     */
    public function mentorSubjects()
    {
        return $this->belongsToMany(Subject::class, 'mentor_subjects', 'mentor_id', 'subject_id')
                   ->withPivot('price_per_hour', 'is_active', 'notes')
                   ->withTimestamps();
    }

    /**
     * Get the subjects taken by this student.
     */
    public function enrolledSubjects()
    {
        if ($this->role !== 'pelajar') {
            return null;
        }
        
        return $this->belongsToMany(Subject::class, 'student_subjects', 'user_id', 'subject_id')
                   ->withTimestamps();
    }

    // ===== SESSION RELATIONSHIPS =====

    /**
     * Get sessions where this user is the student
     */
    public function studentSessions()
    {
        return $this->hasMany(MentoringSession::class, 'student_id');
    }

    /**
     * Get sessions where this user is the mentor
     */
    public function mentorSessions()
    {
        return $this->hasMany(MentoringSession::class, 'mentor_id');
    }

    /**
     * TAMBAHAN: Alias untuk compatibility dengan Subject model dan StudentSessionController
     * Subject model dan controller mencari 'mentoredSessions'
     */
    public function mentoredSessions()
    {
        return $this->mentorSessions();
    }

    /**
     * Available sessions as mentor
     */
    public function availableSessionsAsMentor()
    {
        return $this->hasMany(MentoringSession::class, 'mentor_id')
                    ->where('status', 'available')
                    ->whereNull('student_id')
                    ->where('date', '>=', now()->toDateString());
    }

    /**
     * PERBAIKAN: Sessions as mentor for specific subject
     */
    public function availableSessionsForSubject($subjectId)
    {
        return $this->availableSessionsAsMentor()
                    ->where('subject_id', $subjectId);
    }

    /**
     * PERBAIKAN: Check if mentor teaches a subject
     */
    public function teachesSubject($subjectId)
    {
        return $this->mentorSubjects()->where('subject_id', $subjectId)->exists();
    }

    // ===== OTHER RELATIONSHIPS =====

    /**
     * Get the mentor profile for this user.
     */
    public function mentorProfile()
    {
        return $this->hasOne(MentorProfile::class);
    }

    /**
     * Get payments made by this user (as student)
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    /**
     * Get reviews written by this user (as student)
     */
    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'student_id');
    }

    /**
     * Get reviews received by this user (as mentor)
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'mentor_id');
    }

    // ===== ROLE CHECKS =====

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is mentor.
     */
    public function isMentor()
    {
        return $this->role === 'mentor';
    }

    /**
     * Check if user is student.
     */
    public function isStudent()
    {
        return $this->role === 'pelajar';
    }

    // ===== ACCESSORS =====

    /**
     * PERBAIKAN: Get avatar URL (alternative name untuk photo)
     */
    public function getAvatarAttribute()
    {
        return $this->photo_url; // Alias untuk photo_url
    }

    /**
     * Get user's photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        
        return asset('image/profile.png');
    }

    /**
     * TAMBAHAN: Accessor untuk status active/inactive
     */
    public function getIsActiveAttribute($value)
    {
        return (bool) $value;
    }

    /**
     * TAMBAHAN: Accessor untuk status text
     */
    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    /**
     * TAMBAHAN: Accessor untuk status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return $this->is_active ? 'bg-success' : 'bg-secondary';
    }

    /**
     * Get formatted phone number
     */
    public function getFormattedPhoneAttribute()
    {
        if (!$this->phone) return null;
        
        // Format Indonesian phone number
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }
        
        return '+' . $phone;
    }

    /**
     * Get user's full name with role
     */
    public function getDisplayNameAttribute()
    {
        $roleName = match($this->role) {
            'admin' => 'Administrator',
            'mentor' => 'Mentor',
            'pelajar' => 'Student',
            default => 'User'
        };
        
        return $this->name . ' (' . $roleName . ')';
    }

    /**
     * TAMBAHAN: Get title for mentor (untuk view compatibility)
     */
    public function getTitleAttribute()
    {
        if ($this->isMentor()) {
            return 'Expert Mentor';
        }
        return ucfirst($this->role ?? 'User');
    }

    // ===== STATISTICS ACCESSORS =====

    /**
     * Get average rating for mentor
     */
    public function getAverageRatingAttribute()
    {
        if ($this->isMentor()) {
            return $this->reviews()->avg('rating') ?? 0;
        }
        return 0;
    }

    /**
     * Get total reviews count for mentor
     */
    public function getTotalReviewsAttribute()
    {
        if ($this->isMentor()) {
            return $this->reviews()->count();
        }
        return 0;
    }

    /**
     * Get total completed sessions for mentor
     */
    public function getTotalCompletedSessionsAttribute()
    {
        if ($this->isMentor()) {
            return $this->mentorSessions()->where('status', 'completed')->count();
        }
        return 0;
    }

    /**
     * Get total earnings for mentor
     */
    public function getTotalEarningsAttribute()
    {
        if ($this->isMentor()) {
            return $this->mentorSessions()
                        ->where('status', 'completed')
                        ->sum('price');
        }
        return 0;
    }

    /**
     * TAMBAHAN: Get total available slots for mentor
     */
    public function getTotalAvailableSlotsAttribute()
    {
        if ($this->isMentor()) {
            return $this->mentorSessions()
                        ->where('status', 'available')
                        ->where('date', '>', now())
                        ->count();
        }
        return 0;
    }

    /**
     * TAMBAHAN: Get upcoming sessions count
     */
    public function getUpcomingSessionsCountAttribute()
    {
        if ($this->isMentor()) {
            return $this->mentorSessions()
                        ->whereIn('status', ['confirmed', 'pending', 'booked'])
                        ->where('date', '>=', now()->toDateString())
                        ->count();
        } elseif ($this->isStudent()) {
            return $this->studentSessions()
                        ->whereIn('status', ['confirmed', 'pending', 'booked'])
                        ->where('date', '>=', now()->toDateString())
                        ->count();
        }
        return 0;
    }

    // ===== SCOPES =====

    /**
     * Scope for mentors
     */
    public function scopeMentors($query)
    {
        return $query->where('role', 'mentor');
    }

    /**
     * Scope for students
     */
    public function scopeStudents($query)
    {
        return $query->where('role', 'pelajar');
    }

    /**
     * Scope for admins
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * TAMBAHAN: Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * TAMBAHAN: Scope for inactive users
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * TAMBAHAN: Scope for active mentors
     */
    public function scopeActiveMentors($query)
    {
        return $query->where('role', 'mentor')->where('is_active', true);
    }

    /**
     * TAMBAHAN: Scope for active students
     */
    public function scopeActiveStudents($query)
    {
        return $query->where('role', 'pelajar')->where('is_active', true);
    }

    /**
     * TAMBAHAN: Scope for available mentors (active mentors with available slots)
     */
    public function scopeAvailableMentors($query)
    {
        return $query->where('role', 'mentor')
                    ->where('is_active', true)
                    ->whereHas('mentorSessions', function($q) {
                        $q->where('status', 'available')
                          ->whereNull('student_id')
                          ->where('date', '>=', now()->toDateString());
                    });
    }

    /**
     * PERBAIKAN: Scope untuk mentors yang memiliki sessions 
     * (untuk compatibility dengan SessionController)
     */
    public function scopeWhereHas($query, $relation, $callback = null)
    {
        return $query->whereHas($relation, $callback);
    }

    // ===== HELPER METHODS =====

    /**
     * TAMBAHAN: Method untuk activate/deactivate user
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
        return $this;
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
        return $this;
    }

    /**
     * TAMBAHAN: Check if user can be deleted
     */
    public function canBeDeleted()
    {
        // User tidak bisa dihapus jika memiliki sessions yang aktif
        if ($this->isMentor()) {
            return !$this->mentorSessions()
                        ->whereIn('status', ['confirmed', 'ongoing', 'pending', 'booked'])
                        ->exists();
        }
        
        if ($this->isStudent()) {
            return !$this->studentSessions()
                        ->whereIn('status', ['confirmed', 'ongoing', 'pending', 'booked'])
                        ->exists();
        }
        
        return true;
    }

    /**
     * PERBAIKAN: Get mentor sessions with specific filters
     * Untuk compatibility dengan Subject model
     */
    public function getMentorSessionsForSubject($subjectId, $status = 'available')
    {
        return $this->mentorSessions()
                    ->where('subject_id', $subjectId)
                    ->where('status', $status)
                    ->when($status === 'available', function($query) {
                        $query->whereNull('student_id')
                              ->where('date', '>=', now()->toDateString());
                    })
                    ->orderBy('date')
                    ->orderBy('start_time');
    }

    /**
     * Check if mentor has available sessions
     */
    public function hasAvailableSessions()
    {
        return $this->availableSessionsAsMentor()->exists();
    }

    /**
     * PERBAIKAN: Get mentor's subjects with session counts (completed method)
     */
    public function getSubjectsWithSessionCounts()
    {
        if (!$this->isMentor()) {
            return collect();
        }

        return $this->mentorSubjects()
                    ->withCount([
                        'sessions as total_sessions' => function($query) {
                            $query->where('mentor_id', $this->id);
                        },
                        'availableSessions as available_sessions' => function($query) {
                            $query->where('mentor_id', $this->id);
                        },
                        'completedSessions as completed_sessions' => function($query) {
                            $query->where('mentor_id', $this->id);
                        }
                    ])
                    ->get();
    }

    /**
     * TAMBAHAN: Get next session as mentor
     */
    public function getNextSessionAsMentor()
    {
        return $this->mentorSessions()
                    ->whereIn('status', ['confirmed', 'booked'])
                    ->where('date', '>=', now()->toDateString())
                    ->orderBy('date')
                    ->orderBy('start_time')
                    ->first();
    }

    /**
     * TAMBAHAN: Get next session as student
     */
    public function getNextSessionAsStudent()
    {
        return $this->studentSessions()
                    ->whereIn('status', ['confirmed', 'booked'])
                    ->where('date', '>=', now()->toDateString())
                    ->orderBy('date')
                    ->orderBy('start_time')
                    ->first();
    }

    /**
     * TAMBAHAN: Get recent activity
     */
    public function getRecentActivity($limit = 5)
    {
        $activities = collect();

        if ($this->isMentor()) {
            $sessions = $this->mentorSessions()
                           ->whereIn('status', ['completed', 'cancelled'])
                           ->orderBy('updated_at', 'desc')
                           ->limit($limit)
                           ->get();
                           
            foreach ($sessions as $session) {
                $studentName = $session->student ? $session->student->name : 'Student';
                $activities->push([
                    'type' => 'session_' . $session->status,
                    'description' => "Session {$session->status} with {$studentName}",
                    'date' => $session->updated_at,
                    'model' => $session
                ]);
            }
        }

        if ($this->isStudent()) {
            $sessions = $this->studentSessions()
                           ->whereIn('status', ['booked', 'completed', 'cancelled'])
                           ->orderBy('updated_at', 'desc')
                           ->limit($limit)
                           ->get();
                           
            foreach ($sessions as $session) {
                $mentorName = $session->mentor ? $session->mentor->name : 'Mentor';
                $activities->push([
                    'type' => 'session_' . $session->status,
                    'description' => "Session {$session->status} with {$mentorName}",
                    'date' => $session->updated_at,
                    'model' => $session
                ]);
            }
        }

        return $activities->sortByDesc('date')->take($limit);
    }

    /**
     * TAMBAHAN: Get dashboard stats
     */
    public function getDashboardStats()
    {
        if ($this->isMentor()) {
            return [
                'total_sessions' => $this->mentorSessions()->count(),
                'available_sessions' => $this->availableSessionsAsMentor()->count(),
                'completed_sessions' => $this->mentorSessions()->where('status', 'completed')->count(),
                'upcoming_sessions' => $this->upcoming_sessions_count,
                'total_earnings' => $this->total_earnings,
                'average_rating' => round($this->average_rating, 1)
            ];
        }

        if ($this->isStudent()) {
            return [
                'total_sessions' => $this->studentSessions()->count(),
                'completed_sessions' => $this->studentSessions()->where('status', 'completed')->count(),
                'upcoming_sessions' => $this->upcoming_sessions_count,
                'cancelled_sessions' => $this->studentSessions()->where('status', 'cancelled')->count()
            ];
        }

        return [];
    }

    /**
     * TAMBAHAN: Format nama untuk display di view
     */
    public function getDisplayShortNameAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return $words[0] . ' ' . $words[1];
        }
        return $this->name;
    }

    /**
     * TAMBAHAN: Check if mentor is available for booking
     */
    public function isAvailableForBooking()
    {
        return $this->isMentor() && 
               $this->is_active && 
               $this->hasAvailableSessions();
    }

    /**
     * TAMBAHAN: Get formatted experience/bio
     */
    public function getFormattedBioAttribute()
    {
        if (!$this->bio) {
            if ($this->isMentor()) {
                return 'Experienced mentor ready to help you learn.';
            }
            return 'Student eager to learn.';
        }
        
        return $this->bio;
    }
}