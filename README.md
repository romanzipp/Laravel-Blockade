# Laravel Blockade

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
