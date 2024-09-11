<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogActivityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->is('login') && $request->isMethod('post') && Auth::check()) {
            LogActivity::create([
                'user_id' => Auth::id(),
                'action' => 'login',
            ]);
        }

        if ($request->is('logout') && $request->isMethod('post') && Auth::check()) {
            LogActivity::create([
                'user_id' => Auth::id(),
                'action' => 'logout',
            ]);
        }

        return $response;
    }
}
