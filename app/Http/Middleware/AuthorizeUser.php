<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param    \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user || !$user->level) {
            return redirect()->route('login');
        }

        $userRole = $user->level->level_kode; // Ambil kode level dari relasi

        // Superadmin bisa akses semua
        if ($userRole === 'SUPADM') {
            return $next($request);
        }

        // Cek apakah role user ada di dalam daftar role yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        return redirect('/forbiddenError');
    }
}
