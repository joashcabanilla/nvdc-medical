<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class MemberMiddleware
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


        // Check if the user is logged in and is a Member (UserType ID = 1)
        if (Auth::check() && Auth::user()->UserType == 1) {
            return $next($request);
        }

        // If not a Member, redirect to login or unauthorized page
        return redirect('/')->with('error', 'Unauthorized access.');
    }
}