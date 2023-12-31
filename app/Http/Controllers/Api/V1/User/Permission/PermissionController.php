<?php

namespace App\Http\Controllers\Api\V1\User\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionCollection;
use App\Http\Services\PolicyService\PolicyService;
use App\Traits\Response\ApiResponse;


class PermissionController extends Controller
{
    use ApiResponse;
    public function __construct(
        public PermissionService $permissionService,
        public PolicyService $policyService
    ){
        $this->middleware('auth:api');
    }

    public function __invoke(){
        if (!$this->policyService->authorize(['admin'], ['read-permission']))
            return $this->forbiddenResponse();

        return new PermissionCollection($this->permissionService->getAllPermissions());
    }

}
