<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\CategoryProduct;

class CategoryProductObserver
{

    public function __construct(public CacheApiService $cacheApiService)
    {
    }

    /**
     * Handle the Category "created" event.
     */
    public function created(CategoryProduct $category): void
    {
        if ($this->cacheApiService->hasCache('categories')) {
            $this->cacheApiService->forgetCacheApi('categories');
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(CategoryProduct $category): void
    {
        if ($this->cacheApiService->hasCache('categories')) {
            $this->cacheApiService->forgetCacheApi('categories');
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(CategoryProduct $category): void
    {
        if ($this->cacheApiService->hasCache('categories')) {
            $this->cacheApiService->forgetCacheApi('categories');
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(CategoryProduct $category): void
    {
        if ($this->cacheApiService->hasCache('categories')) {
            $this->cacheApiService->forgetCacheApi('categories');
        }
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(CategoryProduct $category): void
    {
        if ($this->cacheApiService->hasCache('categories')) {
            $this->cacheApiService->forgetCacheApi('categories');
        }
    }
}
