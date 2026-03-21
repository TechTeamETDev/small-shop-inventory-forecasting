<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    // Timeout in seconds
    protected $timeouts = [
        'admin' => 600,      // 10 minutes
        'employee' => 3600,  // 1 hour
    ];

    // Warning before timeout (seconds)
    protected $warning = 60; // 1 minute

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Determine timeout based on role
            if ($user->hasRole('admin')) {
                $timeout = $this->timeouts['admin'];
            } else {
                $timeout = $this->timeouts['employee'];
            }

            $lastActivity = session('last_activity_time', now()->timestamp);
            $elapsed = now()->timestamp - $lastActivity;

            // Check if user should be warned
            if ($elapsed >= ($timeout - $this->warning) && $elapsed < $timeout) {
                session()->flash('session_warning', 'Your session will expire in 1 minute due to inactivity.');
            }

            // Check timeout
            if ($elapsed >= $timeout) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect('/login')->with('error', 'You have been logged out due to inactivity.');
            }

            // Update last activity time if not AJAX "keep-alive"
            if (!$request->is('keep-alive')) {
                session(['last_activity_time' => now()->timestamp]);
            }
        }

        return $next($request);
    }
}