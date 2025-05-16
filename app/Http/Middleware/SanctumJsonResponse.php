<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanctumJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->bearerToken()) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Access denied. No authentication token provided.',
                'documentation' => url('/docs/api-authentication')
            ], 401);
        }

        return $next($request);
    }
}
