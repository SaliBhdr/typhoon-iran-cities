# FAQ & Troubleshooting

[← English docs](./README.md)

## Installation

### Commands not found after `composer require`

**Cause:** Package discovery failed or config cached on old provider list.

**Fix:**

```sh
composer dump-autoload
php artisan package:discover
php artisan list iran
```

On Laravel &lt; 5.5, register the provider manually — see [Installation](./installation.md).

### `composer update` fails with PHP version conflict

**Cause:** Latest package requires PHP 8.3+ but your app runs PHP 8.2.

**Fix:** Pin to 3.1 until you upgrade PHP:

```json
"salibhdr/typhoon-iran-cities": "^3.1"
```

---

## Import

### "Table does not exist" during import

**Cause:** Migrations not run, or `--target` / `--unite` mismatch between publish and import.

**Fix:**

```sh
php artisan migrate
# Use the same --unite and --target flags for publish and import
php artisan iran:import --target=cities
```

### Import times out on shared hosting

**Cause:** PHP `max_execution_time` or memory limits.

**Fix:** The import command removes limits when allowed. If the host overrides this:

- Run import via CLI (SSH), not web
- Import smaller targets: `--target=cities` instead of `all`
- Ask host to raise limits for the Artisan process

### Re-import does not show new data

**Cause:** Import upserts into existing rows; stale rows remain.

**Fix:**

```sh
php artisan iran:import --fresh --target=all
```

---

## Publishing

### Published files already exist

**Cause:** Re-running publish without `--force`.

**Fix:**

```sh
php artisan iran:publish:migrations --force
php artisan iran:publish:models --force
```

Review git diff before committing — merge local customizations.

### Can I remove the package after publishing models?

**No.** Published models extend `SaliBhdr\TyphoonIranCities\Models\*`. Removing the package causes class-not-found errors.

Published **migrations** do not depend on the package namespace.

---

## Usage

### `active()` returns fewer cities than expected

**Cause:** A parent province, county, or sector is inactive.

**Fix:** Check ancestor status — see [Status field](./status-field.md).

### Unite vs. separate — wrong model class

**Cause:** Published with `--unite` but querying `IranCity`, or vice versa.

**Fix:** Match queries to your storage mode — [Storage modes](./storage-modes.md).

### Foreign key errors on migrate

**Cause:** Migrations ran out of order or partial `--target` left missing parent tables.

**Fix:** Publish with a target that includes all required ancestors, or use `--target=all`. Drop and re-migrate in development if needed.

---

## Version selection

### Which version for Laravel 11?

```json
"salibhdr/typhoon-iran-cities": "^3.1"
```

Do not install latest (4.x / main) until the app runs Laravel 13.

### Which version for Laravel 8 legacy project?

```json
"salibhdr/typhoon-iran-cities": "^3.1"
```

3.1 still supports Laravel 5+. Test thoroughly in staging.

---

## Getting help

1. Search [existing issues](https://github.com/SaliBhdr/typhoon-iran-cities/issues)
2. Include: package version, Laravel version, PHP version, exact command, full error message
3. Open a new issue with reproduction steps

## Next steps

- [Upgrade guide](./upgrade-guide.md)
- [Testing & contributing](./testing-and-contributing.md)
