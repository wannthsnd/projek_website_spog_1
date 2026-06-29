<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user adalah admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access. Admin only.');
        }

        return $next($request);
    }
}
