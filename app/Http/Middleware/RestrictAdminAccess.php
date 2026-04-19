<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictAdminAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sudah login dan dia adalah Admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            // Kita lempar ke halaman 403 (Forbidden) 
            // Atau bisa kamu redirect ke halaman Dashboard Admin Filament
            abort(403, 'Admins are not permitted to access the customer settings page.');
        }

        return $next($request);
    }
}
