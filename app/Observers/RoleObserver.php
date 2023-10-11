<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Role;

class RoleObserver
{

    public function __construct(public CacheApiService $cacheApiService){}
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        if ($this->cacheApiService->hasCache('roles')) {
            $this->cacheApiService->forgetCacheApi('roles');
        }
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        if ($this->cacheApiService->hasCache('roles')) {
            $this->cacheApiService->forgetCacheApi('roles');
        }
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        if ($this->cacheApiService->hasCache('roles')) {
            $this->cacheApiService->forgetCacheApi('roles');
        }
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        if ($this->cacheApiService->hasCache('roles')) {
            $this->cacheApiService->forgetCacheApi('roles');
        }
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        if ($this->cacheApiService->hasCache('roles')) {
            $this->cacheApiService->forgetCacheApi('roles');
        }
    }
}
