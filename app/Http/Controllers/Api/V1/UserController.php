<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\ValidationResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public UserService   $userService,
        public PolicyService $policyService
    )
    {
//        $roles = 'admin';
//        $permissions = 'read-user|create-user|edit-user|delete-user';
        $this->middleware('auth:api');
        $this->middleware('limiter:5')->only('updateBirthDate', 'updateNationalCode', 'updateFullName',
        'storeUserRoles', 'storeUserPermissions');
//        $this->middleware("role:$roles,$permissions");

    }

    public function index()
    {
        if ($this->policyService->authorize(['admin'], ['read-user']))
            return $this->forbiddenResponse();

        return new UserCollection($this->userService->allUsers());
    }

    public function searchUser(Request $request)
    {
        if ($this->policyService->authorize(['admin'], ['read-user']))
            return $this->forbiddenResponse();

        return new UserCollection($this->userService->searchUser($request->input('search')));
    }

    public function show(User $user): JsonResponse
    {
        if ($this->policyService->authorize(['admin'], ['read-user']))
            return $this->forbiddenResponse();

        return $this->apiResponse(new UserResource($user));
    }

    public function profile(User $user): JsonResponse
    {
        if ($this->policyService->sameUser($user->id))
            return $this->forbiddenResponse();

        return $this->apiResponse(auth()->user());
    }

    public function updateBirthDate(UserRequest $request): JsonResponse
    {

        $updated = $this->userService->updateProfile($request->only('birth_date'), $request->user()->id);
        $result = (bool)$updated;
        return $this->apiResponse(null, hasError: !$result);
    }

    public function updateNationalCode(UserRequest $request): JsonResponse
    {

        $nationalCode = $request->only('national_code');
        if (!empty($nationalCode) && $this->userService->notionalCodeExists($nationalCode)) {
            return $this->failedValidationResponse([
                'national_code' =>
                    ['این کد ملی قبلا ثبت شده است']
            ]);
        }

        $updated = $this->userService->updateProfile($nationalCode, $request->user()->id);
        $result = (bool)$updated;
        return $this->apiResponse(null, hasError: !$result);
    }

    public function updateFullName(UserRequest $request): JsonResponse
    {
        $updated = $this->userService->updateProfile($request->only(['first_name', 'last_name']), $request->user()->id);
        $result = (bool)$updated;
        return $this->apiResponse(null, hasError: !$result);
    }


    public function destroy(User $user): JsonResponse
    {
        if ($this->policyService->authorize(['admin'], ['delete-user']))
            return $this->forbiddenResponse();

        $userDelete = $this->userService->deleteUser($user->id);
        $result = (bool)$userDelete;
        return $this->apiResponse(null, hasError: !$result);
    }

    public function showUserPermissions(User $user): JsonResponse
    {
        if ($this->policyService->authorize(['admin', ['read-user']]))
            return $this->forbiddenResponse();

        return $this->apiResponse(new PermissionCollection($this->userService->getUserPermissions($user)));
    }

    public function showUserRoles(User $user): JsonResponse
    {
        if ($this->policyService->authorize(['admin'], ['read-user']))
            return $this->forbiddenResponse();

        return $this->apiResponse(new RoleCollection($this->userService->getUserRoles($user)));
    }

    public function storeUserRoles(UserRequest $request, User $user): JsonResponse
    {
        if ($this->policyService->authorize(['admin'], ['update-user']))
            return $this->forbiddenResponse();

        $this->userService->addRoleToUser($request, $user);
        return $this->apiResponse(null);
    }

    public function storeUserPermissions(UserRequest $request, User $user): JsonResponse
    {
        if ($this->policyService->authorize(['admin'], ['update-user']))
            return $this->forbiddenResponse();

        $this->userService->addPermissionToUser($request, $user);
        return $this->apiResponse(null);
    }

}
