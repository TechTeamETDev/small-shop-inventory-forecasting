<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions as ExceptionConfig;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {

        // ✅ Middleware aliases
        $middleware->alias([
            'force.password.reset' => \App\Http\Middleware\ForcePasswordReset::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'session.timeout' => \App\Http\Middleware\SessionTimeout::class,
        ]);

        // ✅ Add SessionTimeout to web group (correct way)
        $middleware->appendToGroup('web', \App\Http\Middleware\SessionTimeout::class);
    })
    ->withExceptions(function (ExceptionConfig $exceptions): void {
        //
    })
    ->create();