<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // The locale is set per request by App\Http\Middleware\SetLocale
        // (the session is not available yet at this point).

        // Behind the host's HTTPS proxy, make sure generated links use https.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
