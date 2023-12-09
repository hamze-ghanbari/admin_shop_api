<?php

namespace App\Providers;

use App\Repository\Contracts\BannerRepositoryInterface;
use App\Repository\Contracts\BrandRepositoryInterface;
use App\Repository\Contracts\CategoryRepositoryInterface;
use App\Repository\Contracts\ColorProductRepositoryInterface;
use App\Repository\Contracts\DeliveryRepositoryInterface;
use App\Repository\Contracts\MailFileRepositoryInterface;
use App\Repository\Contracts\MailRepositoryInterface;
use App\Repository\Contracts\MetaProductRepositoryInterface;
use App\Repository\Contracts\OtpRepositoryInterface;
use App\Repository\Contracts\ProductRepositoryInterface;
use App\Repository\Contracts\RoleRepositoryInterface;
use App\Repository\Contracts\UserRepositoryInterface;
use App\Repository\Eloquent\BannerRepository;
use App\Repository\Eloquent\BrandRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\ColorProductRepository;
use App\Repository\Eloquent\DeliveryRepository;
use App\Repository\Eloquent\MailFileRepository;
use App\Repository\Eloquent\MailRepository;
use App\Repository\Eloquent\MetaProductRepository;
use App\Repository\Eloquent\OtpRepository;
use App\Repository\Eloquent\ProductRepository;
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
        MailRepositoryInterface::class => MailRepository::class,
        MailFileRepositoryInterface::class => MailFileRepository::class,
        BannerRepositoryInterface::class => BannerRepository::class,
        DeliveryRepositoryInterface::class => DeliveryRepository::class,
        ProductRepositoryInterface::class => ProductRepository::class,
        MetaProductRepositoryInterface::class => MetaProductRepository::class,
        ColorProductRepositoryInterface::class => ColorProductRepository::class
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
