<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForcePasswordReset
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->must_reset_password) {
            // Avoid redirect loop
            if ($request->route()->getName() !== 'password.reset.custom') {
                return redirect()->route('password.reset.custom');
            }
        }

        return $next($request);
    }
}