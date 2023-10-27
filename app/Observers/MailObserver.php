<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Mail;

class MailObserver
{
    public function __construct(public CacheApiService $cacheApiService)
    {
    }

    /**
     * Handle the Category "created" event.
     */
    public function created(Mail $mail): void
    {
        if ($this->cacheApiService->hasCache('mails')) {
            $this->cacheApiService->forgetCacheApi('mails');
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Mail $mail): void
    {
        if ($this->cacheApiService->hasCache('mails')) {
            $this->cacheApiService->forgetCacheApi('mails');
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Mail $mail): void
    {
        if ($this->cacheApiService->hasCache('mails')) {
            $this->cacheApiService->forgetCacheApi('mails');
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Mail $mail): void
    {
        if ($this->cacheApiService->hasCache('mails')) {
            $this->cacheApiService->forgetCacheApi('mails');


        }
    }

}
