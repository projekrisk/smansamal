<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWargaIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->isAdmin() && ! $user->is_active) {
            return redirect()->route('dashboard')->with('warning', 'Akun Anda sedang menunggu verifikasi/aktivasi dari pihak sekolah.');
        }

        return $next($request);
    }
}
