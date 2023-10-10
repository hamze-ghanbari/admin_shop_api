<?php

namespace App\Http\Services\CacheApiService;

use Illuminate\Support\Facades\Cache;

class CacheApiService
{
    use CacheApi;

    public function cacheApi($key, $data)
    {
        return Cache::remember($key, 600, function () use ($data) {
            return $data;
        });
    }

    public function forgetCacheApi($key)
    {
        Cache::forget($key);
    }
}
