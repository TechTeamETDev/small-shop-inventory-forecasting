<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle incoming request and verify user role
     * Usage: ->middleware('role:admin')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ensure user is logged in
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Check if user's role matches allowed roles
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Access denied');
        }

        return $next($request);
    }
}
