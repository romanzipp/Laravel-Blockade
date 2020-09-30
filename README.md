# Laravel Blockade

[![Latest Stable Version](https://img.shields.io/packagist/v/romanzipp/Laravel-Blockade.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-blockade)
[![Total Downloads](https://img.shields.io/packagist/dt/romanzipp/Laravel-Blockade.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-blockade)
[![License](https://img.shields.io/packagist/l/romanzipp/Laravel-Blockade.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-blockade)
[![GitHub Build Status](https://img.shields.io/github/workflow/status/romanzipp/Laravel-Blockade/Tests?style=flat-square)](https://github.com/romanzipp/Laravel-Blockade/actions)

A simple but highly customizable package for preventing access to WIP Laravel projects.

## Installation

```
composer require romanzipp/laravel-blockade
```

**If you use Laravel 5.5+ you are already done, otherwise continue.**

Add Service Provider to your `app.php` configuration file:

```php
romanzipp\Blockade\Providers\BlockadeServiceProvider::class,
```

## Configuration

Copy configuration to config folder:

```
$ php artisan vendor:publish --provider="romanzipp\Blockade\Providers\BlockadeServiceProvider"
```

## Usage

Add the Blockade middleware to your HTTP kernel:

```php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use romanzipp\Blockade\Http\Middleware\BlockadeMiddleware;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ...
        BlockadeMiddleware::class,
        // ...
    ];
}
```

## Testing

```
./vendor/bin/phpunit
```
