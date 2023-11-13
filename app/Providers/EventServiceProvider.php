<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendEmailRegistered;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Mail;
use App\Models\MailFile;
use App\Models\Role;
use App\Models\User;
use App\Observers\BannerObserver;
use App\Observers\BrandObserver;
use App\Observers\CategoryObserver;
use App\Observers\DeliveryObserver;
use App\Observers\MailFileObserver;
use App\Observers\MailObserver;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $observers = [
        User::class => [UserObserver::class],
        Role::class => [RoleObserver::class],
        Category::class => [CategoryObserver::class],
        Brand::class => [BrandObserver::class],
        Mail::class => [MailObserver::class],
        MailFile::class => [MailFileObserver::class],
        Banner::class => [BannerObserver::class],
        Delivery::class => [DeliveryObserver::class]
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
