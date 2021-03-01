<?php

namespace Astrotomic\Webmentions\Tests\Components;

use Astrotomic\Webmentions\Tests\TestCase;
use Illuminate\Http\Request;

class WebmentionLinksTest extends TestCase
{
    /** @test */
    public function it_renders_with_explicit_domain(): void
    {
        $this->assertComponentRenders(
            '<link rel="webmention" href="https://webmention.io/gummibeer.dev/webmention" />'.PHP_EOL.
            '<link rel="pingback" href="https://webmention.io/gummibeer.dev/xmlrpc" />',
            '<x-webmention-links domain="gummibeer.dev" />'
        );
    }

    /** @test */
    public function it_renders_for_current_request(): void
    {
        $request = Request::create('https://gummibeer.dev', 'GET');
        $this->app->instance('request', $request);

        $this->assertComponentRenders(
            '<link rel="webmention" href="https://webmention.io/gummibeer.dev/webmention" />'.PHP_EOL.
            '<link rel="pingback" href="https://webmention.io/gummibeer.dev/xmlrpc" />',
            '<x-webmention-links />'
        );
    }
}
