<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Example logic
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
