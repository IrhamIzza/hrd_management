<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IsHrd
{
    public function handle($request, Closure $next)
    {
        Log::info('IsHrd middleware called');

        if (Auth::check() && Auth::user()->role === 'hrd') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
