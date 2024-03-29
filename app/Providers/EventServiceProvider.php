<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendEmailRegistered;
use App\Models\AttributeCategory;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\ColorProduct;
use App\Models\Comment;
use App\Models\Delivery;
use App\Models\GalleryProduct;
use App\Models\Mail;
use App\Models\MailFile;
use App\Models\MetaProduct;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Observers\AttributeObserver;
use App\Observers\BannerObserver;
use App\Observers\BrandObserver;
use App\Observers\CategoryProductObserver;
use App\Observers\ColorProductObserver;
use App\Observers\CommentObserver;
use App\Observers\DeliveryObserver;
use App\Observers\GalleryProductObserver;
use App\Observers\MailFileObserver;
use App\Observers\MailObserver;
use App\Observers\MetaProductObserver;
use App\Observers\ProductObserver;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $observers = [
        User::class => [UserObserver::class],
        Role::class => [RoleObserver::class],
        CategoryProduct::class => [CategoryProductObserver::class],
        Brand::class => [BrandObserver::class],
        Mail::class => [MailObserver::class],
        MailFile::class => [MailFileObserver::class],
        Banner::class => [BannerObserver::class],
        Delivery::class => [DeliveryObserver::class],
        Product::class => [ProductObserver::class],
        MetaProduct::class => [MetaProductObserver::class],
        ColorProduct::class => [ColorProductObserver::class],
        GalleryProduct::class => [GalleryProductObserver::class],
        AttributeCategory::class => [AttributeObserver::class],
        Comment::class => [CommentObserver::class]
    ];
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegistered::class => [
            SendEmailRegistered::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
