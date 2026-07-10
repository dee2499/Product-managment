<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force Bootstrap 5 styling for pagination links instead of default Tailwind CSS
        Paginator::useBootstrapFive();

        // Prevent lazy loading in local environment to avoid N+1 queries
        Model::preventLazyLoading(
            ! $this->app->isProduction()
        );

        // Strict model safety checks
        Model::shouldBeStrict(
            ! $this->app->isProduction()
        );
    }
}
