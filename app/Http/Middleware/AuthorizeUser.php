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
        
        if (!$user) {
            return redirect()->route('login');
        }
    
        // Superadmin bisa akses semua
        if ($user->hasRole('superadmin')) {
            return $next($request);
        }
    
        // Cek role yang diizinkan
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }
    
        abort(403, 'Forbidden. Kamu tidak punya akses ke halaman ini');
    }
}
