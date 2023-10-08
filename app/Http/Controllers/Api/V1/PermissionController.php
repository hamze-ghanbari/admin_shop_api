<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\PermissionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionCollection;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Gate;


class PermissionController extends Controller
{
    public function __construct(
        public PermissionService $permissionService
    ){
        $this->middleware('auth:api');
    }

    public function __invoke(){
        if (Gate::denies('admin')) {
            return $this->apiResponse(null, 403, 'forbidden', true);
        }
        return new PermissionCollection($this->permissionService->getAllPermissions());
    }

}
