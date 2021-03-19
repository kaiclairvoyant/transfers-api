<?php

namespace App\Providers;

use App\Interfaces\AuthorizationInterface;
use App\Interfaces\NotificationInterface;
use App\Services\AuthorizationService;
use App\Services\NotificationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationInterface::class, NotificationService::class);
        $this->app->bind(AuthorizationInterface::class, AuthorizationService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
