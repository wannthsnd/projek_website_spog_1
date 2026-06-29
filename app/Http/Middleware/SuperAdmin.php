<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is super admin
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Please login first.'], 401);
            }
            abort(403, 'Akses ditolak. Silakan login terlebih dahulu.');
        }

        if (!auth()->user()->isSuperAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Super admin access required.'], 403);
            }
            abort(403, 'Akses ditolak. Diperlukan hak akses Super Admin.');
        }

        // Update last login - ensure proper datetime format
        try {
            auth()->user()->update([
                'last_login_at' => Carbon::now()
            ]);
        } catch (\Exception $e) {
            // Log error but don't block the request
            \Log::error('Error updating last_login_at: ' . $e->getMessage());
        }

        return $next($request);
    }
}
