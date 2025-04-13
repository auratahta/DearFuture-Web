<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentoringSession extends Model
{
    use HasFactory;

    protected $table = 'mentoring_sessions';

    protected $fillable = [
        'mentor_id',
        'student_id',
        'subject_id',
        'date',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'mentoring_session_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'mentoring_session_id');
    }
}