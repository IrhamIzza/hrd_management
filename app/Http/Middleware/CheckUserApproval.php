<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserApproval
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // HRD users are always approved
            if ($user->role === 'hrd') {
                return $next($request);
            }

            // Check if user is pending
            if ($user->approval_status === 'pending') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun Anda masih menunggu persetujuan dari HRD. Silakan coba lagi nanti.');
            }
        }

        return $next($request);
    }
} 