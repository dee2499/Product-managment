<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user() === null || $request->user()->role !== $role) {
            abort(403, 'Unauthorized action. Required role: '.ucfirst($role));
        }

        return $next($request);
    }
}
