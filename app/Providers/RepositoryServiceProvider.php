<?php

namespace App\Providers;

use App\Repository\Contracts\OtpRepositoryInterface;
use App\Repository\Contracts\RoleRepositoryInterface;
use App\Repository\Contracts\UserRepositoryInterface;
use App\Repository\Eloquent\OtpRepository;
use App\Repository\Eloquent\RoleRepository;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [
        OtpRepositoryInterface::class => OtpRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        RoleRepositoryInterface::class => RoleRepository::class
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
