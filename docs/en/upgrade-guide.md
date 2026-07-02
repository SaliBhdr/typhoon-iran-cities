# Upgrade Guide

[← English docs](./README.md)

Step-by-step instructions for moving between major package versions. Always upgrade in a **staging environment** first and back up your database.

## Before you begin

1. Read [Requirements & versioning](./requirements-and-versioning.md) — confirm Laravel and PHP support the target version
2. Pin or constrain the version in `composer.json` during transition
3. Note your current storage mode (`--unite` or separate) and `--target` — you must use the same flags after upgrade

---

## Upgrade to latest (Laravel 13 / PHP 8.3+)

**From:** package 3.1.x on Laravel ≤ 12  
**To:** latest (`^4.0` when tagged) on Laravel 13+

### 1. Upgrade the Laravel application

Follow the [Laravel 13 upgrade guide](https://laravel.com/docs/upgrade) for your app. Ensure PHP 8.3+.

### 2. Update the package

```sh
composer require salibhdr/typhoon-iran-cities:^4.0
# or, before 4.0 is tagged:
composer require salibhdr/typhoon-iran-cities:dev-master
```

### 3. Re-publish artifacts (optional but recommended)

New migration format (anonymous classes) and model stubs may have changed:

```sh
php artisan iran:publish:migrations --force --target=all   # add --unite if you use unite mode
php artisan iran:publish:models --force --target=all
```

Review diff in `database/migrations/` before migrating — merge any local customizations.

### 4. Migrate

```sh
php artisan migrate
```

If you only need new indexes or coordinate columns, Laravel runs incremental migrations.

### 5. Re-import if CSV data changed

```sh
php artisan iran:import --fresh --target=all   # add --unite / --with-city-coordinates as needed
```

### Breaking changes summary

| Change | Action |
|--------|--------|
| Laravel 13 + PHP 8.3 required | Upgrade app first |
| Command attribute signatures | No app code changes — CLI only |
| Enum internals (`RegionType`) | Only affects package code, not published models |
| `--fresh` flag | New — use for clean re-imports |
| Import preflight | Run `migrate` before `iran:import` |

---

## Upgrade from 2.x to 3.x

**From:** 2.x (separate tables only)  
**To:** 3.0+ (unite mode and `--target` available)

### 1. Update Composer

```sh
composer require salibhdr/typhoon-iran-cities:^3.1
```

Stay on `^3.1` if you are not ready for Laravel 13.

### 2. No schema change required (separate mode)

If you keep separate tables and `--target=all`, existing data remains valid. New commands and options are additive.

### 3. Adopt unite mode (optional)

Unite mode is **not** an in-place migration. To switch:

1. Export or drop existing region tables (backup first)
2. Publish unite migrations: `php artisan iran:publish:migrations --unite --force`
3. `php artisan migrate`
4. `php artisan iran:import --unite`

### 4. Adopt `--target` (optional)

Use `--target` on **new** installs or after `--fresh` re-import to trim unused levels.

### 5. Add city coordinates (3.1+)

See [City coordinates](./city-coordinates.md).

---

## Upgrade from 1.x to 2.x

**From:** 1.x (provinces, counties, cities)  
**To:** 2.x (full seven-level hierarchy)

### 1. Update Composer

```sh
composer require salibhdr/typhoon-iran-cities:^2.1
```

### 2. Publish new migrations

```sh
php artisan iran:publish:migrations --force
php artisan migrate
```

New tables: `iran_sectors`, `iran_city_districts`, `iran_rural_districts`, `iran_villages`.

### 3. Publish new models

```sh
php artisan iran:publish:models --force
```

### 4. Import new levels

```sh
php artisan iran:import
```

Existing province/county/city rows are upserted by official codes; new levels are inserted.

---

## Upgrade from 1.x directly to 3.x

Possible if you skip 2.x in Composer, but you must run 2.x migrations (full hierarchy). Follow the **1.x → 2.x** steps, then apply **2.x → 3.x** notes. Prefer stepping through 2.x in staging to isolate issues.

---

## Downgrading

Not recommended. Older versions may not support new tables or columns. If you must downgrade:

1. Restore database from backup taken before upgrade
2. Pin composer: `"salibhdr/typhoon-iran-cities": "^3.1"`
3. Re-publish artifacts from that version

---

## Checklist

| Step | Done |
|------|------|
| Backup database | ☐ |
| Read compatibility matrix | ☐ |
| Upgrade Laravel / PHP (if needed) | ☐ |
| `composer update salibhdr/typhoon-iran-cities` | ☐ |
| Re-publish migrations/models with same `--unite` / `--target` | ☐ |
| `php artisan migrate` | ☐ |
| `php artisan iran:import --fresh` (if data refresh needed) | ☐ |
| Run application test suite | ☐ |

## Next steps

- [FAQ & troubleshooting](./faq-and-troubleshooting.md)
- [CHANGELOG](../../CHANGELOG.md)
