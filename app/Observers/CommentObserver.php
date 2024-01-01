<?php

namespace App\Observers;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Comment;
use App\Models\User;

class CommentObserver
{

    public function __construct(public CacheApiService $cacheApiService){}

    /**
     * Handle the User "created" event.
     */
    public function created(Comment $comment): void
    {
        if ($this->cacheApiService->hasCache('comment')) {
            $this->cacheApiService->forgetCacheApi('comment');
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(Comment $comment): void
    {
        if ($this->cacheApiService->hasCache('comment')) {
            $this->cacheApiService->forgetCacheApi('comment');
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        if ($this->cacheApiService->hasCache('comment')) {
            $this->cacheApiService->forgetCacheApi('comment');
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(Comment $comment): void
    {
        if ($this->cacheApiService->hasCache('comment')) {
            $this->cacheApiService->forgetCacheApi('comment');
        }
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        if ($this->cacheApiService->hasCache('comment')) {
            $this->cacheApiService->forgetCacheApi('comment');
        }
    }
}
