<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\MailFile;

class MailFileObserver
{
    public function __construct(public CacheApiService $cacheApiService)
    {
    }

    /**
     * Handle the Category "created" event.
     */
    public function created(MailFile $mailFile): void
    {
        if ($this->cacheApiService->hasCache('mailFiles')) {
            $this->cacheApiService->forgetCacheApi('mailFiles');
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(MailFile $mailFile): void
    {
        if ($this->cacheApiService->hasCache('mailFiles')) {
            $this->cacheApiService->forgetCacheApi('mailFiles');
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(MailFile $mailFile): void
    {
        if ($this->cacheApiService->hasCache('mailFiles')) {
            $this->cacheApiService->forgetCacheApi('mailFiles');
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(MailFile $mailFile): void
    {
        if ($this->cacheApiService->hasCache('mailFiles')) {
            $this->cacheApiService->forgetCacheApi('mailFiles');


        }
    }

}
