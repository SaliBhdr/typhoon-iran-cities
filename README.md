# Typhoon Iran Cities

![SaliBhdr|typhoon][link-logo]

[![Tests][ico-tests]][link-tests]
[![Coverage][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]
[![Required Laravel Version][ico-laravel]][link-packagist]
[![Required PHP Version][ico-php]][link-packagist]
[![Latest Version][ico-version]][link-packagist]
[![License][ico-license]][link-packegist]
[![Today Downloads][ico-today-downloads]][link-downloads]

**English** · **[فارسی](./docs/fa/README.md)**

A Laravel package that imports Iran's administrative divisions — provinces, counties, sectors, cities, city districts, rural districts, and villages — into your database with Artisan commands. Includes Eloquent models, relationships, and optional city coordinates.

```sh
composer require salibhdr/typhoon-iran-cities
php artisan iran:init --no-interaction --force
```

Requires **Laravel 13** and **PHP 8.3+** on the latest release. Older Laravel apps should use [`^3.1`](./docs/en/requirements-and-versioning.md) — see the [version matrix](./docs/en/requirements-and-versioning.md).

![Administrative divisions of Iran](./docs/images/administrative_divisions_of_Iran.jpg)

---

## Documentation

Full documentation lives in [`docs/`](./docs/README.md) — available in **English** and **Persian (فارسی)**.

| | English | فارسی |
|---|---------|-------|
| **Start here** | [English docs](./docs/en/README.md) | [مستندات فارسی](./docs/fa/README.md) |
| **Hub / TOC** | [docs/README.md](./docs/README.md) | same |

### Table of contents

| Topic | EN | FA |
|-------|----|----|
| Introduction | [→](./docs/en/introduction.md) | [→](./docs/fa/introduction.md) |
| Requirements & versioning | [→](./docs/en/requirements-and-versioning.md) | [→](./docs/fa/requirements-and-versioning.md) |
| Installation | [→](./docs/en/installation.md) | [→](./docs/fa/installation.md) |
| Quick start | [→](./docs/en/quick-start.md) | [→](./docs/fa/quick-start.md) |
| Storage modes (separate / unite) | [→](./docs/en/storage-modes.md) | [→](./docs/fa/storage-modes.md) |
| Commands reference | [→](./docs/en/commands-reference.md) | [→](./docs/fa/commands-reference.md) |
| Models & relationships | [→](./docs/en/models-and-relationships.md) | [→](./docs/fa/models-and-relationships.md) |
| Status field | [→](./docs/en/status-field.md) | [→](./docs/fa/status-field.md) |
| City coordinates | [→](./docs/en/city-coordinates.md) | [→](./docs/fa/city-coordinates.md) |
| Upgrade guide | [→](./docs/en/upgrade-guide.md) | [→](./docs/fa/upgrade-guide.md) |
| FAQ & troubleshooting | [→](./docs/en/faq-and-troubleshooting.md) | [→](./docs/fa/faq-and-troubleshooting.md) |
| Testing & contributing | [→](./docs/en/testing-and-contributing.md) | [→](./docs/fa/testing-and-contributing.md) |

---

## Features at a glance

- All seven official division levels with relational data and codes
- **Separate tables** (default) or **unite mode** (single `iran_regions` table)
- Selective import with `--target` (e.g. cities only)
- Published migrations and models — you own the schema
- Active/inactive `status` with hierarchy-aware scopes
- City latitude/longitude via `--with-city-coordinates`
- Re-import with `--fresh` when upstream data updates

---

## Quick example

```php
use App\Models\IranCity;

IranCity::active()
    ->with('county.province')
    ->orderBy('name')
    ->get();
```

---

## Testing

```sh
composer test
composer test:coverage   # requires PCOV
```

Coverage runs in CI on every push and PR — [Codecov][link-coverage].

---

## Package dependency

Published **models** extend `SaliBhdr\TyphoonIranCities\Models\*` — **keep this package installed** after `iran:publish:models`.

Published **migrations** are self-contained and do not reference the package namespace.

---

## Changelog & upgrades

See [CHANGELOG.md](./CHANGELOG.md) and the [upgrade guide (EN)](./docs/en/upgrade-guide.md) / [راهنمای ارتقا (FA)](./docs/fa/upgrade-guide.md).

---

## License & credits

MIT License — [Salar Bahador][link-github].

Data based on [ahmadazizi/iran-cities][link-reference-repo] v3.

Issues: [GitHub][link-issues] · Contributions welcome.

Built with ❤ for you.

[ico-tests]: https://github.com/SaliBhdr/typhoon-iran-cities/actions/workflows/tests.yml/badge.svg
[ico-coverage]: https://codecov.io/gh/SaliBhdr/typhoon-iran-cities/branch/master/graph/badge.svg
[link-tests]: https://github.com/SaliBhdr/typhoon-iran-cities/actions/workflows/tests.yml
[link-coverage]: https://codecov.io/gh/SaliBhdr/typhoon-iran-cities
[ico-laravel]: https://img.shields.io/badge/Laravel-^13.0-ff2d20?style=flat-square&logo=laravel
[ico-php]: https://img.shields.io/badge/php-^8.3-8892bf?style=flat-square&logo=php
[ico-downloads]: https://poser.pugx.org/salibhdr/typhoon-iran-cities/downloads
[ico-today-downloads]: https://img.shields.io/packagist/dd/salibhdr/typhoon-iran-cities.svg?style=flat-square
[ico-license]: https://poser.pugx.org/salibhdr/typhoon-iran-cities/v/unstable
[ico-version]: https://img.shields.io/packagist/v/salibhdr/typhoon-iran-cities.svg?style=flat-square
[link-logo]: https://drive.google.com/a/domain.com/thumbnail?id=12yntFCiYIGJzI9FMUaF9cRtXKb0rXh9X
[link-packagist]: https://packagist.org/packages/salibhdr/typhoon-iran-cities
[link-downloads]: https://packagist.org/packages/salibhdr/typhoon-iran-cities/stats
[link-packegist]: https://packagist.org/packages/salibhdr/typhoon-iran-cities
[link-issues]: https://github.com/salibhdr/typhoon-iran-cities/issues
[link-github]: https://github.com/salibhdr/typhoon-iran-cities
[link-reference-repo]: https://github.com/ahmadazizi/iran-cities
