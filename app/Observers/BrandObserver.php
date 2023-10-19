<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Brand;

class BrandObserver
{

    public function __construct(public CacheApiService $cacheApiService){}
    /**
     * Handle the Brand "created" event.
     */
    public function created(Brand $brand): void
    {
        if ($this->cacheApiService->hasCache('brands')) {
            $this->cacheApiService->forgetCacheApi('brands');
        }
    }

    /**
     * Handle the Brand "updated" event.
     */
    public function updated(Brand $brand): void
    {
        if ($this->cacheApiService->hasCache('brands')) {
            $this->cacheApiService->forgetCacheApi('brands');
        }
    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        if ($this->cacheApiService->hasCache('brands')) {
            $this->cacheApiService->forgetCacheApi('brands');
        }
    }

    /**
     * Handle the Brand "restored" event.
     */
    public function restored(Brand $brand): void
    {
        if ($this->cacheApiService->hasCache('brands')) {
            $this->cacheApiService->forgetCacheApi('brands');
        }
    }

    /**
     * Handle the Brand "force deleted" event.
     */
    public function forceDeleted(Brand $brand): void
    {
        if ($this->cacheApiService->hasCache('brands')) {
            $this->cacheApiService->forgetCacheApi('brands');
        }
    }
}
