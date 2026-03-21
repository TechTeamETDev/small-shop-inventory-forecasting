<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            // Determine timeout based on role
            $timeout = Auth::user()->hasRole('admin') ? 600 : 3600; // seconds
            $lastActivity = session('last_activity_time', now()->timestamp);

            if ((now()->timestamp - $lastActivity) > $timeout) {
                Auth::logout();
                session()->flush();
                return redirect('/login')->with('message', 'You have been logged out due to inactivity.');
            }

            // Update last activity
            session(['last_activity_time' => now()->timestamp]);
        }

        return $next($request);
    }
}