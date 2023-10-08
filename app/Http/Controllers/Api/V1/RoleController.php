<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\RoleService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\ValidationResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    use ValidationResponse, ApiResponse;

    public function __construct(
        public RoleService $roleService
    )
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return new RoleCollection($this->roleService->getAllRoles());
    }

    public function store(RoleRequest $request)
    {
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

        $role = $this->roleService->updateRole($request, $role);
        if ($role) {
            return $this->apiResponse(null);
        } else {
            return $this->apiResponse(null, 500, 'خطا در ویرایش نقش', true);
        }
    }

    public function changeStatus(Role $role, $status)
    {
        $updated = $this->roleService->updateRoleStatus($role, $status);
        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->apiResponse(null, 500, 'خطا در ویرایش وضعیت نقش', true);
        }
    }

    public function destroy(Role $role)
    {
        $roleDelete = $this->roleService->deleteRole($role->id);
        $result = (bool)$roleDelete;
        return $this->apiResponse(null, hasError: !$result);
    }

    public function showRolePermissions(Role $role)
    {
        $rolePermissions = $this->roleService->getRolePermissions($role);
        return new PermissionCollection($rolePermissions);
    }

    public function storeRolePermissions(Request $request, Role $role)
    {
        try {
            $this->roleService->addPermissionToRole($request, $role);
            return $this->apiResponse(null);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1452)
            return $this->apiResponse(null, 500, 'سطح دسترسی تعریف شده وجود ندارد', true);
        }
    }


}
