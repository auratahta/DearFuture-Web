<?php
// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'student_id',
        'mentor_id',
        'rating',
        'comment',
        'is_featured',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the session for this review
     */
    public function session()
    {
        return $this->belongsTo(MentoringSession::class, 'session_id');
    }

    /**
     * Get the student who wrote this review
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the mentor being reviewed
     */
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /**
     * Get the subject through the session
     */
    public function subject()
    {
        return $this->hasOneThrough(Subject::class, MentoringSession::class, 'id', 'id', 'session_id', 'subject_id');
    }

    /**
     * Get star display for rating
     */
    public function getStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '★';
            } else {
                $stars .= '☆';
            }
        }
        return $stars;
    }

    /**
     * Scope for featured reviews
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for specific rating
     */
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope for mentor reviews
     */
    public function scopeForMentor($query, $mentorId)
    {
        return $query->where('mentor_id', $mentorId);
    }

    /**
     * Scope for student reviews
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }
}