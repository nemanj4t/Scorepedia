<?php

namespace App\Providers;

use App\RecommendationService;
use Illuminate\Support\ServiceProvider;

class RecommendationServiceProvider extends ServiceProvider
{

    protected $defer = true;
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RecommendationService::class, function ($app) {
            return new RecommendationService();
        });
    }

    public function provides()
    {
        return [RecommendationService::class];
    }
}
