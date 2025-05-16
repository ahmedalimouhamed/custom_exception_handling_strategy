<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class CustomAuthenticate extends Middleware
{
    /**
     * Handle an unauthenticated user.
     */
    protected function unauthenticated($request, array $guards)
    {
        if ($this->shouldReturnJson($request, $guards)) {
            throw new AuthenticationException(
                'Unauthenticated.', 
                $guards,
                $this->jsonResponse($request)
            );
        }

        parent::unauthenticated($request, $guards);
    }

    protected function shouldReturnJson($request, $guards): bool
    {
        return $request->expectsJson() || 
               in_array('sanctum', $guards) || 
               $request->is('api/*');
    }

    protected function jsonResponse($request)
    {
        return response()->json([
            'status' => 'error',
            'code' => 401,
            'message' => 'Authentication required',
            'docs' => 'https://your-api.docs/auth'
        ], 401);
    }

    /**
     * Get the path the user should be redirected to when not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}