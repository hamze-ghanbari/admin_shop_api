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

class UserController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public UserService   $userService,
        public PolicyService $policyService
    )
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        return new UserCollection($this->userService->allUsers());
    }

    public function show(User $user): JsonResponse
    {
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        return $this->apiResponse(new UserResource($user));
    }

    public function profile(User $user): JsonResponse
    {
        if ($this->sameUser($user->id)) {
            return $this->forbiddenResponse();
        }
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
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        $userDelete = $this->userService->deleteUser($user->id);
        $result = (bool)$userDelete;
        return $this->apiResponse(null, hasError: !$result);
    }

    public function showUserPermissions(User $user): JsonResponse
    {
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        return $this->apiResponse(new PermissionCollection($this->userService->getUserPermissions($user)));
    }

    public function showUserRoles(User $user): JsonResponse
    {
        if ($this->policyService->authorize(['admin']))
            return $this->forbiddenResponse();

        return $this->apiResponse(new RoleCollection($this->userService->getUserRoles($user)));
    }

    public function storeUserRoles(UserRequest $request, User $user): JsonResponse
    {
        $this->userService->addRoleToUser($request, $user);
        return $this->apiResponse(null);
    }

    public function storeUserPermissions(UserRequest $request, User $user): JsonResponse
    {
        $this->userService->addPermissionToUser($request, $user);
        return $this->apiResponse(null);
    }

}
