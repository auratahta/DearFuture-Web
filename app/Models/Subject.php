<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'category', 
        'description', 
        'display_order', 
        'is_active', 
        'icon',
        'color',
        'duration',
        'price',
        'image'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'duration' => 'integer',
        'price' => 'decimal:2'
    ];

    // ===== RELATIONSHIPS =====

    /**
     * PERBAIKAN: Mentors relationship (sesuai dengan User model)
     * Menggunakan mentor_subjects pivot table dengan foreign key yang benar
     */
    public function mentors()
    {
        return $this->belongsToMany(User::class, 'mentor_subjects', 'subject_id', 'mentor_id')
                    ->where('users.role', 'mentor')
                    ->where('users.is_active', true)
                    ->wherePivot('is_active', true)
                    ->withPivot('price_per_hour', 'is_active', 'notes')
                    ->withTimestamps();
    }

    /**
     * PERBAIKAN: All mentors (tanpa filter active) untuk admin
     */
    public function allMentors()
    {
        return $this->belongsToMany(User::class, 'mentor_subjects', 'subject_id', 'mentor_id')
                    ->where('users.role', 'mentor')
                    ->withPivot('price_per_hour', 'is_active', 'notes')
                    ->withTimestamps();
    }

    /**
     * PERBAIKAN: Sessions relationship (sesuai nama method di User model)
     * User model menggunakan mentorSessions(), jadi kita sesuaikan
     */
    public function sessions()
    {
        return $this->hasMany(MentoringSession::class, 'subject_id');
    }

    /**
     * PERBAIKAN: Mentoring sessions (untuk compatibility dengan controller yang ada)
     */
    public function mentoringSession()
    {
        return $this->hasMany(MentoringSession::class, 'subject_id');
    }

    /**
     * PERBAIKAN: Available sessions yang bisa dibooking
     */
    public function availableSessions()
    {
        return $this->hasMany(MentoringSession::class, 'subject_id')
                    ->where('status', 'available')
                    ->whereNull('student_id')
                    ->where('date', '>=', now()->toDateString());
    }

    /**
     * Completed sessions untuk statistik
     */
    public function completedSessions()
    {
        return $this->hasMany(MentoringSession::class, 'subject_id')
                    ->where('status', 'completed');
    }

    /**
     * Booked sessions (sudah ada student)
     */
    public function bookedSessions()
    {
        return $this->hasMany(MentoringSession::class, 'subject_id')
                    ->whereNotNull('student_id')
                    ->whereIn('status', ['booked', 'confirmed', 'ongoing']);
    }

    // ===== SCOPES =====

    /**
     * Scope untuk subject aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk subject dengan sessions tersedia
     */
    public function scopeWithAvailableSessions($query)
    {
        return $query->whereHas('availableSessions');
    }

    /**
     * Scope dengan statistics
     */
    public function scopeWithSessionStats($query)
    {
        return $query->withCount([
            'sessions',
            'availableSessions',
            'completedSessions',
            'bookedSessions'
        ]);
    }

    /**
     * Scope untuk subject berdasarkan category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope untuk subject dengan mentor tertentu
     */
    public function scopeWithMentor($query, $mentorId)
    {
        return $query->whereHas('mentors', function($q) use ($mentorId) {
            $q->where('users.id', $mentorId);
        });
    }

    // ===== ACCESSORS =====

    /**
     * Icon class accessor (untuk FontAwesome icons)
     */
    public function getIconClassAttribute()
    {
        if ($this->icon && str_starts_with($this->icon, 'fa-')) {
            return $this->icon;
        }
        
        // Default icons based on subject name
        $subjectName = strtolower($this->name);
        
        if (str_contains($subjectName, 'math') || str_contains($subjectName, 'matematik')) return 'fa-calculator';
        if (str_contains($subjectName, 'physic') || str_contains($subjectName, 'fisika')) return 'fa-atom';
        if (str_contains($subjectName, 'chemistry') || str_contains($subjectName, 'kimia')) return 'fa-flask';
        if (str_contains($subjectName, 'biology') || str_contains($subjectName, 'biologi')) return 'fa-dna';
        if (str_contains($subjectName, 'english') || str_contains($subjectName, 'inggris')) return 'fa-language';
        if (str_contains($subjectName, 'indonesia') || str_contains($subjectName, 'bahasa')) return 'fa-book';
        if (str_contains($subjectName, 'history') || str_contains($subjectName, 'sejarah')) return 'fa-landmark';
        if (str_contains($subjectName, 'geography') || str_contains($subjectName, 'geografi')) return 'fa-globe';
        if (str_contains($subjectName, 'economics') || str_contains($subjectName, 'ekonomi')) return 'fa-chart-line';
        if (str_contains($subjectName, 'programming') || str_contains($subjectName, 'coding')) return 'fa-code';
        if (str_contains($subjectName, 'computer') || str_contains($subjectName, 'komputer')) return 'fa-laptop';
        
        return $this->icon ?? 'fa-book'; // Default icon
    }

    /**
     * Icon URL accessor (untuk image files)
     */
    public function getIconUrlAttribute()
    {
        if ($this->icon && !str_starts_with($this->icon, 'fa-')) {
            return asset('storage/subjects/' . $this->icon);
        }
        
        // Default images based on subject name
        $subjectName = strtolower($this->name);
        
        if (str_contains($subjectName, 'math') || str_contains($subjectName, 'matematik')) return asset('image/subjects/math.png');
        if (str_contains($subjectName, 'physic') || str_contains($subjectName, 'fisika')) return asset('image/subjects/physics.png');
        if (str_contains($subjectName, 'chemistry') || str_contains($subjectName, 'kimia')) return asset('image/subjects/chemistry.png');
        if (str_contains($subjectName, 'biology') || str_contains($subjectName, 'biologi')) return asset('image/subjects/biology.png');
        if (str_contains($subjectName, 'english') || str_contains($subjectName, 'inggris')) return asset('image/subjects/english.png');
        if (str_contains($subjectName, 'indonesia') || str_contains($subjectName, 'bahasa')) return asset('image/subjects/bahasa.png');
        
        return asset('image/default-subject-icon.png');
    }

    /**
     * Image URL accessor
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/subjects/' . $this->image);
        }
        return $this->icon_url; // Fallback to icon
    }

    /**
     * Color class accessor
     */
    public function getColorClassAttribute()
    {
        if ($this->color) {
            return $this->color;
        }
        
        // Default colors rotation
        $colors = [
            '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', 
            '#FECA57', '#FF9FF3', '#54A0FF', '#5F27CD'
        ];
        
        return $colors[$this->id % count($colors)];
    }

    /**
     * Formatted price accessor
     */
    public function getFormattedPriceAttribute()
    {
        if ($this->price) {
            return 'Rp ' . number_format($this->price, 0, ',', '.');
        }
        return 'Rp 30.000'; // Default price
    }

    /**
     * Available sessions count
     */
    public function getAvailableSessionsCountAttribute()
    {
        return $this->availableSessions()->count();
    }

    /**
     * Total sessions count
     */
    public function getTotalSessionsCountAttribute()
    {
        return $this->sessions()->count();
    }

    /**
     * Completed sessions count
     */
    public function getCompletedSessionsCountAttribute()
    {
        return $this->completedSessions()->count();
    }

    /**
     * Active mentors count
     */
    public function getMentorsCountAttribute()
    {
        return $this->mentors()->count();
    }

    /**
     * Status text accessor
     */
    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    /**
     * Status badge class accessor
     */
    public function getStatusBadgeClassAttribute()
    {
        return $this->is_active ? 'bg-success' : 'bg-secondary';
    }

    // ===== HELPER METHODS =====

    /**
     * Check if subject has available sessions
     */
    public function hasAvailableSessions()
    {
        return $this->availableSessions()->exists();
    }

    /**
     * Get price range untuk subject ini
     */
    public function getPriceRange()
    {
        $sessions = $this->availableSessions();
        
        $minPrice = $sessions->min('price');
        $maxPrice = $sessions->max('price');
        
        if (!$minPrice || !$maxPrice) {
            return $this->formatted_price;
        }
        
        if ($minPrice === $maxPrice) {
            return 'Rp ' . number_format($minPrice, 0, ',', '.');
        }
        
        return 'Rp ' . number_format($minPrice, 0, ',', '.') . 
               ' - Rp ' . number_format($maxPrice, 0, ',', '.');
    }

    /**
     * Get mentors with available sessions for this subject
     * PERBAIKAN: Menggunakan relationship yang benar dari User model
     */
    public function getMentorsWithAvailableSessions()
    {
        return User::where('role', 'mentor')
                   ->where('is_active', true)
                   ->whereHas('mentorSessions', function($q) {
                       $q->where('subject_id', $this->id)
                         ->where('status', 'available')
                         ->whereNull('student_id')
                         ->where('date', '>=', now()->toDateString());
                   })
                   ->with(['mentorSessions' => function($q) {
                       $q->where('subject_id', $this->id)
                         ->where('status', 'available')
                         ->whereNull('student_id')
                         ->where('date', '>=', now()->toDateString())
                         ->orderBy('date')
                         ->orderBy('start_time');
                   }])
                   ->get();
    }

    /**
     * Get next available session for this subject
     */
    public function getNextAvailableSession()
    {
        return $this->availableSessions()
                    ->orderBy('date')
                    ->orderBy('start_time')
                    ->first();
    }

    /**
     * Get sessions untuk hari ini
     */
    public function getTodaysSessions()
    {
        return $this->sessions()
                    ->where('date', now()->toDateString())
                    ->orderBy('start_time')
                    ->get();
    }

    /**
     * Get upcoming sessions (limit)
     */
    public function getUpcomingSessions($limit = 5)
    {
        return $this->availableSessions()
                    ->orderBy('date')
                    ->orderBy('start_time')
                    ->limit($limit)
                    ->get();
    }

    /**
     * Check if mentor teaches this subject
     */
    public function isTaughtByMentor($mentorId)
    {
        return $this->mentors()->where('users.id', $mentorId)->exists();
    }

    /**
     * Add mentor to this subject
     */
    public function addMentor($mentorId, $pricePerHour = null, $isActive = true, $notes = null)
    {
        return $this->mentors()->attach($mentorId, [
            'price_per_hour' => $pricePerHour,
            'is_active' => $isActive,
            'notes' => $notes,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Remove mentor from this subject
     */
    public function removeMentor($mentorId)
    {
        return $this->mentors()->detach($mentorId);
    }

    /**
     * Toggle mentor status for this subject
     */
    public function toggleMentorStatus($mentorId)
    {
        $mentor = $this->mentors()->where('users.id', $mentorId)->first();
        if ($mentor) {
            $this->mentors()->updateExistingPivot($mentorId, [
                'is_active' => !$mentor->pivot->is_active,
                'updated_at' => now()
            ]);
        }
        return $mentor;
    }

    // ===== STATIC METHODS =====

    /**
     * Get popular subjects berdasarkan completed sessions
     */
    public static function popularSubjects($limit = 6)
    {
        return static::withCount([
            'completedSessions as popularity_score'
        ])
        ->where('is_active', true)
        ->orderBy('popularity_score', 'desc')
        ->limit($limit)
        ->get();
    }

    /**
     * Get subjects dengan available sessions
     */
    public static function withAvailableSessionsOnly()
    {
        return static::where('is_active', true)
                    ->whereHas('availableSessions')
                    ->withCount('availableSessions as available_sessions_count')
                    ->orderBy('available_sessions_count', 'desc')
                    ->get();
    }

    /**
     * Search subjects by name or category
     */
    public static function search($query)
    {
        return static::where('is_active', true)
                    ->where(function($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                          ->orWhere('category', 'like', "%{$query}%")
                          ->orWhere('description', 'like', "%{$query}%");
                    });
    }
}