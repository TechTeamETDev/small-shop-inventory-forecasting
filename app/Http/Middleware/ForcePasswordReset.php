<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForcePasswordReset
{
   public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->must_reset_password) {
        // Allow first-login password reset
        if ($request->routeIs('password.reset.custom') || $request->routeIs('password.reset.custom.post')) {
            return $next($request);
        }
        return redirect()->route('password.reset.custom');
    }

    return $next($request);
}}