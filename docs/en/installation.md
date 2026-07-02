# Installation

[← English docs](./README.md)

## 1. Check compatibility

Before installing, confirm your Laravel and PHP versions against the [compatibility matrix](./requirements-and-versioning.md).

## 2. Require via Composer

```sh
composer require salibhdr/typhoon-iran-cities
```

To stay on a specific major line:

```sh
# Laravel 11/12
composer require salibhdr/typhoon-iran-cities:^3.1

# Laravel 13+
composer require salibhdr/typhoon-iran-cities
```

## 3. Verify Artisan commands

After installation, these commands should be available:

```sh
php artisan list iran
```

Expected output includes:

| Command | Purpose |
|---------|---------|
| `iran:init` | Interactive setup wizard |
| `iran:publish:migrations` | Copy migration stubs to `database/migrations` |
| `iran:publish:models` | Copy model stubs to `app/Models` |
| `iran:import` | Import CSV data into published tables |

## 4. Service provider (legacy Laravel only)

Laravel 5.5+ discovers the provider automatically. On older apps using package ≤ 3.1, register manually:

```php
// config/app.php
'providers' => [
    SaliBhdr\TyphoonIranCities\IranCitiesServiceProvider::class,
],
```

## 5. Database connection

Ensure `.env` has a working database connection. The import commands use your default connection.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 6. Publish and migrate

Choose one path:

**Interactive (recommended for first-time setup)**

```sh
php artisan iran:init
```

**Non-interactive (CI / scripts)**

```sh
php artisan iran:init --no-interaction --force
php artisan migrate --no-interaction
```

See [Quick start](./quick-start.md) for detailed walkthroughs including `--target` and `--unite`.

## Package dependency after publishing models

Published models in `app/Models` extend package base classes. **Do not remove** `salibhdr/typhoon-iran-cities` from `composer.json` after publishing — your app depends on it at runtime.

Published migrations are copied verbatim and can be edited independently.

## Next steps

- [Quick start](./quick-start.md)
- [Storage modes](./storage-modes.md) — decide separate vs. unite before publishing
