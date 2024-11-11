<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfProfileIncomplete
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Daftar route yang diizinkan meskipun profil belum lengkap
            $allowedRoutes = [
                'profile.edit',
                'profile.update',
                'logout',
                'home',
                'welcome',
                'orders.index',
                'orders.show',
                'orders.track'
            ];

            // Jika profil belum lengkap dan bukan di route yang diizinkan
            if (!$user->is_profile_complete && !in_array($request->route()->getName(), $allowedRoutes)) {
                return redirect()->route('profile.edit')
                    ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
