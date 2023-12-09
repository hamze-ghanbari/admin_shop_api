<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\ColorProduct;

class ColorProductObserver
{
    public function __construct(public CacheApiService $cacheApiService)
    {
    }


    /**
     * Handle the Category "created" event.
     */
    public function created(ColorProduct $colorProduct): void
    {
        if ($this->cacheApiService->hasCache('colorProducts')) {
            $this->cacheApiService->forgetCacheApi('colorProducts');
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(ColorProduct $colorProduct): void
    {
        if ($this->cacheApiService->hasCache('colorProducts')) {
            $this->cacheApiService->forgetCacheApi('colorProducts');
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(ColorProduct $colorProduct): void
    {
        if ($this->cacheApiService->hasCache('colorProducts')) {
            $this->cacheApiService->forgetCacheApi('colorProducts');
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(ColorProduct $colorProduct): void
    {
        if ($this->cacheApiService->hasCache('colorProducts')) {
            $this->cacheApiService->forgetCacheApi('colorProducts');
        }
    }
}
