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
        $middleware->alias([
            // Your custom middleware aliases
            'force.password.reset' => \App\Http\Middleware\ForcePasswordReset::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role' => \Spatie\Permission\Middleware\Role::class,
            'session.timeout' => \App\Http\Middleware\SessionTimeout::class,
        ]);

        // ✅ Append to existing web middleware (DO NOT override)
    $middleware->appendToGroup('web', [
        \App\Http\Middleware\SessionTimeout::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // exception config if needed
    })
    ->create();