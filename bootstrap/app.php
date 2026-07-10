<?php

declare(strict_types=1);

use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register role check middleware
        $middleware->alias([
            'role' => EnsureUserHasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Customize JSON rendering for APIs
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*')
        );

        // Custom logging for database query exceptions
        $exceptions->report(function (Throwable $e): void {
            if ($e instanceof QueryException) {
                Log::error('Database query failure occurred.', [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]);
            }
        });
    })->create();
