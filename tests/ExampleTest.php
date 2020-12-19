<?php

namespace Astrotomic\LaravelWebmentions\Tests;

use Astrotomic\Webmentions\Facades\Webmentions;
use Astrotomic\Webmentions\WebmentionsServiceProvider;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app): array
    {
        return [
            WebmentionsServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'webmention.io/api/mentions.jf2*' => Http::response(json_decode(file_get_contents(__DIR__.'/fixtures/gummibeer.dev.json'), true), 200),
        ]);
    }

    /** @test */
    public function it_returns_prepared_feed(): void
    {
        $feed = Webmentions::get('https://gummibeer.dev/blog/2020/human-readable-intervals');

        $feed->dump();
    }
}
