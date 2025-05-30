<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AdminMiddleware
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
        // Allow if user is admin or doctor
        if (Auth::check() && (Auth::user()->UserType == 2 || Auth::user()->UserType == 3)) {
            return $next($request);
        }

        // Otherwise redirect to login or show 403
        return redirect()->route('admin.login');
    }
}