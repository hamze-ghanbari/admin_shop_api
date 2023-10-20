<?php

namespace App\Http\Middleware;

use App\Http\Services\PolicyService\PolicyService;
use App\Traits\Response\ApiResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleMiddlware
{
    use ApiResponse;

    public function __construct(
        public PolicyService $policyService
    )
    {
    }

    public function handle(Request $request, Closure $next, $roles = null, $permissions = null): Response|JsonResponse
    {
        $roles = explode("|", $roles);
        $permissions = explode("|", $permissions);

        if ($this->policyService->authorize($roles, $permissions))
            return $this->forbiddenResponse();

        return $next($request);
    }
}
