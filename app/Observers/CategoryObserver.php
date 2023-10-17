<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Category;

class CategoryObserver
{

    public function __construct(public CacheApiService $cacheApiService)
    {
    }

    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        if ($this->cacheApiService->hasCache('categories')) {
            $this->cacheApiService->forgetCacheApi('categories');
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        if ($this->cacheApiService->hasCache('categories')) {
            $this->cacheApiService->forgetCacheApi('categories');
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        if ($this->cacheApiService->hasCache('categories')) {
            $this->cacheApiService->forgetCacheApi('categories');
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        if ($this->cacheApiService->hasCache('categories')) {
            $this->cacheApiService->forgetCacheApi('categories');
        }
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        if ($this->cacheApiService->hasCache('categories')) {
            $this->cacheApiService->forgetCacheApi('categories');
        }
    }
}
