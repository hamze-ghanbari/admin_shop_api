<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Product;

class ProductObserver
{
    public function __construct(public CacheApiService $cacheApiService)
    {
    }


    /**
     * Handle the Category "created" event.
     */
    public function created(Product $product): void
    {
        if ($this->cacheApiService->hasCache('products')) {
            $this->cacheApiService->forgetCacheApi('products');
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Product $product): void
    {
        if ($this->cacheApiService->hasCache('products')) {
            $this->cacheApiService->forgetCacheApi('products');
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Product $product): void
    {
        if ($this->cacheApiService->hasCache('products')) {
            $this->cacheApiService->forgetCacheApi('products');
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Product $product): void
    {
        if ($this->cacheApiService->hasCache('products')) {
            $this->cacheApiService->forgetCacheApi('products');


        }
    }

}
