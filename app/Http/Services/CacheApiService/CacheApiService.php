<?php

namespace App\Http\Services\CacheApiService;

use Illuminate\Support\Facades\Cache;

class CacheApiService
{
    use CacheApi;

    public function cacheApi($key, $data, $time = 600)
    {
        return Cache::remember($key, $time, function () use ($data) {
            return $data;
        });
    }

    public function hasCache($key): bool
    {
        return Cache::has($key);
    }

    public function forgetCacheApi($key)
    {
        Cache::forget($key);
    }
}
