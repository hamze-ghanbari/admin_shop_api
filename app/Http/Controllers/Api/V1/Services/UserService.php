<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repository\Eloquent\UserRepository;

class UserService
{

    public function __construct(public UserRepository $userRepository){}

    public function allUsers()
    {
//        return Cache::remember('users', 600, function () use($request) {
//        return $this->userRepository->paginate(15);
        return $this->userRepository->paginate();
//        });
    }

    public function addRoleToUser(UserRequest $request, User $user)
    {
        $inputs = $request->all();
        $inputs['roles'] ??= [];
      return $user->roles()->sync($inputs['roles']);
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

    public function getUserPermissions(User $user){
        return $user->permissions;
    }

    public function getUserRoles(User $user)
    {
        return $user->roles;
    }

}
