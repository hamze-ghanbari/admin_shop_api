<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\User;

class UserObserver
{

    public function __construct(public CacheApiService $cacheApiService){}

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if ($this->cacheApiService->hasCache('users')) {
            $this->cacheApiService->forgetCacheApi('users');
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($this->cacheApiService->hasCache('users')) {
            $this->cacheApiService->forgetCacheApi('users');
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        if ($this->cacheApiService->hasCache('users')) {
            $this->cacheApiService->forgetCacheApi('users');
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        if ($this->cacheApiService->hasCache('users')) {
            $this->cacheApiService->forgetCacheApi('users');
        }
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        if ($this->cacheApiService->hasCache('users')) {
            $this->cacheApiService->forgetCacheApi('users');
        }
    }
}
