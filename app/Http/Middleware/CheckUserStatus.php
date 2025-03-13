<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status === 'non-aktif') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda nonaktif. Silakan hubungi admin.');
        }

        return $next($request);
    }
}
