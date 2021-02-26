<?php

namespace Astrotomic\Webmentions\Models;

use Carbon\Carbon;
use Illuminate\Support\HtmlString;

abstract class Entry
{
    public int $id;
    public string $url;
    public string $source;
    public string $target;
    public ?Carbon $published_at;
    public Carbon $created_at;
    public Author $author;
    public array $raw;
    public ?string $text = null;
    public ?HtmlString $html = null;

    public static function make(array $entry): ?self
    {
        switch ($entry['wm-property']) {
            case 'like-of':
                return Like::fromWebmention($entry);
            case 'repost-of':
                return Repost::fromWebmention($entry);
            case 'mention-of':
                return Mention::fromWebmention($entry);
            case 'in-reply-to':
                return Reply::fromWebmention($entry);
            default:
                return null;
        }
    }

    public static function fromWebmention(array $entry): self
    {
        return new static([
            'id'           => $entry['wm-id'],
            'url'          => $entry['url'],
            'source'       => $entry['wm-source'],
            'target'       => $entry['wm-target'],
            'published_at' => $entry['published']
                ? Carbon::parse($entry['published'])
                : null,
            'created_at' => $entry['published']
                ? Carbon::parse($entry['published'])
                : Carbon::parse($entry['wm-received']),
            'author' => Author::fromWebmention($entry['author']),
            'text'   => $entry['content']['text'] ?? null,
            'html'   => isset($entry['content']['html'])
                ? new HtmlString($entry['content']['html'])
                : null,
            'raw' => $entry,
        ]);
    }

    public function __construct(array $attributes)
    {
        foreach ($attributes as $field => $value) {
            $this->{$field} = $value;
        }
    }
}
