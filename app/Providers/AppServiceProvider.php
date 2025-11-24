<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

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
        // Set Carbon locale to Dutch
        Carbon::setLocale('nl');

        // Set PHP locale for full Dutch month/day names
        setlocale(LC_TIME, 'nl_NL.UTF-8');
    }
}
