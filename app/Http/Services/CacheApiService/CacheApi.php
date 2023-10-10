<?php

namespace App\Http\Services\CacheApiService;

use Illuminate\Support\Facades\Config;

trait CacheApi
{
    public function useCache($key): bool
    {
        return (bool)Config::get('cache.useCache.' . $key);
    }
}
