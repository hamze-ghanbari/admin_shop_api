<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotAllowedIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        return auth('api')->check()
            ? response()->json([
                'status' => 403,
                'hasError' => true,
                'message' => 'You are authenticated',
                'result' => null
            ])
            : $next($request);
    }
}
