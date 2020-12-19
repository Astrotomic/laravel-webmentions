<?php

namespace Astrotomic\Webmentions;

use Astrotomic\Webmentions\Models\Entry;
use Astrotomic\Webmentions\Models\Like;
use Astrotomic\Webmentions\Models\Mention;
use Astrotomic\Webmentions\Models\Reply;
use Astrotomic\Webmentions\Models\Repost;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class Client
{
    protected const BASE_URL = 'https://webmention.io/api/mentions.jf2';

    protected const PER_PAGE = 500;

    protected static array $webmentions = [];

    public function get(?string $url = null): Collection
    {
        $url ??= Request::url();
        $domain = parse_url($url, PHP_URL_HOST);

        return $this->byDomain($domain)->filter(
            fn(Entry $entry): bool => $this->extractPath($entry->target) === $this->extractPath($url)
        );
    }

    public function likes(?string $url = null): Collection
    {
        return $this->get($url)->filter(fn(Entry $entry): bool => $entry instanceof Like);
    }

    public function mentions(?string $url = null): Collection
    {
        return $this->get($url)->filter(fn(Entry $entry): bool => $entry instanceof Mention);
    }

    public function replies(?string $url = null): Collection
    {
        return $this->get($url)->filter(fn(Entry $entry): bool => $entry instanceof Reply);
    }

    public function reposts(?string $url = null): Collection
    {
        return $this->get($url)->filter(fn(Entry $entry): bool => $entry instanceof Repost);
    }

    protected function byDomain(string $domain): Collection
    {
        if (!isset(static::$webmentions[$domain])) {
            $webmentions = collect();

            $page = 0;
            do {
                $entries = Http::get(self::BASE_URL, [
                        'token' => config('services.webmention.token'),
                        'domain' => $domain,
                        'per-page' => self::PER_PAGE,
                        'page' => $page,
                    ])->json()['children'] ?? [];

                $webmentions->push(...$entries);

                $page++;
            } while (count($entries) >= self::PER_PAGE);

            static::$webmentions[$domain] = $webmentions
                ->map(fn(array $entry): ?Entry => Entry::make($entry))
                ->filter();
        }

        return static::$webmentions[$domain];
    }

    protected function extractPath(string $url): ?string
    {
        return trim(parse_url($url, PHP_URL_PATH), '/');
    }
}
