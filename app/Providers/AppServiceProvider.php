<?php

namespace App\Providers;

use App\Services\Interfaces\UserBalanceServiceInterface;
use App\Services\UserBalanceService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       $this->app->bind(UserBalanceServiceInterface::class, UserBalanceService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
