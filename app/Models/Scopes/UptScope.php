<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UptScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = Auth::user();

        // Jika user login DAN adalah Admin UPT (bukan Super Admin)
        if ($user && $user->role === 'admin' && $user->upt_id) {
            // Paksa query hanya mengambil data sesuai UPT admin
            $builder->where('upt_id', $user->upt_id);
        }

        // Jika Super Admin (upt_id = null) atau User biasa, tidak ada scope
        // User biasa akan difilter di controller (hanya milik sendiri)
    }

    /**
     * Remove the scope from the given Eloquent query builder.
     */
    public function remove(Builder $builder, Model $model): void
    {
        $builder->withoutGlobalScope($this);
    }
}
