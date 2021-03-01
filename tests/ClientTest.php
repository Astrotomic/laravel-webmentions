<?php

namespace Astrotomic\Webmentions\Tests;

use Astrotomic\Webmentions\Collections\WebmentionsCollection;
use Astrotomic\Webmentions\Facades\Webmentions;
use Astrotomic\Webmentions\Models\Entry;
use Astrotomic\Webmentions\Models\Like;
use Astrotomic\Webmentions\Models\Mention;
use Astrotomic\Webmentions\Models\Reply;
use Astrotomic\Webmentions\Models\Repost;
use Illuminate\Support\Collection;

class ClientTest extends TestCase
{
    /** @test */
    public function it_returns_prepared_feed(): void
    {
        $feed = Webmentions::get('https://gummibeer.dev/blog/2020/human-readable-intervals');

        $this->assertInstanceOf(WebmentionsCollection::class, $feed);
        $this->assertCount(52, $feed);

        $feed->each(function ($actual): void {
            $this->assertInstanceOf(Entry::class, $actual);
            $this->assertStringStartsWith('https://gummibeer.dev/blog/2020/human-readable-intervals', $actual->target);
        });
    }

    /** @test */
    public function it_returns_likes(): void
    {
        $feed = Webmentions::likes('https://gummibeer.dev/blog/2020/human-readable-intervals');

        $this->assertInstanceOf(Collection::class, $feed);
        $this->assertCount(23, $feed);

        $feed->each(function ($actual): void {
            $this->assertInstanceOf(Like::class, $actual);
            $this->assertStringStartsWith('https://gummibeer.dev/blog/2020/human-readable-intervals', $actual->target);
        });
    }

    /** @test */
    public function it_returns_mentions(): void
    {
        $feed = Webmentions::mentions('https://gummibeer.dev/blog/2020/human-readable-intervals');

        $this->assertInstanceOf(Collection::class, $feed);
        $this->assertCount(8, $feed);

        $feed->each(function ($actual): void {
            $this->assertInstanceOf(Mention::class, $actual);
            $this->assertStringStartsWith('https://gummibeer.dev/blog/2020/human-readable-intervals', $actual->target);
        });
    }

    /** @test */
    public function it_returns_replies(): void
    {
        $feed = Webmentions::replies('https://gummibeer.dev/blog/2020/human-readable-intervals');

        $this->assertInstanceOf(Collection::class, $feed);
        $this->assertCount(16, $feed);

        $feed->each(function ($actual): void {
            $this->assertInstanceOf(Reply::class, $actual);
            $this->assertStringStartsWith('https://gummibeer.dev/blog/2020/human-readable-intervals', $actual->target);
        });
    }

    /** @test */
    public function it_returns_reposts(): void
    {
        $feed = Webmentions::reposts('https://gummibeer.dev/blog/2020/human-readable-intervals');

        $this->assertInstanceOf(Collection::class, $feed);
        $this->assertCount(5, $feed);

        $feed->each(function ($actual): void {
            $this->assertInstanceOf(Repost::class, $actual);
            $this->assertStringStartsWith('https://gummibeer.dev/blog/2020/human-readable-intervals', $actual->target);
        });
    }

    /** @test */
    public function it_returns_counts(): void
    {
        $counts = Webmentions::count('https://gummibeer.dev/blog/2020/human-readable-intervals');

        $this->assertIsArray($counts);
        $this->assertArrayHasKey('count', $counts);
        $this->assertSame(52, $counts['count']);

        $this->assertArrayHasKey('type', $counts);
        $this->assertArrayHasKey('like', $counts['type']);
        $this->assertSame(23, $counts['type']['like']);

        $this->assertArrayHasKey('mention', $counts['type']);
        $this->assertSame(8, $counts['type']['mention']);

        $this->assertArrayHasKey('reply', $counts['type']);
        $this->assertSame(16, $counts['type']['reply']);

        $this->assertArrayHasKey('repost', $counts['type']);
        $this->assertSame(5, $counts['type']['repost']);
    }
}
