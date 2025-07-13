<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check() && Auth::user()->role === 'hrd') {
            return $next($request);
        }

        // Jika tidak memenuhi, redirect dengan pesan error
        return redirect('/')->with('error', 'You do not have permission to access this page');
    }
}
