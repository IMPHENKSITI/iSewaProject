<?php

namespace App\Providers;

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
        // Register model observers for automatic receipt generation
        \App\Models\RentalBooking::observe(\App\Observers\RentalBookingObserver::class);
        \App\Models\GasOrder::observe(\App\Observers\GasOrderObserver::class);
    }
}
