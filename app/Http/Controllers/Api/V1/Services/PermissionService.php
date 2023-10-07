<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Models\Permission;

class PermissionService
{

    public function getAllPermissions(){
        return Permission::all();
    }

}
