<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\GalleryProduct;

class GalleryProductObserver
{

    public function __construct(public CacheApiService $cacheApiService)
    {
    }

    /**
     * Handle the Category "created" event.
     */
    public function created(GalleryProduct $gallery): void
    {
        if ($this->cacheApiService->hasCache('galleryProducts')) {
            $this->cacheApiService->forgetCacheApi('galleryProducts');
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(GalleryProduct $gallery): void
    {
        if ($this->cacheApiService->hasCache('galleryProducts')) {
            $this->cacheApiService->forgetCacheApi('galleryProducts');
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(GalleryProduct $gallery): void
    {
        if ($this->cacheApiService->hasCache('galleryProducts')) {
            $this->cacheApiService->forgetCacheApi('galleryProducts');
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(GalleryProduct $gallery): void
    {
        if ($this->cacheApiService->hasCache('galleryProducts')) {
            $this->cacheApiService->forgetCacheApi('galleryProducts');
        }
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(GalleryProduct $gallery): void
    {
        if ($this->cacheApiService->hasCache('galleryProducts')) {
            $this->cacheApiService->forgetCacheApi('galleryProducts');
        }
    }
}
