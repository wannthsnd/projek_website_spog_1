<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Upt extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'region',
        'alamat',
        'kota',
        'kode_pos',
        'telepon',
        'email',
        'website',
        'tgm',
        'tlx',
        'fax',
        'is_active',
        'kepala_kantor',
        'nip_kepala',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users for this UPT
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the active users count for this UPT
     */
    public function activeUsersCount(): int
    {
        return $this->users()->where('is_active', true)->count();
    }

    /**
     * Get the permits for this UPT
     */
    public function permits(): HasMany
    {
        return $this->hasMany(ShipPermit::class);
    }

    /**
     * Scope a query to only include active UPTs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
