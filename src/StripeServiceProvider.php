<?php

namespace Ankurk91\StripeExceptions;

use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/stripe'),
        ], 'translations');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'stripe');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
