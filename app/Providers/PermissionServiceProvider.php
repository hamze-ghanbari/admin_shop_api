<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{

    public function register()
    {
    }

    public function boot()
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define('P' . $permission->name, function (User $user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });

            Role::where('status', 1)->get()->map(function ($role) {
                if($role->permissions()->toArray()) {
                    Gate::define('R' . $role->name, function (User $user) use ($role) {
                        return $user->hasRole($role);
                    });
                }
            });

        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
