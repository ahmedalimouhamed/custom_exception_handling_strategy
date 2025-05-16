<?php

namespace App\Providers;

use App\Exceptions\ApiExceptionHandler;
use App\Models\Order;
use App\Observers\OrderObserver;
use App\Services\Contracts\OrderServiceInterface;
use App\Services\OrderService;
use App\Models\Admin;
use App\Observers\AdminObserver;
use App\Models\Category;
use App\Observers\CategoryObserver;
use App\Models\Fournisseur;
use App\Observers\FournisseurObserver;
use App\Models\Product;
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->extend(ExceptionHandler::class, function(ExceptionHandler $handler, $app){
            return new ApiExceptionHandler($handler);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);
        Admin::observe(AdminObserver::class);
        Category::observe(CategoryObserver::class);
        Fournisseur::observe(FournisseurObserver::class);
        Product::observe(ProductObserver::class);
    }
}
