<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->usertype == 'user') {
            return $next($request);
        } elseif (Auth::check() && Auth::user()->usertype == 'admin') {
            return abort(403, 'Admin login detected. Please log out and log in again a user account or create a new account');
        }



        return redirect()->route('login');
        // return $next($request);
    }
}
