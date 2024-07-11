<?php

namespace App\Providers;

use App\Repositories\BalanceTransactionRepository;
use App\Repositories\Interfaces\BalanceTransactionRepositoryInterface;
use App\Repositories\Interfaces\UserBalanceRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserBalanceRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            UserBalanceRepositoryInterface::class,
            UserBalanceRepository::class
        );
        $this->app->bind(
            BalanceTransactionRepositoryInterface::class,
            BalanceTransactionRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
