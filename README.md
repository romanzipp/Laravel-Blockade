# Laravel Blockade

[![Latest Stable Version](https://img.shields.io/packagist/v/romanzipp/Laravel-Blockade.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-blockade)
[![Total Downloads](https://img.shields.io/packagist/dt/romanzipp/Laravel-Blockade.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-blockade)
[![License](https://img.shields.io/packagist/l/romanzipp/Laravel-Blockade.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-blockade)
[![GitHub Build Status](https://img.shields.io/github/workflow/status/romanzipp/Laravel-Blockade/Tests?style=flat-square)](https://github.com/romanzipp/Laravel-Blockade/actions)

A simple but highly customizable package for preventing access to private or WIP Laravel projects.

![](https://raw.githubusercontent.com/romanzipp/Laravel-Blockade/master/preview.png)

## Features

- Convenient access control for private projects or pages
- Simple, beautiful and fully customizable error page
- Replaceable authentication process & token storage

**Why not use the Laravel Maintenance Mode?** Blockade offers a simple way to share access to development or staging environments only by typing in a password. The authenticating user will return the intended URL after a successful login. The built in [Laravel Maintenance Mode](https://laravel.com/docs/8.x/configuration#maintenance-mode) uses a different approach by denying access in deployment or maintenance procedures.

## Installation

```
composer require romanzipp/laravel-blockade
```

## Configuration

Copy configuration & assets files to project folder:

```
php artisan vendor:publish --provider="romanzipp\Blockade\Providers\BlockadeServiceProvider" --tag=config --tag=public
```

You can also publish views (`--tag=views`) and language files (`--tag=lang`) to further customize the Blockade template.

## Usage

To enable Blockade, simply

1. Set the environment variables `BLOCKADE_ENABLED=true` & `BLOCKADE_PASSWORD=`
2. Register the [`BlockadeMiddleware`](./src/Http/Middleware/BlockadeMiddleware.php) class in your middleware stack.

```php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use romanzipp\Blockade\Http\Middleware\BlockadeMiddleware;

class Kernel extends HttpKernel
{
    // Globally for all routes

    protected $middleware = [
        // ...
        BlockadeMiddleware::class,
    ];

    // In a single middleware group

    protected $middlewareGroups = [
        'web' => [
            // ...
            BlockadeMiddleware::class,
        ]
    ];

    // As named middleware, applied in your routes file

    protected $routeMiddleware = [
        // ...
        'blockade' => BlockadeMiddleware::class,
    ];
}
```

The package defaults to the provided view for password prompt and stores the authentication hash in a cookie.

To reset previous granted access, just change the `BLOCKADE_PASSWORD` entry. All issued access tokens will be invalid on the next page request.

### Handlers

Handlers are responsible validating authentication requests and sending successful or failed responses. You can set the active handler in [`blockade.handler`](./config/blockade.php#L28) and customize each handler individually via the [`blockade.handlers.*`](./config/blockade.php#L51) config entries.

| Handler | Description | Class |
| --- | --- | --- |
| **Form** (default) | The password is provided by a form | [romanzipp\Blockade\Handlers\FormHandler](./src/Handlers/FormHandler.php) |
| Query Parameter | The password is attached as query parameter | [romanzipp\Blockade\Handlers\QueryParameterHandler](./src/Handlers/QueryParameterHandler.php) | 

### Stores

Stores are storing (how surprising) the authentication state for later requests. You can set the active store in [`blockade.store`](./config/blockade.php#L38) and customize each store individually via the [`blockade.stores.*`](./config/blockade.php#L81) config entries.

| Store | Description | Class |
| --- | --- | --- |
| **Cookies** (default) | The password hash will be stored as browser cookie | [romanzipp\Blockade\Stores\CookieStore](./src/Stores/CookieStore.php) |
| Session | The password hash will be stored in the active session | [romanzipp\Blockade\Stores\SessionStore](./src/Stores/SessionStore.php) | 

**Important**: If you are using the `SessionStore` make sure the `BlockadeMiddleware` is appended **after** the `Illuminate\Session\Middleware\StartSession` middleware.

## Extending

You can create your own authentication process by simply implementing the
 - [`romanzipp\Blockade\Handlers\Contracts\HandlerContract`](./src/Handlers/Contracts/HandlerContract.php) interface for handlers and
 - [`romanzipp\Blockade\Stores\Contracts\StoreContract`](./src/Stores/Contracts/StoreContract.php) interface for stores.

## Testing

```
./vendor/bin/phpunit
```

## Build Frontend

### Development

```
yarn dev
```

### Production

```
yarn prod
```

## Credits

Special thanks to [Katerina Limpitsouni](https://twitter.com/ninaLimpi) for the awesome [unDraw](https://undraw.co) SVG illustrations!
