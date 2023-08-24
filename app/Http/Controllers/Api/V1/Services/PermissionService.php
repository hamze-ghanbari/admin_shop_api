<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Http\Resources\PermissionCollection;
use App\Models\Permission;
use App\Models\User;

class PermissionService
{

    public function getAllPermissions(){
        return Permission::all();
    }

    public function getPermissions(User $user)
    {
       return new PermissionCollection($user->permissions);
    }

}
