# Typhoon Iran Cities — Documentation

> **Typhoon Iran Cities** is a Laravel package that imports Iran's official administrative divisions — provinces, counties, sectors, cities, city districts, rural districts, and villages — into your database with Artisan commands.

Choose your language:

| | English | فارسی |
|---|---------|-------|
| **Full documentation** | [English docs](./en/README.md) | [مستندات فارسی](./fa/README.md) |

---

## Documentation map

The guides below are mirrored in both languages. Start with **Introduction**, then follow the path that matches your situation (new project vs. upgrade).

### Getting started

| Guide | English | فارسی |
|-------|---------|-------|
| Introduction | [en/introduction.md](./en/introduction.md) | [fa/introduction.md](./fa/introduction.md) |
| Requirements & version matrix | [en/requirements-and-versioning.md](./en/requirements-and-versioning.md) | [fa/requirements-and-versioning.md](./fa/requirements-and-versioning.md) |
| Installation | [en/installation.md](./en/installation.md) | [fa/installation.md](./fa/installation.md) |
| Quick start | [en/quick-start.md](./en/quick-start.md) | [fa/quick-start.md](./fa/quick-start.md) |

### Core concepts

| Guide | English | فارسی |
|-------|---------|-------|
| Storage modes (separate vs. unite) | [en/storage-modes.md](./en/storage-modes.md) | [fa/storage-modes.md](./fa/storage-modes.md) |
| Commands reference | [en/commands-reference.md](./en/commands-reference.md) | [fa/commands-reference.md](./fa/commands-reference.md) |
| Models & relationships | [en/models-and-relationships.md](./en/models-and-relationships.md) | [fa/models-and-relationships.md](./fa/models-and-relationships.md) |
| Status field behavior | [en/status-field.md](./en/status-field.md) | [fa/status-field.md](./fa/status-field.md) |
| City coordinates | [en/city-coordinates.md](./en/city-coordinates.md) | [fa/city-coordinates.md](./fa/city-coordinates.md) |

### Upgrades & support

| Guide | English | فارسی |
|-------|---------|-------|
| Upgrade guide | [en/upgrade-guide.md](./en/upgrade-guide.md) | [fa/upgrade-guide.md](./fa/upgrade-guide.md) |
| FAQ & troubleshooting | [en/faq-and-troubleshooting.md](./en/faq-and-troubleshooting.md) | [fa/faq-and-troubleshooting.md](./fa/faq-and-troubleshooting.md) |
| Testing & contributing | [en/testing-and-contributing.md](./en/testing-and-contributing.md) | [fa/testing-and-contributing.md](./fa/testing-and-contributing.md) |

---

## Which package version should I use?

| Your Laravel version | Recommended package version |
|----------------------|----------------------------|
| Laravel 13+ | Latest (`^4.0` when released; current `main` branch) |
| Laravel 5 – 12 | `^3.1` |
| Legacy apps (provinces / counties / cities only) | `^1.3` (not recommended for new projects) |

See the full matrix in [Requirements & versioning (EN)](./en/requirements-and-versioning.md) or [نیازمندی‌ها و نسخه‌ها (FA)](./fa/requirements-and-versioning.md).

---

## Administrative divisions overview

![Administrative divisions of Iran](./images/administrative_divisions_of_Iran.jpg)

| Level | Persian | Database (separate mode) |
|-------|---------|--------------------------|
| Province | استان | `iran_provinces` |
| County | شهرستان | `iran_counties` |
| Sector | بخش | `iran_sectors` |
| City | شهر | `iran_cities` |
| City district | منطقه شهری | `iran_city_districts` |
| Rural district | دهستان | `iran_rural_districts` |
| Village | آبادی | `iran_villages` |

In **unite mode**, all levels live in a single `iran_regions` table with a `type` column.

---

## External links

- [Packagist](https://packagist.org/packages/salibhdr/typhoon-iran-cities)
- [GitHub repository](https://github.com/SaliBhdr/typhoon-iran-cities)
- [Issue tracker](https://github.com/SaliBhdr/typhoon-iran-cities/issues)
- [Changelog](../CHANGELOG.md)
- Data source: [ahmadazizi/iran-cities](https://github.com/ahmadazizi/iran-cities)
