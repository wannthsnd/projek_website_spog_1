<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Role constants
     */
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

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
        'upt_id',
        'is_active',
        'last_login_at',
    ];

    protected $casts = [
    'last_login_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime', // ✅ Auto-cast to Carbon instance
        ];
    }

    // ============================================
    // 🔗 RELATIONSHIPS
    // ============================================

    /**
     * Get the UPT that owns the user
     */
    public function upt(): BelongsTo
    {
        return $this->belongsTo(Upt::class);
    }

    /**
     * Get all ship permits for this user (by email relationship)
     */
    public function shipPermits(): HasMany
    {
        return $this->hasMany(ShipPermit::class, 'email', 'email');
    }

    /**
     * Get permits for this user by UPT relationship (alternative)
     */
    public function permitsByUpt(): HasMany
    {
        return $this->hasMany(ShipPermit::class, 'upt_id', 'upt_id');
    }

    /**
     * Get active permits only
     */
    public function activePermits(): HasMany
    {
        return $this->shipPermits()->where('status', 'approved');
    }

    /**
     * Get pending permits only
     */
    public function pendingPermits(): HasMany
    {
        return $this->shipPermits()->where('status', 'pending');
    }

    /**
     * Get notifications for this user
     */
    public function notifications()
    {
        return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable');
    }

    // ============================================
    // 👤 ROLE CHECK METHODS
    // ============================================

    /**
     * Check if user is Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Check if user is Admin (UPT Admin)
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is regular User
     */
    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    // ============================================
    // 🏢 UPT CHECK METHODS
    // ============================================

    /**
     * Check if user is assigned to a UPT
     */
    public function hasUpt(): bool
    {
        return $this->upt_id !== null && $this->upt_id > 0;
    }

    /**
     * Check if user is UPT Admin (admin with upt_id)
     */
    public function isUptAdmin(): bool
    {
        return $this->isAdmin() && $this->hasUpt();
    }

    /**
     * Check if user is Super Admin (admin without upt_id)
     */
    public function isGlobalAdmin(): bool
    {
        return $this->isAdmin() && !$this->hasUpt();
    }

    /**
     * Get user's UPT name with fallback
     */
    public function getUptNameAttribute(): string
    {
        return $this->upt?->name ?? 'Global';
    }

    /**
     * Get user's UPT code with fallback
     */
    public function getUptCodeAttribute(): string
    {
        return $this->upt?->code ?? 'GLB';
    }

    /**
     * Get user's UPT region with fallback
     */
    public function getUptRegionAttribute(): string
    {
        return $this->upt?->region ?? '-';
    }

    // ============================================
    // 🔐 PERMISSION & ACCESS CONTROL
    // ============================================

    /**
     * Check if user has permission (role hierarchy)
     */
    public function hasRole(string $role): bool
    {
        $roles = [
            self::ROLE_SUPER_ADMIN => 3,
            self::ROLE_ADMIN => 2,
            self::ROLE_USER => 1,
        ];

        return ($roles[$this->role] ?? 0) >= ($roles[$role] ?? 0);
    }

    /**
     * Check if user can manage another user
     * - Super Admin can manage everyone except other Super Admins
     * - UPT Admin can only manage users in the same UPT
     */
    public function canManage(User $target): bool
    {
        // Cannot manage self
        if ($this->id === $target->id) {
            return false;
        }

        // Super Admin can manage everyone except other Super Admins
        if ($this->isSuperAdmin() && !$target->isSuperAdmin()) {
            return true;
        }

        // UPT Admin can only manage users in the SAME UPT
        if ($this->isUptAdmin() && $target->isUser()) {
            return $this->upt_id === $target->upt_id;
        }

        return false;
    }

    /**
     * Check if user can view a permit
     * - Super Admin: all permits
     * - UPT Admin: permits in same UPT
     * - User: only their own permits
     */
    public function canViewPermit(ShipPermit $permit): bool
    {
        // Super Admin can view all
        if ($this->isSuperAdmin()) {
            return true;
        }

        // UPT Admin can view permits in their UPT
        if ($this->isUptAdmin()) {
            return $this->upt_id === $permit->upt_id;
        }

        // Regular user can only view their own permits
        if ($this->isUser()) {
            return $this->email === $permit->email;
        }

        return false;
    }

    /**
     * Check if user can edit a permit
     */
    public function canEditPermit(ShipPermit $permit): bool
    {
        // Only pending permits can be edited
        if ($permit->status !== 'pending') {
            return false;
        }

        // Super Admin can edit all pending permits
        if ($this->isSuperAdmin()) {
            return true;
        }

        // UPT Admin can edit pending permits in their UPT
        if ($this->isUptAdmin()) {
            return $this->upt_id === $permit->upt_id;
        }

        // Regular user can only edit their own pending permits
        if ($this->isUser()) {
            return $this->email === $permit->email;
        }

        return false;
    }

    /**
     * Check if user can delete a permit
     */
    public function canDeletePermit(ShipPermit $permit): bool
    {
        // Only Super Admin can delete (for safety)
        // Or allow UPT Admin to delete in their UPT if needed
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->isUptAdmin()) {
            return $this->upt_id === $permit->upt_id;
        }

        return false;
    }

    /**
     * Check if user can approve/reject permits
     */
    public function canApprovePermits(): bool
    {
        // Only admins can approve permits
        return $this->isAdmin() || $this->isSuperAdmin();
    }

    /**
     * Check if user can manage UPTs
     */
    public function canManageUpts(): bool
    {
        // Only Super Admin can manage UPTs
        return $this->isSuperAdmin();
    }

    // ============================================
    // 📊 HELPER METHODS & ATTRIBUTES
    // ============================================

    /**
     * Get unread notification count
     */
    public function getUnreadNotificationsCountAttribute(): int
    {
        return $this->unreadNotifications->count();
    }

    /**
     * Get display role name
     */
    public function getRoleNameAttribute(): string
    {
        return [
            self::ROLE_SUPER_ADMIN => 'Super Admin',
            self::ROLE_ADMIN => 'Admin UPT',
            self::ROLE_USER => 'User',
        ][$this->role] ?? 'User';
    }

    /**
     * Get role badge class for UI
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return [
            self::ROLE_SUPER_ADMIN => 'bg-gradient-to-r from-purple-500 to-indigo-600 text-white shadow-lg shadow-purple-500/30',
            self::ROLE_ADMIN => 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg shadow-emerald-500/30',
            self::ROLE_USER => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
        ][$this->role] ?? 'bg-gray-100 text-gray-700';
    }

    /**
     * Get UPT badge class for UI
     */
    public function getUptBadgeClassAttribute(): string
    {
        if (!$this->hasUpt()) {
            return 'bg-gray-100 dark:bg-gray-700 text-gray-500';
        }
        return 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300';
    }

    /**
     * Get avatar initial
     */
    public function getAvatarInitialAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    /**
     * Get last login display (already Carbon, no parse needed)
     */
    public function getLastLoginDisplayAttribute(): string
    {
        if (!$this->last_login_at) {
            return 'Belum pernah login';
        }
        // ✅ last_login_at is already Carbon instance thanks to casts
        return $this->last_login_at->diffForHumans();
    }

    /**
     * Get formatted registration date
     */
    public function getRegisteredDateAttribute(): string
    {
        return $this->created_at->format('d M Y');
    }

    // ============================================
    // 🔍 SCOPES FOR QUERIES
    // ============================================

    /**
     * Scope a query to only include users with a specific role
     */
    public function scopeWhereRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope a query to only include active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive users
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * ✅ Scope a query to only include users in a specific UPT
     */
    public function scopeForUpt($query, $uptId)
    {
        return $query->where('upt_id', $uptId);
    }

    /**
     * ✅ Scope a query to only include users NOT in a specific UPT
     */
    public function scopeNotInUpt($query, $uptId)
    {
        return $query->where('upt_id', '!=', $uptId)->orWhereNull('upt_id');
    }

    /**
     * ✅ Scope a query to only include users without UPT (Super Admin / Global)
     */
    public function scopeWithoutUpt($query)
    {
        return $query->whereNull('upt_id');
    }

    /**
     * ✅ Scope a query to only include users WITH UPT assigned
     */
    public function scopeWithUpt($query)
    {
        return $query->whereNotNull('upt_id');
    }

    /**
     * ✅ Scope a query to search users by name or email
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    /**
     * ✅ Scope a query to order by last login
     */
    public function scopeOrderByLastLogin($query, string $direction = 'desc')
    {
        return $query->orderBy('last_login_at', $direction);
    }

    /**
     * ✅ Scope a query to get admins for a specific UPT
     */
    public function scopeAdminsForUpt($query, $uptId)
    {
        return $query->where('role', self::ROLE_ADMIN)->where('upt_id', $uptId);
    }

    /**
     * ✅ Scope a query to get users for a specific UPT
     */
    public function scopeUsersForUpt($query, $uptId)
    {
        return $query->where('role', self::ROLE_USER)->where('upt_id', $uptId);
    }

    /**
     * ✅ Scope a query to get all users (admin + user) for a specific UPT
     */
    public function scopeAllForUpt($query, $uptId)
    {
        return $query->whereIn('role', [self::ROLE_ADMIN, self::ROLE_USER])
                     ->where('upt_id', $uptId);
    }

    /**
     * ✅ Scope a query to get users by UPT with role filter
     */
    public function scopeByUptAndRole($query, $uptId, $role)
    {
        return $query->where('upt_id', $uptId)->where('role', $role);
    }

    /**
     * ✅ Scope a query to get users with UPT info eager loaded
     */
    public function scopeWithUptInfo($query)
    {
        return $query->with('upt:id,name,code,region');
    }

    /**
     * ✅ Scope a query to get users count grouped by UPT
     */
    public function scopeCountByUpt($query)
    {
        return $query->select('upt_id', \DB::raw('count(*) as total'))
                     ->groupBy('upt_id');
    }

    // ============================================
    // 🔄 BOOT METHOD FOR AUTO-FILL
    // ============================================

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set upt_id for new users if not provided
        static::creating(function ($user) {
            if (!$user->upt_id && auth()->check()) {
                $currentUser = auth()->user();
                // If current user is UPT Admin, assign same UPT to new user
                if ($currentUser->isUptAdmin()) {
                    $user->upt_id = $currentUser->upt_id;
                }
            }
        });
    }
}
