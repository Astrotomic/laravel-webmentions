<?php

namespace Astrotomic\Webmentions;

use Illuminate\Support\ServiceProvider;

class WebmentionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('webmentions.php'),
            ], 'config');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'webmentions');

        $this->app->singleton(Client::class);
    }
}
