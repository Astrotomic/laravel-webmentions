<?php

namespace Astrotomic\Webmentions\Components;

use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class WebmentionLinks extends Component
{
    protected string $domain;

    public function __construct(?string $domain = null)
    {
        $this->domain = $domain ?? parse_url(Request::url(), PHP_URL_HOST);
    }

    public function render(): string
    {
        return <<<HTML
        <link rel="webmention" href="https://webmention.io/{$this->domain}/webmention" />
        <link rel="pingback" href="https://webmention.io/{$this->domain}/xmlrpc" />
        HTML;
    }
}
