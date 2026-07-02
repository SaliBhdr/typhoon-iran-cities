# Quick Start

[← English docs](./README.md)

This guide gets you from a fresh Laravel app to imported Iran region data in the fewest steps.

## Prerequisites

- Laravel and PHP versions matching [Requirements & versioning](./requirements-and-versioning.md)
- Database configured in `.env`
- Package installed: `composer require salibhdr/typhoon-iran-cities`

## Path A — Full setup (all regions, separate tables)

The default strategy: one table per administrative level.

```sh
# 1. Publish migrations & models, migrate, import (interactive)
php artisan iran:init

# Or non-interactive:
php artisan iran:init --no-interaction --force
```

What happens:

1. Migration stubs copy to `database/migrations/`
2. Model stubs copy to `app/Models/`
3. `php artisan migrate` runs
4. CSV data imports into `iran_provinces`, `iran_counties`, … `iran_villages`

Verify:

```php
use App\Models\IranProvince;

IranProvince::count(); // 31
```

## Path B — Cities only (lighter footprint)

When you only need provinces through cities (no districts or villages):

```sh
php artisan iran:init --no-interaction --force --target=cities
php artisan migrate --no-interaction
```

Published artifacts: `IranProvince`, `IranCounty`, `IranSector`, `IranCity` models and their migrations.

## Path C — Single unified table (unite mode)

All region types in one `iran_regions` table:

```sh
php artisan iran:init --no-interaction --force --unite
php artisan migrate --no-interaction
```

Use the `IranRegion` model with `type`-based queries. Details in [Storage modes](./storage-modes.md).

## Path C + cities with coordinates

```sh
php artisan iran:init \
  --no-interaction --force \
  --target=cities \
  --with-city-coordinates
```

See [City coordinates](./city-coordinates.md).

## Manual step-by-step

If you prefer control over each step:

```sh
# 1. Publish
php artisan iran:publish:migrations --target=all
php artisan iran:publish:models --target=all

# 2. Migrate
php artisan migrate

# 3. Import
php artisan iran:import
```

## Re-import after data updates

When upstream CSV data changes in a new package release:

```sh
php artisan iran:import --fresh
```

`--fresh` truncates target tables (respecting `--target`) before importing.

## Common options reference

| Option | Values | Default | Purpose |
|--------|--------|---------|---------|
| `--target` | `all`, `provinces`, `counties`, `sectors`, `cities`, `city_districts`, `rural_districts`, `villages` | `all` | Limit which levels to publish/import |
| `--unite` | flag | off | Use single `iran_regions` table |
| `--with-city-coordinates` | flag | off | Add lat/lon for cities |
| `--force` | flag | off | Overwrite existing published files |
| `--fresh` | flag | off | Truncate before import (`iran:import` only) |
| `--no-interaction` | flag | off | Skip prompts in `iran:init` |

## Next steps

- [Commands reference](./commands-reference.md) — full option documentation
- [Models & relationships](./models-and-relationships.md) — query your data
- [Status field](./status-field.md) — understand `active()` scopes
