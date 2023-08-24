<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Models\Role;
use App\Repository\Contracts\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RoleService
{
    public function __construct(
        public RoleRepositoryInterface $roleRepository
    ){}

    public function getSearchRoles(Request $request)
    {
        return $this->roleRepository->with('permissions')->search($request->query('search'))->paginate(15);
    }

    public function roleExists($name, $persianName){
        return $this->roleRepository->checkRole($name, $persianName);
    }

    public function createRole(Request $request)
    {
        $status = $request->has('status') ? $request->input('status') : 0;
        $this->roleRepository->create($request->fields(attributes: ['status' => $status]));
    }

    public function updateRole(Request $request, Role $role)
    {
        $status = $request->has('status') ? $request->input('status') : 0;
        return $this->roleRepository->update($request->fields(attributes: ['status' => $status]), $role->id);
    }

    public function updateRoleStatus(Role $role, $status){
        return $this->roleRepository->update([
            'status' => $status
        ], $role->id);
    }

    public function deleteRole($id){
        return $this->roleRepository->delete($id);
    }

    public function getRolePermissions(Role $role){
        return $role->permissions;
    }

    public function addPermissionToRole(Request $request, Role $role){
        $inputs = $request->all();
        $inputs['permissions'] ??= [];
        $role->permissions()->sync($inputs['permissions']);
    }

}
