<?php

namespace App\Http\Services\PolicyService;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Gate;

class PolicyService
{
    public function authorize($roles = [], $permissions = []): bool
    {
        $result = [];
        foreach ($roles as $role) {
            if (Gate::denies($role))
                array_push($result, false);
            else
                array_push($result, true);
        }

        foreach ($permissions as $permission) {
            if (Gate::denies($permission))
                array_push($result, false);
            else
                array_push($result, true);
        }

        if (in_array(true, $result)){
            return false;
        }
        else{
            return true;
        }
    }
}
