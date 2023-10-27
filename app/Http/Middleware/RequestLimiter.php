<?php

namespace App\Http\Middleware;

use App\Traits\Response\ApiResponse;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RequestLimiter
{
    use ApiResponse;

    public function handle(Request $request, Closure $next, string $keyName, int $attempt): Response
    {
        $key = $keyName . url()->current() . $request->ip();
        $executed = RateLimiter::attempt(
            $key,
            $attempt,
            function () {}
        );
        if (!$executed) {
            $time = ((Carbon::now())->addSeconds(RateLimiter::availableIn($key))->timestamp - Carbon::now()->timestamp);
            $url = url()->current();
           return $this->tooManyRequests([
                'time' => $time,
                'url' => $url
            ]);
        }

        return $next($request);
    }
}
