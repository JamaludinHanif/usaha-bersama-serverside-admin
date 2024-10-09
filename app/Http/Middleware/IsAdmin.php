<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Periksa apakah pengguna sudah masuk
        if (Auth::check()) {
            // Periksa apakah peran pengguna adalah admin
            if (Auth::user()->role == 'admin') {
                return $next($request);
            }
        }

        // Jika pengguna bukan admin atau tidak masuk, arahkan kembali dengan pesan kesalahan
        return redirect('/')->with('errorMiddleware', "Kamu tidak mempunyai akses admin");
    }
}
