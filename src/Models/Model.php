<?php

namespace Astrotomic\Webmentions\Models;

abstract class Model
{
    public function __construct(array $attributes)
    {
        foreach ($attributes as $field => $value) {
            $this->{$field} = $value;
        }
    }
}
