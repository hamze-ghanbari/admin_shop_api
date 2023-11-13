<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Delivery;

class DeliveryObserver
{
    public function __construct(public CacheApiService $cacheApiService)
    {
    }

    /**
     * Handle the Delivery "created" event.
     */
    public function created(Delivery $delivery): void
    {
        if ($this->cacheApiService->hasCache('deliveries')) {
            $this->cacheApiService->forgetCacheApi('deliveries');
        }
    }

    /**
     * Handle the Delivery "updated" event.
     */
    public function updated(Delivery $delivery): void
    {
        if ($this->cacheApiService->hasCache('deliveries')) {
            $this->cacheApiService->forgetCacheApi('deliveries');
        }
    }

    /**
     * Handle the Delivery "deleted" event.
     */
    public function deleted(Delivery $delivery): void
    {
        if ($this->cacheApiService->hasCache('deliveries')) {
            $this->cacheApiService->forgetCacheApi('deliveries');
        }
    }

    /**
     * Handle the Delivery "restored" event.
     */
    public function restored(Delivery $delivery): void
    {
        if ($this->cacheApiService->hasCache('deliveries')) {
            $this->cacheApiService->forgetCacheApi('deliveries');
        }
    }

    /**
     * Handle the Delivery "force deleted" event.
     */
    public function forceDeleted(Delivery $delivery): void
    {
        if ($this->cacheApiService->hasCache('deliveries')) {
            $this->cacheApiService->forgetCacheApi('deliveries');
        }
    }
}
