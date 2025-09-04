<?php

namespace App\Providers;

use App\Services\ProductService;
use App\Services\ProductServiceInterface;
use Doctrine\DBAL\Schema\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');

        view()->composer('*', function ($view)
        {
            if (auth()->check())
            {
                $productService = app(ProductServiceInterface::class);
                $notifications = $productService->myNotifications(auth()->user()->id);
                $view->with('myNotifications', $notifications);
            }
        });
    }
}
