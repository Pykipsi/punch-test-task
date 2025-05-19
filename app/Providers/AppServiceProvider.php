<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\{UserRepositoryInterface, UserRepository};
use App\Services\Telegram\{TelegramCommandServiceInterface, TelegramCommandService};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TelegramCommandServiceInterface::class, TelegramCommandService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
