<?php

namespace Astrotomic\Webmentions;

use Illuminate\Support\ServiceProvider;

class WebmentionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Client::class);
    }
}
