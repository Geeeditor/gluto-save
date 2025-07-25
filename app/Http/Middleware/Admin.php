<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if (Auth::check() && Auth::user()->usertype == 'admin') {
            return $next($request);
        }

        elseif (Auth::check() && Auth::user()->usertype == 'user') {

            return abort(403, 'User login detected. Please log out and log in again using administrator credentials');

        }

        // return $next($request);

        // return abort(403, 'Unauthorized action. Go Back to login Page');

        return abort(403, 'Unauthorized action. Go Back to login Page');
    }
}
