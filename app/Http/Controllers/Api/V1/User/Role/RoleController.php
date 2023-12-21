<?php

namespace App\Http\Controllers\Api\V1\User\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\UserCollection;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Role;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    use ValidationResponse, ApiResponse;

    public function __construct(
        public RoleService   $roleService,
        public PolicyService $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:role,5')->only('storeRolePermissions', 'store', 'update', 'changeStatus');
    }

    public function index()
    {
        if (!$this->policyService->authorize(['admin'], ['read-role']))
            return $this->forbiddenResponse();

        return new RoleCollection($this->roleService->getAllRoles());
    }

    public function searchRole(Request $request){
        if (!$this->policyService->authorize(['admin'], ['read-role']))
            return $this->forbiddenResponse();

        return new RoleCollection($this->roleService->searchRole($request->input('search')));
    }

    public function store(RoleRequest $request)
    {
        if (!$this->policyService->authorize(['admin'], ['create-role']))
            return $this->forbiddenResponse();

        if ($this->roleService->roleExists($request->input('name'), $request->input('persian_name'))) {
            return $this->failedValidationResponse('این نقش قبلا ثبت شده است', 409);
        }

        $this->roleService->createRole($request);
        return $this->apiResponse(null);
    }

    public function update(RoleRequest $request, Role $role)
    {
        if (!$this->policyService->authorize(['admin'], ['update-role']))
            return $this->forbiddenResponse();

        try {
            $this->roleService->updateRole($request, $role);
            return $this->apiResponse(null);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return $this->serverError('این نقش قبلا ثبت شده است');
            } else {
                return $this->serverError('خطا در ویرایش نقش');
            }
        }
    }

    public function changeStatus(Role $role, $status)
    {
        if (!$this->policyService->authorize(['admin'], ['update-role']))
            return $this->forbiddenResponse();

        $updated = $this->roleService->updateRoleStatus($role, $status);
        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش وضعیت نقش');
        }
    }

    public function destroy(Role $role)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-role']))
            return $this->forbiddenResponse();

        $roleDelete = $this->roleService->deleteRole($role->id);
        $result = (bool)$roleDelete;
        return $this->apiResponse(null, hasError: !$result);
    }

    public function showRolePermissions(Role $role)
    {
        if (!$this->policyService->authorize(['admin'], ['read-role']))
            return $this->forbiddenResponse();

        $rolePermissions = $this->roleService->getRolePermissions($role);
        return new PermissionCollection($rolePermissions);
    }

    public function storeRolePermissions(Request $request, Role $role)
    {
        if (!$this->policyService->authorize(['admin'], ['update-role']))
            return $this->forbiddenResponse();

        try {
            $this->roleService->addPermissionToRole($request, $role);
            return $this->apiResponse(null);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1452) {
                return $this->serverError('سطح دسترسی تعریف شده وجود ندارد');
            } else {
                return $this->serverError();
            }
        }
    }


}
