<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Cek apakah jabatan user ada dalam roles yang diizinkan
        if (in_array($user->jabatan, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, redirect ke dashboard masing-masing
        if ($user->jabatan === 'Marketing') {
            return redirect()->route('marketing.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}