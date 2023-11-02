<?php

namespace App\Http\Services\HttpService;

use Illuminate\Http\Client\Response;

interface HttpInterface
{
    public function get(string $url, array|string|null $query = null): Response;

    public function head(string $url, array|string|null $query = null): Response;

    public function post(string $url, array $data = []): Response;

    public function patch(string $url, array $data = []): Response;

    public function put(string $url, array $data = []): Response;

    public function delete(string $url, array $data = []): Response;

}
