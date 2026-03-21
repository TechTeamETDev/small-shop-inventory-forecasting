<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForcePasswordReset
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->must_reset_password) {
            // Allow GET and POST for the reset route
            if (!in_array($request->route()->getName(), [
                'password.reset.custom',
                'password.reset.custom.post'
            ])) {
                return redirect()->route('password.reset.custom');
            }
        }

        return $next($request);
    }
}