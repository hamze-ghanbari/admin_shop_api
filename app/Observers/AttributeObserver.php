<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\AttributeCategory;
use App\Models\Banner;

class AttributeObserver
{

    public function __construct(public CacheApiService $cacheApiService){}
    /**
     * Handle the Banner "created" event.
     */
    public function created(AttributeCategory $attributeCategory): void
    {
        if ($this->cacheApiService->hasCache('attributes')) {
            $this->cacheApiService->forgetCacheApi('attributes');
        }
    }

    /**
     * Handle the Banner "updated" event.
     */
    public function updated(AttributeCategory $attributeCategory): void
    {
        if ($this->cacheApiService->hasCache('attributes')) {
            $this->cacheApiService->forgetCacheApi('attributes');
        }
    }

    /**
     * Handle the Banner "deleted" event.
     */
    public function deleted(AttributeCategory $attributeCategory): void
    {
        if ($this->cacheApiService->hasCache('attributes')) {
            $this->cacheApiService->forgetCacheApi('attributes');
        }
    }

    /**
     * Handle the Banner "restored" event.
     */
    public function restored(AttributeCategory $attributeCategory): void
    {
        if ($this->cacheApiService->hasCache('attributes')) {
            $this->cacheApiService->forgetCacheApi('attributes');
        }
    }

    /**
     * Handle the Banner "force deleted" event.
     */
    public function forceDeleted(AttributeCategory $attributeCategory): void
    {
        if ($this->cacheApiService->hasCache('attributes')) {
            $this->cacheApiService->forgetCacheApi('attributes');
        }
    }
}
