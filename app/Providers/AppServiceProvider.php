<?php

namespace App\Providers;

use App\Models\AttributeCategory;
use App\Models\ColorProduct;
use App\Models\GalleryProduct;
use App\Models\MetaProduct;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
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
        Route::model('meta',MetaProduct::class);
        Route::model('color',ColorProduct::class);
        Route::model('gallery',GalleryProduct::class);
        Route::model('attribute',AttributeCategory::class);

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
