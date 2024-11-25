<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Pastikan pengguna terautentikasi
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Periksa apakah pengguna memiliki salah satu peran yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
