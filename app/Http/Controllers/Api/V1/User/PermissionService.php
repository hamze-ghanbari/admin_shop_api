<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Permission;

class PermissionService
{
    public function __construct(
        public CacheApiService $cacheApiService
    ){}

    public function getAllPermissions(){
        if($this->cacheApiService->useCache('roles')){
            return $this->cacheApiService->cacheApi('roles', Permission::all());
        }
        return Permission::all();
    }

}
