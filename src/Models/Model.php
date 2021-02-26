<?php

namespace Astrotomic\Webmentions\Models;

use Carbon\Carbon;
use Illuminate\Support\HtmlString;

abstract class Model
{
    public function __construct(array $attributes)
    {
        foreach ($attributes as $field => $value) {
            $this->{$field} = $value;
        }
    }
}
