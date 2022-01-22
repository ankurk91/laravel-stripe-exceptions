<?php
declare(strict_types=1);

namespace Ankurk91\StripeExceptions;

use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $langDirPath = __DIR__ . '/../resources/lang';

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $langDirPath => lang_path('vendor/stripe'),
            ], 'translations');
        }

        $this->loadTranslationsFrom($langDirPath, 'stripe');
    }

    public function register()
    {
        //
    }
}
