# Commands Reference

[← English docs](./README.md)

All commands share three strategic options (where applicable):

| Option | Description |
|--------|-------------|
| `--unite` | Store regions in `iran_regions` instead of separate tables |
| `--target=<level>` | Limit published/imported levels (default: `all`) |
| `--with-city-coordinates` | Include latitude/longitude for cities |

---

## `iran:init`

**Purpose:** Interactive wizard — publish migrations, publish models, migrate, import.

```sh
php artisan iran:init [options]
```

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing published files |
| `--unite` | Unite storage mode |
| `--target=all` | Target level(s) to include |
| `--with-city-coordinates` | Publish coordinate migration and import lat/lon |
| `--no-interaction` | Answer "yes" to all prompts (for CI) |

### Examples

```sh
# Interactive first-time setup
php artisan iran:init

# CI pipeline — cities only, separate tables
php artisan iran:init --no-interaction --force --target=cities

# Unite mode, all regions, with coordinates
php artisan iran:init --no-interaction --force --unite --with-city-coordinates
```

### What runs under the hood

1. `iran:publish:migrations`
2. `iran:publish:models`
3. `migrate`
4. `iran:import`

---

## `iran:publish:migrations`

**Purpose:** Copy migration stub files into `database/migrations/`.

```sh
php artisan iran:publish:migrations [options]
```

| Option | Description |
|--------|-------------|
| `--force` | Overwrite files that already exist |
| `--unite` | Publish `create_iran_regions_table` instead of per-level tables |
| `--target=all` | Publish only migrations needed for the target |
| `--with-city-coordinates` | Also publish coordinate migration |

### Examples

```sh
php artisan iran:publish:migrations --target=cities
php artisan iran:publish:migrations --unite --target=cities --force
php artisan iran:publish:migrations --target=cities --with-city-coordinates
```

After publishing, run:

```sh
php artisan migrate
```

---

## `iran:publish:models`

**Purpose:** Copy Eloquent model stubs into `app/Models/`.

```sh
php artisan iran:publish:models [options]
```

| Option | Description |
|--------|-------------|
| `--force` | Overwrite existing model files |
| `--unite` | Publish `IranRegion` only |
| `--target=all` | Publish models for levels included in target |

### Examples

```sh
php artisan iran:publish:models --target=cities
php artisan iran:publish:models --unite --force
```

> **Remember:** Published models extend package classes. Keep `salibhdr/typhoon-iran-cities` installed.

---

## `iran:import`

**Purpose:** Load CSV data from the package into your database tables.

```sh
php artisan iran:import [options]
```

| Option | Description |
|--------|-------------|
| `--unite` | Import into `iran_regions` |
| `--target=all` | Import levels included in target |
| `--with-city-coordinates` | Update city rows with lat/lon |
| `--fresh` | Truncate target tables before import |

### Examples

```sh
# First import (after migrate)
php artisan iran:import

# Re-import after package update with new CSV data
php artisan iran:import --fresh

# Cities + coordinates, separate tables
php artisan iran:import --target=cities --with-city-coordinates

# Unite mode re-import
php artisan iran:import --unite --fresh
```

### Behavior notes

- Removes PHP memory and time limits for large datasets
- Wraps each file import in a database transaction
- **Preflight check:** fails with a clear error if required tables are missing — run `migrate` first
- On shared hosting, ensure PHP `max_execution_time` allows long imports

---

## Target values

| Value | Imports |
|-------|---------|
| `all` | All seven levels |
| `provinces` | Provinces |
| `counties` | Provinces + counties |
| `sectors` | Through sectors |
| `cities` | Through cities |
| `city_districts` | Through city districts |
| `rural_districts` | Through rural districts |
| `villages` | Through villages |

Invalid targets throw an error at runtime.

---

## Typical workflows

### Production deploy (CI)

```sh
composer install --no-dev --optimize-autoloader
php artisan iran:publish:migrations --no-interaction --force --target=cities
php artisan iran:publish:models --no-interaction --force --target=cities
php artisan migrate --force
php artisan iran:import --target=cities --no-interaction
```

### Local development refresh

```sh
php artisan iran:import --fresh --target=all
```

### Add coordinates to existing cities setup

```sh
php artisan iran:publish:migrations --target=cities --with-city-coordinates --force
php artisan migrate
php artisan iran:import --target=cities --with-city-coordinates
```

## Next steps

- [City coordinates](./city-coordinates.md)
- [FAQ & troubleshooting](./faq-and-troubleshooting.md)
