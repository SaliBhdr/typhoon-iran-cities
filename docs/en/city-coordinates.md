# City Coordinates

[← English docs](./README.md)

Available since package **3.1**. Adds latitude and longitude to city records from bundled CSV data.

## Requirements

- Package **3.1+** (or latest for Laravel 13)
- Target must include cities: `--target=all`, `cities`, or `city_districts`

## Enable coordinates

Coordinates require both a **migration** (schema) and an **import** (data).

### Separate tables

```sh
php artisan iran:publish:migrations --target=cities --with-city-coordinates
php artisan migrate
php artisan iran:import --target=cities --with-city-coordinates
```

Adds `latitude` and `longitude` columns to `iran_cities`.

### Unite mode

```sh
php artisan iran:publish:migrations --unite --target=cities --with-city-coordinates
php artisan migrate
php artisan iran:import --unite --target=cities --with-city-coordinates
```

Coordinates apply to rows where `type = 'city'` in `iran_regions`.

### One-shot with init

```sh
php artisan iran:init --no-interaction --force \
  --target=cities \
  --with-city-coordinates
```

## Querying coordinates

```php
use App\Models\IranCity;

$city = IranCity::whereNotNull('latitude')->first();

[$city->latitude, $city->longitude]; // [float, float]
```

## Add coordinates to an existing installation

If you already imported cities without coordinates:

```sh
php artisan iran:publish:migrations --target=cities --with-city-coordinates --force
php artisan migrate
php artisan iran:import --target=cities --with-city-coordinates
```

Re-import updates existing city rows in place (no `--fresh` required unless you want a full reset).

## Limitations

- Coordinates are provided for **cities only** (not provinces, villages, etc.)
- Data comes from bundled CSV — not live geocoding
- Accuracy depends on the upstream [iran-cities](https://github.com/ahmadazizi/iran-cities) dataset

## Roadmap

Future releases may add coordinates for additional region types. Track [CHANGELOG](../../CHANGELOG.md) and GitHub issues.

## Next steps

- [Commands reference](./commands-reference.md)
- [Quick start](./quick-start.md)
