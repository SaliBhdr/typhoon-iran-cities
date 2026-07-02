# Requirements & Versioning

[← English docs](./README.md)

This page helps you choose the correct package version and understand breaking changes across major releases.

## Current requirements (latest / main branch)

| Requirement | Version |
|-------------|---------|
| PHP | **8.3** or higher (including 8.5) |
| Laravel | **13** or higher |
| Database | MySQL, MariaDB, PostgreSQL, or SQLite (any driver Laravel supports) |

Install:

```sh
composer require salibhdr/typhoon-iran-cities
```

## Version compatibility matrix

Use this table to match your **Laravel** version with a **package constraint**. Pin the version in `composer.json` when you cannot upgrade Laravel yet.

| Package version | Laravel | PHP | Region levels | Separate tables | Unite mode | `--target` | City coordinates |
|-----------------|---------|-----|---------------|-----------------|------------|------------|------------------|
| **Latest** (`main`, upcoming `^4.0`) | 13+ | 8.3+ | All 7 | Yes | Yes | Yes | Yes |
| **3.1.x** | 5 – 12 | ≥ 5.6 (8.x recommended) | All 7 | Yes | Yes | Yes | Yes |
| **3.0.x** | 5 – 12 | ≥ 5.6 | All 7 | Yes | Yes | Yes | No |
| **2.x** | 5 – 12 | ≥ 5.6 | All 7 | Yes | No | No | No |
| **1.x** | 5 – 12 | ≥ 5.6 | Province, county, city only | Yes | No | No | No |

### Composer constraints by scenario

```json
// Laravel 13+ (recommended for new projects)
"salibhdr/typhoon-iran-cities": "^4.0"

// Laravel 11 or 12 — stay on 3.1 until you upgrade Laravel
"salibhdr/typhoon-iran-cities": "^3.1"

// Laravel 8 – 10, need full hierarchy but no unite mode
"salibhdr/typhoon-iran-cities": "^2.1"

// Legacy: only provinces, counties, cities
"salibhdr/typhoon-iran-cities": "^1.3"
```

> **Tip:** If `composer update` pulls a major version you did not intend, add an explicit upper bound (e.g. `"^3.1 <4.0"`) until your app is ready to upgrade.

## Major release highlights

### 1.x — Foundation

- Provinces, counties, and cities
- Separate tables only
- Manual service-provider registration required on Laravel &lt; 5.5

### 2.x — Full administrative tree

- Added sectors, city districts, rural districts, villages
- Batch import performance improvements
- `short_code` column on all tables

### 3.0 — Flexible storage & selective import

- **`--unite`** — store everything in `iran_regions`
- **`--target`** — import a subset of levels
- **`iran:init`** wizard command

### 3.1 — City coordinates

- **`--with-city-coordinates`** on publish and import commands
- Latitude/longitude columns on cities (or regions in unite mode)

### Latest (4.x / main) — Laravel 13 modernization

- Requires **Laravel 13** and **PHP 8.3+**
- Command signatures use Laravel 13 `#[Signature]` attributes
- Backed PHP enums (`RegionType`, `MigrationStub`)
- Import preflight checks, `--fresh` re-import, transactional imports
- Published migrations use anonymous classes (Laravel 11+ style)
- Automated test suite and CI

See [CHANGELOG](../../CHANGELOG.md) for the full list.

## Laravel auto-discovery

On Laravel **5.5+**, the service provider registers automatically via package discovery. For older Laravel versions (only relevant when using package 1.x–3.1 on legacy apps), add manually to `config/app.php`:

```php
'providers' => [
    // ...
    SaliBhdr\TyphoonIranCities\IranCitiesServiceProvider::class,
],
```

## Next steps

- [Installation](./installation.md)
- [Upgrade guide](./upgrade-guide.md) — step-by-step migration from an older version
