<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'student_id', 
        'amount',
        'payment_method',
        'payment_code',
        'status',
        'provider',
        'provider_transaction_id',
        'provider_response',
        'phone',
        'notes',
        'attempted_at',
        'paid_at',
        'failed_at',
        'refunded_at',
        'expires_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'provider_response' => 'array',
        'attempted_at' => 'datetime',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
        'refunded_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    // ===== RELATIONSHIPS =====

    public function session()
    {
        return $this->belongsTo(MentoringSession::class, 'session_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // ===== ACCESSORS =====

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at < now() && $this->status === 'pending';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }
}