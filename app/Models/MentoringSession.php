<?php
// app/Models/MentoringSession.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class MentoringSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'student_id',
        'subject_id',
        'date',
        'start_time',
        'end_time',
        'price',
        'status',
        'meeting_link',
        'notes',
        'student_notes',
        'mentor_notes',
        'rating',
        'feedback',
        'completed_at',
        'cancelled_at',
        'cancellation_reason',
        'reschedule_reason',
        'meeting_started_at',
        'meeting_ended_at',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'meeting_started_at' => 'datetime',
        'meeting_ended_at' => 'datetime',
    ];

    // Relationships
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->whereNull('student_id');
    }

    public function scopeBooked($query)
    {
        return $query->whereNotNull('student_id');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeForMentor($query, $mentorId)
    {
        return $query->where('mentor_id', $mentorId);
    }

    // Accessors untuk compatibility dengan view yang ada
    
    public function getStartTimeAttribute($value)
    {
        if (!$value) return null;
        // Jika sudah dalam format Carbon time, kembalikan langsung
        if ($value instanceof Carbon) {
            return $value;
        }
        // Parse dari string time
        try {
            return Carbon::createFromFormat('H:i:s', $value);
        } catch (\Exception $e) {
            try {
                return Carbon::createFromFormat('H:i', $value);
            } catch (\Exception $e2) {
                return Carbon::parse($value);
            }
        }
    }

    public function getEndTimeAttribute($value)
    {
        if (!$value) return null;
        // Jika sudah dalam format Carbon time, kembalikan langsung
        if ($value instanceof Carbon) {
            return $value;
        }
        // Parse dari string time
        try {
            return Carbon::createFromFormat('H:i:s', $value);
        } catch (\Exception $e) {
            try {
                return Carbon::createFromFormat('H:i', $value);
            } catch (\Exception $e2) {
                return Carbon::parse($value);
            }
        }
    }

    public function getDurationAttribute()
    {
        if ($this->getOriginal('start_time') && $this->getOriginal('end_time')) {
            try {
                $start = Carbon::createFromFormat('H:i:s', $this->getOriginal('start_time'));
                $end = Carbon::createFromFormat('H:i:s', $this->getOriginal('end_time'));
                return $start->diffInMinutes($end);
            } catch (\Exception $e) {
                return 90; // default 90 minutes
            }
        }
        return 90; // default 90 minutes
    }

    public function getDurationFormattedAttribute()
    {
        $duration = $this->duration;
        if ($duration >= 60) {
            $hours = floor($duration / 60);
            $minutes = $duration % 60;
            if ($minutes > 0) {
                return "{$hours}j {$minutes}m";
            }
            return "{$hours}j";
        }
        return "{$duration}m";
    }

    public function getFormattedPriceAttribute()
    {
        if ($this->price > 0) {
            return 'Rp ' . number_format($this->price, 0, ',', '.');
        }
        return 'Gratis';
    }

    public function getStatusTextAttribute()
    {
        $statusTexts = [
            'available' => 'Tersedia',
            'booked' => 'Dipesan',
            'pending' => 'Menunggu Pembayaran',
            'confirmed' => 'Dikonfirmasi',
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $statusTexts[$this->status] ?? ucfirst($this->status);
    }

    // Boolean checks untuk view compatibility
    
    public function getIsBookedAttribute()
    {
        return !is_null($this->student_id);
    }

    public function getIsAvailableForBookingAttribute()
    {
        return $this->status === 'available' && 
               is_null($this->student_id) && 
               $this->date >= now()->toDateString();
    }

    public function getCanBeBookedAttribute()
    {
        return $this->is_available_for_booking;
    }

    public function getHasMeetingLinkAttribute()
    {
        return !is_null($this->meeting_link);
    }

    public function getIsUpcomingAttribute()
    {
        return $this->date >= now()->toDateString() && 
               in_array($this->status, ['booked', 'confirmed', 'ongoing']);
    }

    public function getCanBeCancelledAttribute()
    {
        if (!in_array($this->status, ['booked', 'confirmed'])) {
            return false;
        }
        
        if (!$this->date || $this->date < now()->toDateString()) {
            return false;
        }
        
        // Tidak bisa dibatalkan jika sesi dimulai dalam 2 jam
        if ($this->date->isToday() && $this->getOriginal('start_time')) {
            try {
                $sessionDateTime = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->getOriginal('start_time'));
                if ($sessionDateTime->diffInHours(now()) < 2) {
                    return false;
                }
            } catch (\Exception $e) {
                // Jika ada error parsing, izinkan pembatalan
                return true;
            }
        }
        
        return true;
    }

    public function getCanBeRescheduledAttribute()
    {
        return in_array($this->status, ['booked', 'confirmed']) && 
               $this->date >= now()->addDay()->toDateString(); // At least 1 day notice
    }

    public function getCanStartAttribute()
    {
        if (!$this->has_meeting_link || $this->status !== 'confirmed') {
            return false;
        }

        if (!$this->date || !$this->getOriginal('start_time')) {
            return false;
        }

        try {
            $sessionDateTime = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->getOriginal('start_time'));
            $now = now();
            
            // Can start 15 minutes before session time
            return $now->gte($sessionDateTime->subMinutes(15));
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getSessionDateTimeAttribute()
    {
        if ($this->date && $this->getOriginal('start_time')) {
            try {
                // Gunakan getOriginal untuk mendapatkan nilai raw dari database
                $dateString = $this->date instanceof Carbon ? $this->date->format('Y-m-d') : $this->date;
                $timeString = $this->getOriginal('start_time');
                
                // Bersihkan time string jika ada format yang aneh
                if (is_string($timeString)) {
                    // Jika time string sudah mengandung tanggal, ambil bagian waktu saja
                    if (strpos($timeString, ' ') !== false) {
                        $parts = explode(' ', $timeString);
                        $timeString = end($parts); // Ambil bagian terakhir sebagai waktu
                    }
                }
                
                return Carbon::parse($dateString . ' ' . $timeString);
            } catch (\Exception $e) {
                \Log::error('Error parsing session datetime: ' . $e->getMessage(), [
                    'date' => $this->date,
                    'start_time' => $this->getOriginal('start_time'),
                    'session_id' => $this->id
                ]);
                return null;
            }
        }
        return null;
    }

    public function getTimeRemainingAttribute()
    {
        if (!$this->session_date_time) {
            return null;
        }

        try {
            $now = now();
            $sessionTime = $this->session_date_time;

            if ($now->gte($sessionTime)) {
                return 'Waktu Sesi!';
            }

            $diff = $now->diff($sessionTime);
            
            if ($diff->days > 0) {
                return $diff->days . 'h ' . $diff->h . 'j ' . $diff->i . 'm';
            } elseif ($diff->h > 0) {
                return $diff->h . 'j ' . $diff->i . 'm';
            } else {
                return $diff->i . 'm';
            }
        } catch (\Exception $e) {
            return 'Error';
        }
    }

    // Helper Methods yang digunakan di view
    
    public function isOwnedByStudent($studentId)
    {
        return $this->student_id === $studentId;
    }

    public function canBeAccessedByStudent($studentId)
    {
        return $this->status === 'available' || $this->student_id === $studentId;
    }

    public function markAsBooked($studentId, $notes = null)
    {
        return $this->update([
            'student_id' => $studentId,
            'status' => 'booked',
            'student_notes' => $notes,
        ]);
    }

    public function markAsConfirmed()
    {
        return $this->update([
            'status' => 'confirmed',
        ]);
    }

    public function markAsCompleted($feedback = null, $rating = null)
    {
        return $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'feedback' => $feedback,
            'rating' => $rating,
        ]);
    }

    public function markAsCancelled($reason = null, $removeStudent = true)
    {
        $data = [
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ];

        if ($removeStudent) {
            $data['student_id'] = null; // Make slot available again
            $data['status'] = 'available'; // Make slot available for booking again
        }

        return $this->update($data);
    }

    // Methods untuk format yang digunakan di view
    
    public function getDateFormattedAttribute()
    {
        return $this->date ? $this->date->format('l, d F Y') : null;
    }

    public function getTimeFormattedAttribute()
    {
        if ($this->getOriginal('start_time') && $this->getOriginal('end_time')) {
            try {
                $start = Carbon::createFromFormat('H:i:s', $this->getOriginal('start_time'))->format('H:i');
                $end = Carbon::createFromFormat('H:i:s', $this->getOriginal('end_time'))->format('H:i');
                return $start . ' - ' . $end;
            } catch (\Exception $e) {
                try {
                    $start = Carbon::parse($this->getOriginal('start_time'))->format('H:i');
                    $end = Carbon::parse($this->getOriginal('end_time'))->format('H:i');
                    return $start . ' - ' . $end;
                } catch (\Exception $e2) {
                    return 'Waktu tidak tersedia';
                }
            }
        }
        return 'Waktu tidak tersedia';
    }

    public function getShortTimeFormattedAttribute()
    {
        if ($this->getOriginal('start_time')) {
            try {
                return Carbon::createFromFormat('H:i:s', $this->getOriginal('start_time'))->format('H:i');
            } catch (\Exception $e) {
                try {
                    return Carbon::parse($this->getOriginal('start_time'))->format('H:i');
                } catch (\Exception $e2) {
                    return 'N/A';
                }
            }
        }
        return 'N/A';
    }

    // Static helper methods
    
    public static function createAvailableSlot($mentorId, $subjectId, $date, $startTime, $endTime, $price = 30000)
    {
        return static::create([
            'mentor_id' => $mentorId,
            'subject_id' => $subjectId,
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $price,
            'status' => 'available',
            'student_id' => null,
        ]);
    }

    public static function getAvailableSlots($filters = [])
    {
        $query = static::with(['mentor', 'subject'])
                      ->where('status', 'available')
                      ->whereNull('student_id')
                      ->where('date', '>=', now()->toDateString());

        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, $value);
            }
        }

        return $query->orderBy('date')->orderBy('start_time')->get();
    }

    public static function getStudentSessions($studentId, $status = null)
    {
        $query = static::with(['mentor', 'subject'])
                      ->where('student_id', $studentId);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('date', 'desc')->orderBy('start_time', 'desc')->get();
    }

    // Helper method untuk debugging
    public function debugDateTime()
    {
        return [
            'date_raw' => $this->getOriginal('date'),
            'date_cast' => $this->date,
            'start_time_raw' => $this->getOriginal('start_time'),
            'end_time_raw' => $this->getOriginal('end_time'),
            'session_date_time' => $this->session_date_time?->toISOString(),
        ];
    }
}