<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\PermissionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionCollection;
use App\Traits\ApiResponse;


class PermissionController extends Controller
{
    public function __construct(
        public PermissionService $permissionService
    ){}

    public function __invoke(){
        return new PermissionCollection($this->permissionService->getAllPermissions());
    }

}
