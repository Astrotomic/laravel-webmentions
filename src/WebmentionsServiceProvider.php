<?php

namespace Astrotomic\Webmentions;

use Astrotomic\Webmentions\Components\WebmentionLinks;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class WebmentionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Client::class);
    }

    public function boot(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $blade->component(WebmentionLinks::class, 'webmention-links');
        });
    }
}
