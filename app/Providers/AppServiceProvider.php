<?php

namespace App\Providers;

use App\Repositories\EnderecoRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\EnderecoService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(EnderecoRepository::class, function ($app) {
            return new EnderecoRepository();
        });

        $this->app->singleton(EnderecoService::class, function ($app) {
            return new EnderecoService($app->make(EnderecoRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
