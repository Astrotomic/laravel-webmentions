# Laravel Webmentions

[![Latest Version](http://img.shields.io/packagist/v/astrotomic/laravel-webmentions.svg?label=Release&style=for-the-badge)](https://packagist.org/packages/astrotomic/laravel-webmentions)
[![MIT License](https://img.shields.io/github/license/Astrotomic/laravel-webmentions.svg?label=License&color=blue&style=for-the-badge)](https://github.com/Astrotomic/laravel-webmentions/blob/master/LICENSE)
[![Offset Earth](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-green?style=for-the-badge)](https://plant.treeware.earth/Astrotomic/laravel-webmentions)
[![Larabelles](https://img.shields.io/badge/Larabelles-%F0%9F%A6%84-lightpink?style=for-the-badge)](https://www.larabelles.com/)

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/Astrotomic/laravel-webmentions/run-tests?style=flat-square&logoColor=white&logo=github&label=Tests)](https://github.com/Astrotomic/laravel-webmentions/actions?query=workflow%3Arun-tests)
[![StyleCI](https://styleci.io/repos/322693045/shield)](https://styleci.io/repos/322693045)
[![Total Downloads](https://img.shields.io/packagist/dt/astrotomic/laravel-webmentions.svg?label=Downloads&style=flat-square)](https://packagist.org/packages/astrotomic/laravel-webmentions)

A simple client to retrieve [webmentions](https://webmention.io) for your pages.

## Installation

You can install the package via composer:

```bash
composer require astrotomic/laravel-webmentions
```

## Configuration

At firsts you will have to add your [webmention.io](https://webmention.io) API access token to the `services.php` config file.

```php
return [
    // ...
    'webmention' => [
        'token' => env('WEBMENTION_TOKEN'),
    ],
    // ...
];
```

## Usage

You can retrieve all webmentions for a given URL by calling the `get()` method on the packages client.

```php
use Astrotomic\Webmentions\Facades\Webmentions;

$records = Webmentions::get('https://gummibeer.dev/blog/2020/human-readable-intervals');
```

If you omit the url as argument it will automatically use `\Illuminate\Http\Request::url()` as default.
The return value will be an instance of `\Astrotomic\Webmentions\Collections\WebmentionsCollection` which provides you with predefined filter methods.
You can also use the shorthand methods on the client to retrieve a collection of likes, mentions, replies or reposts.

```php
use Astrotomic\Webmentions\Facades\Webmentions;

$likes = Webmentions::likes('https://gummibeer.dev/blog/2020/human-readable-intervals');
$mentions = Webmentions::mentions('https://gummibeer.dev/blog/2020/human-readable-intervals');
$replies = Webmentions::replies('https://gummibeer.dev/blog/2020/human-readable-intervals');
$reposts = Webmentions::reposts('https://gummibeer.dev/blog/2020/human-readable-intervals');
```

All items will be a corresponding instance of `\Astrotomic\Webmentions\Models\Like`, `\Astrotomic\Webmentions\Models\Mention`, `\Astrotomic\Webmentions\Models\Reply` or `\Astrotomic\Webmentions\Models\Repost`.

If you only need the count of items you can use the `Webmentions::count()` method.

```php
use Astrotomic\Webmentions\Facades\Webmentions;

$counts = Webmentions::count('https://gummibeer.dev/blog/2020/human-readable-intervals');
[
  'count' => 52,
  'type' => [
    'like' => 23,
    'mention' => 8,
    'reply' => 16,
    'repost' => 5,
  ],
];
```

### Caching

The client uses a poor man cache by default - so per runtime every domain is only requested once.
If you want extended caching behavior you should wrap the calls in a `Cache::remember()` for example.

### Blade Component

To receive webmentions for your page you have to add two `<link/>` tags to your head.
This package provides a `<x-webmention-links/>` Blade component that makes it easier for you.

```html
<x-webmention-links />
<!-- will use the domain of current request -->
<x-webmention-links domain="gummibeer.dev" />
<!-- will use the given domain -->

<!-- RESULT -->
<link rel="webmention" href="https://webmention.io/gummibeer.dev/webmention" />
<link rel="pingback" href="https://webmention.io/gummibeer.dev/xmlrpc" />
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/Astrotomic/.github/blob/master/CONTRIBUTING.md) for details. You could also be interested in [CODE OF CONDUCT](https://github.com/Astrotomic/.github/blob/master/CODE_OF_CONDUCT.md).

### Security

If you discover any security related issues, please check [SECURITY](https://github.com/Astrotomic/.github/blob/master/SECURITY.md) for steps to report it.

## Credits

-   [Tom Witkowski](https://github.com/Gummibeer)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment I would highly appreciate you buying the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to [plant trees](https://www.bbc.co.uk/news/science-environment-48870920). If you contribute to my forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees at [offset.earth/treeware](https://plant.treeware.earth/Astrotomic/laravel-webmentions)

Read more about Treeware at [treeware.earth](https://treeware.earth)
