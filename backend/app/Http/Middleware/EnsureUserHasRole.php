<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Usage: ->middleware('role:admin,management')
     * Multiple roles passed = OR condition (user needs at least one).
     *
     * Runs AFTER auth:sanctum in the route middleware stack, so
     * $request->user() is guaranteed non-null when this executes on a
     * route that also has auth:sanctum applied. The null check below is
     * a defensive fallback in case someone applies 'role' without
     * 'auth:sanctum' by mistake.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if (! in_array($user->role, $roles, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden. Insufficient role privileges.',
            ], 403);
        }

        return $next($request);
    }
}
