<?php

namespace App\Http\Services\PolicyService;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Gate;

class PolicyService
{
    public function authorize($roles = [], $permissions = []): bool
    {
        $result = [];
        if (!empty($roles)) {
            foreach ($roles as $role) {
                array_push($result, Gate::denies('R'.$role, auth()->user()));
            }
        }
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                array_push($result, Gate::denies('P'.$permission, auth()->user()));
            }
        }
        return in_array(false, $result);
    }

    public function sameUser($userId): bool
    {
        return auth()->user() === $userId;
    }
}
