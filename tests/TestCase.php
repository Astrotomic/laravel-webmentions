<?php

namespace Astrotomic\Webmentions\Tests;

use Astrotomic\PhpunitAssertions\Laravel\BladeAssertions;
use Astrotomic\Webmentions\WebmentionsServiceProvider;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
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

    public function assertComponentRenders(string $expected, string $template, array $data = []): void
    {
        BladeAssertions::assertRenderEquals($expected, $template, $data);
    }
}
