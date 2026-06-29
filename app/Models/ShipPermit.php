<?php

namespace App\Models;

use App\Models\Scopes\UptScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipPermit extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ship_permits';

    /**
     * The attributes that are mass assignable.
     * Sesuai dengan format PM 28 TAHUN 2022
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Identitas Pemohon
        'user_id',
        'upt_id',
        'email',
        'name',

        // Data Kapal (Sesuai Format SPOG PM 28/2022)
        'ship_name',              // ✅ Nama Kapal
        'ship_type',              // ✅ Jenis Kapal
        'flag',                   // ✅ Bendera
        'gross_tonnage',          // ✅ Isi Kotor (GT)
        'captain_name',           // ✅ Nakhoda
        'owner_agent',            // ✅ Milik/Agent

        // Rute & Keperluan (Sesuai Format SPOG)
        'departure_location',     // ✅ Bergerak dari
        'destination',            // ✅ Ke (dalam DLKr/DLKp)
        'purpose',                // ✅ Keperluan

        // Info Tambahan (Internal Tracking - Optional)
        'passenger_count',        // ⚠️ Jumlah Penumpang (optional)
        'movement_time',          // ⚠️ Waktu Gerak (optional)
        'application_date',       // ✅ Tanggal Pengajuan

        // Status & Approval
        'status',
        'admin_notes',
        'rejection_notes',
        'rejected_at',
        'rejected_by',
        'approved_by',
        'approved_at',

        // Dokumen (5 dokumen wajib sesuai PM 28/2022)
        'document_1',             // ✅ Surat Permohonan
        'document_2',             // (tidak digunakan)
        'document_3',             // ✅ Fotokopi Data Awak Kapal
        'document_4',             // ✅ Surat & Dokumen Kapal Asli
        'document_5',             // ✅ Daftar Penumpang (Manifest)
        'document_6',             // ✅ Daftar Muatan (Manifest)
        'document_7',             // (tidak digunakan)
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'passenger_count' => 'integer',
        'gross_tonnage' => 'integer',
        'application_date' => 'date',
        'departure_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'rejection_notes',
        'approved_by',
        'rejected_by',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'pending',
        'passenger_count' => 0,
    ];

    /**
     * Boot method for Global Scope and auto-fill logic.
     */
    protected static function boot(): void
    {
        parent::boot();

        // ✅ Apply Global Scope for UPT security
        static::addGlobalScope(new UptScope);

        // ✅ Auto-fill upt_id when creating (with safety check)
        static::creating(function (self $permit): void {
            if (auth()->check() && auth()->user() && !$permit->upt_id) {
                $permit->upt_id = auth()->user()->upt_id;
            }
        });

        // ✅ Auto-set application_date if not provided
        static::creating(function (self $permit): void {
            if (!$permit->application_date) {
                $permit->application_date = now();
            }
        });
    }

    // =========================================================================
    // RELATIONSHIPS
    // =========================================================================

    /**
     * Get the user that owns the permit.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the UPT that the permit belongs to.
     */
    public function upt(): BelongsTo
    {
        return $this->belongsTo(Upt::class);
    }

    // =========================================================================
    // ACCESSORS & MUTATORS (Laravel 9+ Style)
    // =========================================================================

    /**
     * Get the status badge CSS class.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
            'approved' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
            'rejected' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        };
    }

    /**
     * Get the formatted application date.
     */
    public function getApplicationDateFormattedAttribute(): string
    {
        return self::formatDate($this->application_date);
    }

    /**
     * Get the formatted departure date.
     */
    public function getDepartureDateFormattedAttribute(): string
    {
        return self::formatDate($this->departure_date, 'd F Y');
    }

    // =========================================================================
    // STATIC HELPER METHODS
    // =========================================================================

    /**
     * Format date with fallback.
     *
     * @param  mixed  $date
     * @param  string  $format
     * @return string
     */
    public static function formatDate($date, string $format = 'd M Y'): string
    {
        if (!$date) {
            return '-';
        }

        if ($date instanceof Carbon) {
            return $date->format($format);
        }

        try {
            return Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            return '-';
        }
    }

    /**
     * Format date with diffForHumans.
     *
     * @param  mixed  $date
     * @return string
     */
    public static function formatDiff($date): string
    {
        if (!$date) {
            return '-';
        }

        if ($date instanceof Carbon) {
            return $date->diffForHumans();
        }

        try {
            return Carbon::parse($date)->diffForHumans();
        } catch (\Exception $e) {
            return '-';
        }
    }

    // =========================================================================
    // QUERY SCOPES
    // =========================================================================

    /**
     * Scope a query to only include pending permits.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved permits.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include rejected permits.
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope a query to only include permits for a specific UPT.
     */
    public function scopeForUpt(Builder $query, int $uptId): Builder
    {
        return $query->where('upt_id', $uptId);
    }

    /**
     * Scope a query to only include permits for a specific user.
     */
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to order by latest application date.
     */
    public function scopeLatestApplications(Builder $query): Builder
    {
        return $query->orderBy('application_date', 'desc');
    }

    /**
     * Scope a query to search permits.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('ship_name', 'like', "%{$search}%")
              ->orWhere('ship_type', 'like', "%{$search}%")
              ->orWhere('captain_name', 'like', "%{$search}%")
              ->orWhere('owner_agent', 'like', "%{$search}%")
              ->orWhere('purpose', 'like', "%{$search}%")
              ->orWhereHas('user', function (Builder $u) use ($search) {
                  $u->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
              });
        });
    }

    // =========================================================================
    // INSTANCE HELPER METHODS
    // =========================================================================

    /**
     * Check if the permit can be edited.
     */
    public function canBeEdited(): bool
    {
        return in_array($this->status, ['pending', 'rejected'], true);
    }

    /**
     * Check if the permit is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the permit is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the permit is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if the permit can be downloaded as SPOG.
     */
    public function canDownloadSpog(): bool
    {
        return $this->isApproved();
    }

    /**
     * Get rejection notes with fallback.
     */
    public function getRejectionNotesWithFallback(): string
    {
        return $this->rejection_notes ?? 'Tidak ada catatan penolakan.';
    }

    /**
     * Check if user can edit this permit.
     *
     * @param  \App\Models\User|null  $user
     * @return bool
     */
    public function canBeEditedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        // Super admin can edit all
        if ($user->isSuperAdmin()) {
            return true;
        }

        // User can edit their own if pending or rejected
        if ($user->role === 'user' && $this->user_id === $user->id) {
            return $this->canBeEdited();
        }

        // Admin can edit permits in their UPT
        if ($user->role === 'admin' && $this->upt_id === $user->upt_id) {
            return true;
        }

        return false;
    }

    /**
     * Get permit status as human readable text.
     */
    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get permit status color for UI.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'amber',
            'approved' => 'emerald',
            'rejected' => 'rose',
            default => 'gray',
        };
    }

    /**
     * Get permit status icon.
     */
    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bi-clock-history',
            'approved' => 'bi-check-circle',
            'rejected' => 'bi-x-circle',
            default => 'bi-question-circle',
        };
    }

    // =========================================================================
    // ADDITIONAL METHODS
    // =========================================================================

    /**
     * Approve the permit.
     *
     * @param  string|null  $approvedBy
     * @return bool
     */
    public function approve(?string $approvedBy = null): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_by' => $approvedBy ?? (auth()->user()?->name),
            'approved_at' => now(),
            'rejection_notes' => null,
            'rejected_at' => null,
            'rejected_by' => null,
        ]);
    }

    /**
     * Reject the permit.
     *
     * @param  string  $notes
     * @param  string|null  $rejectedBy
     * @return bool
     */
    public function reject(string $notes, ?string $rejectedBy = null): bool
    {
        return $this->update([
            'status' => 'rejected',
            'rejection_notes' => $notes,
            'rejected_by' => $rejectedBy ?? (auth()->user()?->name),
            'rejected_at' => now(),
        ]);
    }

    /**
     * Reset permit to pending status (for resubmission).
     *
     * @return bool
     */
    public function resetToPending(): bool
    {
        return $this->update([
            'status' => 'pending',
            'rejection_notes' => null,
            'rejected_at' => null,
            'rejected_by' => null,
            'approved_at' => null,
            'approved_by' => null,
        ]);
    }
}
