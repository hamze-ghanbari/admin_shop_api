<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        JsonResource::withoutWrapping();

        Request::macro('fields', function ($guarded = ['id'], $attributes = []) use ($request) {
            $except = ['_token', '_method'];
            array_push($except, ...$guarded);
            $result = $request->except($except);
            if(!empty($attributes)){
                $result =  array_merge($request->except($except), $attributes);
            }
            return $result;
        });
    }
}
