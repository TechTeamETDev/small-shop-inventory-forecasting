<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Spatie\Permission\Middlewares\PermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        // Register custom middleware here
        $middleware->alias([
            'force.password.reset' => \App\Http\Middleware\ForcePasswordReset::class,
           'permission' => Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role' => \Spatie\Permission\Middleware\Role::class,
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
   