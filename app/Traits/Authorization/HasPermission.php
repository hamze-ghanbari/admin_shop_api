<?php

namespace App\Traits\Authorization;

trait HasPermission
{

    public function hasPermission($permission)
    {
        return (bool)$this->permissions->where('name', $permission->name)->count();
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission) || $this->hasPermissionThroghRole($permission);
    }

    public function hasRole($role): bool
    {
        return (bool)$this->roles->where('name', $role->name)->count();
//        foreach ($roles as $role) {
//            if ($this->roles->contains('name', $role))
//                return true;
//        }
//        return false;
    }

    public function hasPermissionThroghRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role))
                return true;
        }
        return false;
    }
}
