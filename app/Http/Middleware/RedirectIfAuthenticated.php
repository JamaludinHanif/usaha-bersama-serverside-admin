<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'Admin') {
                return redirect()->route('dashboard');
            } else if ($user->role === 'Buyer') {
                return redirect()->route('buyer.index')->with('middleware-guest', 'Anda sudah ter AUTHENTIKASI, silahkan nikmati fitur yang ada');
            }

            return redirect()->route('buyer.index');
        }

        return $next($request);
    }
}
