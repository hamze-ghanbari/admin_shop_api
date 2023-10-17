<?php

namespace App\Providers;

use App\Repository\Contracts\BrandRepositoryInterface;
use App\Repository\Contracts\CategoryRepositoryInterface;
use App\Repository\Contracts\OtpRepositoryInterface;
use App\Repository\Contracts\RoleRepositoryInterface;
use App\Repository\Contracts\UserRepositoryInterface;
use App\Repository\Eloquent\BrandRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\OtpRepository;
use App\Repository\Eloquent\RoleRepository;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public array $singletons = [
        OtpRepositoryInterface::class => OtpRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        RoleRepositoryInterface::class => RoleRepository::class,
        CategoryRepositoryInterface::class => CategoryRepository::class,
        BrandRepositoryInterface::class => BrandRepository::class,
    ];

    public function register(): void
    {
//        $this->app->singleton(CategoryRepositoryInterface::class, function ($app) {
//            return new CategoryRepository();
//        });
    }

//    public function provides(): array
//    {
//        return [CategoryRepositoryInterface::class];
//    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
