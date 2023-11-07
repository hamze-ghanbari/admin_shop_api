<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Banner;

class BannerObserver
{

    public function __construct(public CacheApiService $cacheApiService){}
    /**
     * Handle the Banner "created" event.
     */
    public function created(Banner $banner): void
    {
        if ($this->cacheApiService->hasCache('banners')) {
            $this->cacheApiService->forgetCacheApi('banners');
        }
    }

    /**
     * Handle the Banner "updated" event.
     */
    public function updated(Banner $banner): void
    {
        if ($this->cacheApiService->hasCache('banners')) {
            $this->cacheApiService->forgetCacheApi('banners');
        }
    }

    /**
     * Handle the Banner "deleted" event.
     */
    public function deleted(Banner $banner): void
    {
        if ($this->cacheApiService->hasCache('banners')) {
            $this->cacheApiService->forgetCacheApi('banners');
        }
    }

    /**
     * Handle the Banner "restored" event.
     */
    public function restored(Banner $banner): void
    {
        if ($this->cacheApiService->hasCache('banners')) {
            $this->cacheApiService->forgetCacheApi('banners');
        }
    }

    /**
     * Handle the Banner "force deleted" event.
     */
    public function forceDeleted(Banner $banner): void
    {
        if ($this->cacheApiService->hasCache('banners')) {
            $this->cacheApiService->forgetCacheApi('banners');
        }
    }
}
