<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetRequest extends Model
{
    protected $fillable = [
        'email',
        'status',
        'temporary_password',
        'verified_by',
        'admin_notes',
        'approved_at',
        'completed_at',
        'expires_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns this request
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Check if request is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if request is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if request is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if request is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if request is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if request is valid for use
     */
    public function isValid(): bool
    {
        return $this->isApproved() && !$this->isExpired() && !$this->isCompleted();
    }

    /**
     * Get pending requests count
     */
    public static function getPendingCount(): int
    {
        return static::where('status', 'pending')
            ->where('expires_at', '>', now())
            ->count();
    }
}
