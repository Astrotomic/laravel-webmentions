<?php

namespace Astrotomic\Webmentions\Models;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class Author extends DataTransferObject
{
    public string $name;
    public ?string $avatar;
    public ?string $url = null;

    public static function fromWebmention(array $author): self
    {
        return new static([
            'name' => $author['name'],
            'avatar' => $author['photo'] ?: null,
            'url' => $author['url'] ?: null,
        ]);
    }
}