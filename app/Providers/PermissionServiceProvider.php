<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{

    public function boot()
    {
        try {
            Permission::get()->map(function ($permission) {
            Gate::define($permission->name, function (User $user) use($permission){
               return $user->hasPermissionTo($permission);
            });
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
