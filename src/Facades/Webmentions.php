<?php

namespace Astrotomic\Webmentions\Facades;

use Astrotomic\Webmentions\Client;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Astrotomic\Webmentions\Collections\WebmentionCollection|\Astrotomic\Webmentions\Models\Entry[] get(?string $url = null)
 * @method static \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Entry[] likes(?string $url = null)
 * @method static \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Entry[] mentions(?string $url = null)
 * @method static \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Entry[] replies(?string $url = null)
 * @method static \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Entry[] reposts(?string $url = null)
 */
class Webmentions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Client::class;
    }
}