<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Admin bisa akses semua
        if ($userRole === 'admin') {
            return $next($request);
        }

        // Jika role user tidak ada dalam daftar role yang diperbolehkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}