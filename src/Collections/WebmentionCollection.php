<?php

namespace Astrotomic\Webmentions\Collections;

use Astrotomic\Webmentions\Models\Entry;
use Astrotomic\Webmentions\Models\Like;
use Astrotomic\Webmentions\Models\Mention;
use Astrotomic\Webmentions\Models\Reply;
use Astrotomic\Webmentions\Models\Repost;
use Illuminate\Support\Collection;

class WebmentionCollection extends Collection
{
    /**
     * @return \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Like[]
     */
    public function likes(): Collection
    {
        return $this->filter(fn (Entry $entry): bool => $entry instanceof Like)->toBase();
    }

    /**
     * @return \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Mention[]
     */
    public function mentions(): Collection
    {
        return $this->filter(fn (Entry $entry): bool => $entry instanceof Mention)->toBase();
    }

    /**
     * @return \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Reply[]
     */
    public function replies(): Collection
    {
        return $this->filter(fn (Entry $entry): bool => $entry instanceof Reply)->toBase();
    }

    /**
     * @return \Illuminate\Support\Collection|\Astrotomic\Webmentions\Models\Mention[]
     */
    public function reposts(): Collection
    {
        return $this->filter(fn (Entry $entry): bool => $entry instanceof Repost)->toBase();
    }
}
