<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Http\Requests\UserRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\User;
use App\Repository\Contracts\RoleRepositoryInterface;
use App\Repository\Contracts\UserRepositoryInterface;

class UserService
{
    public function __construct(
        public UserRepositoryInterface $userRepository,
        public RoleRepositoryInterface $roleRepository,
        public CacheApiService         $cacheApiService
    )
    {
    }

    public function allUsers()
    {
        if ($this->cacheApiService->useCache('users')) {
            return $this->cacheApiService->cacheApi('users', $this->userRepository->paginate());
        }
        return $this->userRepository->paginate();
    }

    public function searchUser($value){
       return $this->userRepository->getUserSearch($value);
    }

    public function addRoleToUser(UserRequest $request, User $user)
    {
        $syncRoles = [];
        $rolesHasPermissions = $this->roleRepository->getRoles();
        $inputs = $request->all();
        $inputs['roles'] ??= [];
        foreach ($inputs['roles'] as $role) {
            if (in_array($role, $rolesHasPermissions)) {
                array_push($syncRoles, $role);
            }
        }
        return $user->roles()->sync($syncRoles);
    }

    public function addPermissionToUser(UserRequest $request, User $user)
    {
        $inputs = $request->all();
        $inputs['permissions'] ??= [];
        $user->permissions()->sync($inputs['permissions']);
    }

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

    public function getUserPermissions(User $user)
    {
        return $user->permissions;
    }

    public function getUserRoles(User $user)
    {
        return $user->roles;
    }

}
