<?php

namespace Astrotomic\Webmentions\Facades;

use Astrotomic\Webmentions\Client;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Astrotomic\Webmentions\Collections\WebmentionsCollection|\Astrotomic\Webmentions\Models\Entry[] get(?string $url = null)
 * @method static \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Like[] likes(?string $url = null)
 * @method static \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Mention[] mentions(?string $url = null)
 * @method static \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Reply[] replies(?string $url = null)
 * @method static \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Repost[] reposts(?string $url = null)
 */
class Webmentions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Client::class;
    }
}
