<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\RoleService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\PermissionCollection;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    public function __construct(
        public RoleService $roleService
    )
    {
    }

    public function index(Request $request)
    {
        return $this->roleService->getSearchRoles($request);
    }

    public function store(RoleRequest $request)
    {
        if ($this->roleService->roleExists($request->input('name'), $request->input('persian_name'))) {
            return response()->json([
                'result' => false,
                'error' => 'این نقش قبلا ثبت شده است'
            ]);
        }

        $this->roleService->createRole($request);
        return response()->json([
            'result' => true,
        ]);
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
            return response()->json([
                'result' => true,
            ]);
        } else {
            return response()->json([
                'result' => false,
                'error' => 'خطا در ویرایش نقش'
            ]);
        }
    }

    public function changeStatus(Role $role, $status)
    {
        $updated = $this->roleService->updateRoleStatus($role, $status);
        if ($updated) {
            return response()->json([
                'result' => true,
            ]);
        } else {
            return response()->json([
                'result' => false,
                'error' => 'خطا در ویرایش وضعیت نقش'
            ]);
        }
    }

    public function destroy(Role $role)
    {
        $roleDelete = $this->roleService->deleteRole($role->id);
        $result = (bool)$roleDelete;
        return response()->json(['result' => $result]);
    }

    public function showRolePermissions(Role $role)
    {
        $rolePermissions = $this->roleService->getRolePermissions($role);
        return new PermissionCollection($rolePermissions);
    }

    public function addPermissionToRole(Request $request, Role $role)
    {
        $this->roleService->addPermissionToRole($request, $role);
        return response()->json([
            'result' => true,
        ]);
    }


}
