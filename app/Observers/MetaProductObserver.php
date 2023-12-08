<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\MetaProduct;
use App\Models\Product;

class MetaProductObserver
{
    public function __construct(public CacheApiService $cacheApiService)
    {
    }


    /**
     * Handle the Category "created" event.
     */
    public function created(MetaProduct $metaProduct): void
    {
        if ($this->cacheApiService->hasCache('metaProducts')) {
            $this->cacheApiService->forgetCacheApi('metaProducts');
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(MetaProduct $metaProduct): void
    {
        if ($this->cacheApiService->hasCache('metaProducts')) {
            $this->cacheApiService->forgetCacheApi('metaProducts');
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(MetaProduct $metaProduct): void
    {
        if ($this->cacheApiService->hasCache('metaProducts')) {
            $this->cacheApiService->forgetCacheApi('metaProducts');
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(MetaProduct $metaProduct): void
    {
        if ($this->cacheApiService->hasCache('metaProducts')) {
            $this->cacheApiService->forgetCacheApi('metaProducts');
        }
    }

}
