<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleMiddlware
{
    use ApiResponse;

    public function handle(Request $request, Closure $next, $role, $permission = null): Response
    {
        if (!$request->user()->hasRole($role) && $permission == null) {
            $this->apiResponse(null, Response::HTTP_FORBIDDEN, 'forbidden', true);
        }

        if ($permission !== null && !$request->user()->can($permission)) {
            $this->apiResponse(null, Response::HTTP_FORBIDDEN, 'forbidden', true);
        }
        return $next($request);
    }
}
