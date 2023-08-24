<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Http\Request;

class UserService
{

    public function __construct(
        public UserRepository $userRepository,
//        public RoleRepository $roleRepository
    )
    {
    }

    public function getSearchUsers(Request $request)
    {
//        return Cache::remember('users', 600, function () use($request) {
//        return $this->userRepository->paginate(15);
        return $this->userRepository->paginate(15);
//        });
    }


//    public function getRoles(User $user)
//    {
//        $roles = $this->roleRepository->all();
//        $userRoleId = $user->roles()->pluck('id')->toArray();
//        return [
//            'roles' => $roles,
//            'ids' => $userRoleId
//        ];
//    }
//
//    public function addRoleToUser(UserRequest $request, User $user)
//    {
//        $inputs = $request->all();
//        $inputs['roles'] ??= [];
//        $user->roles()->sync($inputs['roles']);
//    }

//    public function getPermissions(User $user)
//    {
//        $permissions = Permission::all();
//        $rolePermissionsId = $user->permissions()->pluck('id')->toArray();
//        return [
//            'permissions' => $permissions,
//            'ids' => $rolePermissionsId
//        ];
//    }
//
//    public function addPermissionToUser(UserRequest $request, User $user)
//    {
//        $inputs = $request->all();
//        $inputs['permissions'] ??= [];
//        $user->permissions()->sync($inputs['permissions']);
//    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }

    public function updateProfile($fields, $id)
    {
        return $this->userRepository->update($fields, $id);
    }

    public function notionalCodeExists($nationalCode)
    {
        return $this->userRepository->notionalCodeExists($nationalCode);
    }

    public function getUserPermissions(User $user){
        return $user->permissions;
    }


//
    public function getUserRoles(User $user)
    {
        return $user->roles;
    }
//
//    public function getRole(User $user, Role $role){
//        return new RoleResource($role);
//    }
//
//    public function deleteRole(User $user, Role $role){
//        return $this->roleRepository->delete();
//    }


}
