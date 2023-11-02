<?php

namespace App\Http\Services\HttpService;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class HttpService implements HttpInterface
{


    public function get(string $url, array|string|null $query = null): Response
    {
        return Http::get($url, $query);
    }

    public function head(string $url, array|string|null $query = null): Response
    {
        return Http::head($url, $query);
    }

    public function post(string $url, array $data = []): Response
    {
        return Http::post($url, $data);
    }

    public function patch(string $url, array $data = []): Response
    {
        return Http::patch($url, $data);
    }

    public function put(string $url, array $data = []): Response
    {
        return Http::put($url, $data);
    }

    public function delete(string $url, array $data = []): Response
    {
        return Http::delete($url, $data);
    }
}
