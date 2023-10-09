<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\RoleService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Role;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\ValidationResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    use ValidationResponse, ApiResponse;

    public function __construct(
        public RoleService $roleService,
        public PolicyService $policyService
    )
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        return new RoleCollection($this->roleService->getAllRoles());
    }

    public function store(RoleRequest $request)
    {
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        if ($this->roleService->roleExists($request->input('name'), $request->input('persian_name'))) {
            return $this->failedValidationResponse('این نقش قبلا ثبت شده است');
        }

        $this->roleService->createRole($request);
        return $this->apiResponse(null);
    }

    public function update(RoleRequest $request, Role $role)
    {
//        if ($this->roleService->roleExists($request->input('name'), $request->input('persian_name')) && $role->name == $request->input('name')) {
//            return response()->json([
//                'result' => false,
//                'error' => 'این نقش قبلا ثبت شده است'
//            ]);
//        }
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        $role = $this->roleService->updateRole($request, $role);
        if ($role) {
            return $this->apiResponse(null);
        } else {
            return $this->apiResponse(null, 500, 'خطا در ویرایش نقش', true);
        }
    }

    public function changeStatus(Role $role, $status)
    {
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        $updated = $this->roleService->updateRoleStatus($role, $status);
        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->apiResponse(null, 500, 'خطا در ویرایش وضعیت نقش', true);
        }
    }

    public function destroy(Role $role)
    {
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        $roleDelete = $this->roleService->deleteRole($role->id);
        $result = (bool)$roleDelete;
        return $this->apiResponse(null, hasError: !$result);
    }

    public function showRolePermissions(Role $role)
    {
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        $rolePermissions = $this->roleService->getRolePermissions($role);
        return new PermissionCollection($rolePermissions);
    }

    public function storeRolePermissions(Request $request, Role $role)
    {
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        try {
            $this->roleService->addPermissionToRole($request, $role);
            return $this->apiResponse(null);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1452){
            return $this->serverError('سطح دسترسی تعریف شده وجود ندارد');
            }else{
                return $this->serverError();
            }
        }
    }


}
