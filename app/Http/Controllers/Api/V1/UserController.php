<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(
        public UserService $userService,
    )
    {
    }

    public function index(Request $request)
    {
        return new UserCollection($this->userService->getSearchUsers($request));
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }


    public function updateBirthDate(UserRequest $request, User $user)
    {
        $updated = $this->userService->updateProfile($request->only('birth_date'), $user->id);
        $result = (bool)$updated;
        return response()->json(['result' => $result]);
    }

    public function updateNationalCode(UserRequest $request, User $user)
    {
        $nationalCode = $request->only('national_code');
        if ($this->userService->notionalCodeExists($nationalCode)){
            return response()->json([
                'result' => false,
                'error' => 'این کد ملی قبلا ثبت شده است'
            ]);
        }

        $updated = $this->userService->updateProfile($nationalCode, $user->id);
        $result = (bool)$updated;
        return response()->json(['result' => $result]);
    }

    public function updateFullName(UserRequest $request, User $user)
    {
        $updated = $this->userService->updateProfile($request->only(['first_name', 'last_name']), $user->id);
        $result = (bool)$updated;
        return response()->json(['result' => $result]);
    }


    public function destroy(User $user)
    {
        $userDelete = $this->userService->deleteUser($user->id);
        $result = (bool)$userDelete;
        return response()->json(['result' => $result]);
    }


    public function showUserPermissions(User $user)
    {
        $userPermissions = $this->userService->getUserPermissions($user);
        return new PermissionCollection($userPermissions);
    }

    public function showUserRoles(User $user){
        return new RoleCollection($this->userService->getUserRoles($user));
    }


//    public function index(User $user)
//    {
//        return $this->roleService->getRoles($user);
//    }
//
//    public function store(Request $request)
//    {
//        //
//    }
//
//    public function show(User $user, Role $role)
//    {
//        return $this->roleService->getRole($user, $role);
//    }
//
//
//    public function update(Request $request, Role $role)
//    {
//        //
//    }
//
//    public function destroy(User $user, Role $role)
//    {
//        $userDelete = $this->roleService->deleteRole($user, $role->id);
//        $result = $userDelete ? ['result' => true] : ['result' => false];
//        return response()->json($result);
//    }


}
