<?php

namespace App\Repository\Eloquent;

use App\Models\Role;
use App\Repository\Contracts\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
     public function model(){
         return Role::class;
     }

    public function checkRole($name, $persianName)
    {
        return $this->getModel()->where(['name' => $name])->orWhere(['persian_name' => $persianName])->exists();
    }

    public function getRoles()
    {
        return $this->has('permissions')->get();
    }
}
