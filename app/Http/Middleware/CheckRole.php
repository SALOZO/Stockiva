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
    public function handle(Request $request, Closure $next, ...$roles){
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Cek apakah jabatan user ada dalam roles yang diizinkan
        if (in_array($user->jabatan, $roles)) {
            return $next($request);
        }

        $redirect = match($user->jabatan) {
            'Marketing' => redirect()->route('marketing.dashboard'),
            'Direktur' => redirect()->route('direktur.sph.index'),
            'Gudang' => redirect()->route('gudang.tugas-gudang.index'),
            'Keuangan' => redirect()->route('keuangan.index'),
            default => redirect()->route('login')
        };

        return $redirect->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}