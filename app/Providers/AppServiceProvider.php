<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Coupon
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\CouponRepositoryInterface::class,
            \App\Repositories\CouponRepository::class
        );

        // Group
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\GroupRepositoryInterface::class,
            \App\Repositories\GroupRepository::class
        );

        // User
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );

        // Banner
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\BannerRepositoryInterface::class,
            \App\Repositories\BannerRepository::class
        );

        // Category Article
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\CategoryArticleRepositoryInterface::class,
            \App\Repositories\CategoryArticleRepository::class
        );

        // Article
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\ArticleRepositoryInterface::class,
            \App\Repositories\ArticleRepository::class
        );

        // Category Product
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\CategoryProductRepositoryInterface::class,
            \App\Repositories\CategoryProductRepository::class
        );

        // Product
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\ProductRepositoryInterface::class,
            \App\Repositories\ProductRepository::class
        );

        // Mailbox
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\MailboxRepositoryInterface::class,
            \App\Repositories\MailboxRepository::class
        );

        // Setting
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\SettingRepositoryInterface::class,
            \App\Repositories\SettingRepository::class
        );

        // BillDetail
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\BillDetailRepositoryInterface::class,
            \App\Repositories\BilldetailRepository::class
        );

        // Bill
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\BillRepositoryInterface::class,
            \App\Repositories\BillRepository::class
        );

        // Customer
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\CustomerRepositoryInterface::class,
            \App\Repositories\CustomerRepository::class
        );
        
        // Partner
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\PartnerRepositoryInterface::class,
            \App\Repositories\PartnerRepository::class
        );

        // Item
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\ItemRepositoryInterface::class,
            \App\Repositories\ItemRepository::class
        );

        // Room Type
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\RoomTypeRepositoryInterface::class,
            \App\Repositories\RoomTypeRepository::class
        );

        // Room
        $this->app->singleton(
            \App\Repositories\InterfaceRepository\RoomRepositoryInterface::class,
            \App\Repositories\RoomRepository::class
        );
    }
}
