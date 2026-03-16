<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearPermissionCache
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
   public function handle($request, Closure $next)
{
    if (auth()->check()) {
        // This forces Spatie to reload permissions from the DB for the current user
        app()[\Spatie\Permission\PermissionRegistrar::class]->setPermissionsTeamId(null);
    }
    return $next($request);
}
}
