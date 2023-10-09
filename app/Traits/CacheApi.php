<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheApi
{

    public function cacheApi($key, $data){
        return Cache::remember($key, 600, function () use ($data) {
            return $data;
        });
    }

}
