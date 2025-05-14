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
    ];

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

    /**
     * Get the mentor profile for this user.
     */
    public function mentorProfile()
    {
        return $this->hasOne(MentorProfile::class);
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is mentor.
     *
     * @return bool
     */
    public function isMentor()
    {
        return $this->role === 'mentor';
    }

    /**
     * Check if user is student.
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === 'pelajar';
    }
}