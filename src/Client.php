<?php

namespace Astrotomic\Webmentions;

use Astrotomic\Webmentions\Collections\WebmentionCollection;
use Astrotomic\Webmentions\Models\Entry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class Client
{
    protected const BASE_URL = 'https://webmention.io/api/mentions.jf2';

    protected const PER_PAGE = 1000;

    /** @var WebmentionCollection[] */
    protected static array $webmentions = [];

    public function get(?string $url = null): WebmentionCollection
    {
        $url ??= Request::url();
        $domain = parse_url($url, PHP_URL_HOST);

        return $this->byDomain($domain)
            ->filter(fn (Entry $entry): bool => $this->extractPath($entry->target) === $this->extractPath($url))
            ->values();
    }

    public function likes(?string $url = null): Collection
    {
        return $this->get($url)->likes();
    }

    public function mentions(?string $url = null): Collection
    {
        return $this->get($url)->mentions();
    }

    public function replies(?string $url = null): Collection
    {
        return $this->get($url)->replies();
    }

    public function reposts(?string $url = null): Collection
    {
        return $this->get($url)->reposts();
    }

    protected function byDomain(string $domain): WebmentionCollection
    {
        if (! isset(static::$webmentions[$domain])) {
            $webmentions = new WebmentionCollection();

            $page = 0;
            do {
                $entries = Http::get(self::BASE_URL, [
                    'token'    => config('services.webmention.token'),
                    'domain'   => $domain,
                    'per-page' => self::PER_PAGE,
                    'page'     => $page,
                ])->json()['children'] ?? [];

                $webmentions->push(...$entries);

                $page++;
            } while (count($entries) >= self::PER_PAGE);

            static::$webmentions[$domain] = $webmentions
                ->map(fn (array $entry): ?Entry => Entry::make($entry))
                ->filter()
                ->values();
        }

        return static::$webmentions[$domain];
    }

    protected function extractPath(string $url): ?string
    {
        return trim(parse_url($url, PHP_URL_PATH), '/');
    }
}
