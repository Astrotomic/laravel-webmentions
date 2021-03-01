<?php

namespace Astrotomic\Webmentions\Tests;

use Astrotomic\Webmentions\WebmentionsServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
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

    protected function blade(string $template, array $data = []): string
    {
        $tempDirectory = sys_get_temp_dir();

        if (! in_array($tempDirectory, View::getFinder()->getPaths())) {
            View::addLocation(sys_get_temp_dir());
        }

        $tempFile = tempnam($tempDirectory, 'laravel-blade').'.blade.php';

        file_put_contents($tempFile, $template);

        return view(Str::before(basename($tempFile), '.blade.php'), $data)->render();
    }
}
