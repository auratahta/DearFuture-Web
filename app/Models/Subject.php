<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category',
        'description',
        'display_order',
        'is_active',
        'icon',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the mentors for this subject.
     */
    public function mentors()
    {
        return $this->belongsToMany(User::class, 'mentor_subjects', 'subject_id', 'user_id')
                   ->where('role', 'mentor')
                   ->withTimestamps();
    }

    /**
     * Get the students enrolled in this subject.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'student_subjects', 'subject_id', 'user_id')
                   ->where('role', 'pelajar')
                   ->withTimestamps();
    }
}