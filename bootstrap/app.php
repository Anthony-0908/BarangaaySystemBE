<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // 🌟 Add your global middleware for SPA / Sanctum
        $middleware->append(EnsureFrontendRequestsAreStateful::class);
        $middleware->append(StartSession::class);
        $middleware->append(ShareErrorsFromSession::class);

        // Middleware alias (you already had)
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        // Middleware groups (optional, for 'web' and 'api')
        $middleware->appendToGroup('web', [
            EnsureFrontendRequestsAreStateful::class,
            StartSession::class,
            ShareErrorsFromSession::class,
        ]);

        $middleware->appendToGroup('api', [
            // Add API middleware here if needed
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
