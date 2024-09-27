<?php

namespace App\Providers;

use App\Repositories\Contracts\PaymentRepositoryContract;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentRepositoryContract::class, PaymentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(env('APP_ENV') === 'production')
        {
            URL::forceScheme('https');
        }
    }
}
