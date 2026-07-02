# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Automated test suite with Orchestra Testbench and PHPUnit
- GitHub Actions CI workflow for PHP 8.3+
- Import preflight checks: fails with a clear message when tables are missing
- `--fresh` flag on `iran:import` to truncate target tables before re-importing
- Database indexes on `iran_regions.type` and `iran_regions.type, code`
- Replaced constant classes with backed PHP enums (`RegionType`, `MigrationStub`)
- Moved import target mapping to `Support\ImportTargetMap`
- `MigrationStub` enum replaces magic migration stub IDs
- Mass-assignment protection on `BaseIranModel` (`$guarded = ['id']`)

### Changed

- `composer.json` type changed from `package` to `library`
- Migration stubs 1–8 standardized to anonymous class format (Laravel 11+ style)
- Unite migration stub no longer references package enums (self-contained after publish)
- `iran:init` and publish commands respect `--no-interaction` (defaults to yes for all steps)
- Import wraps each file import in a database transaction
- City coordinate import uses row updates instead of upsert (avoids partial-insert failures)
- CSV parser cleanup (removed duplicate `array_combine`, streaming line read)

### Fixed

- README command typos (`iran:import` → correct publish commands)
- README typo "adn" → "and"

### Documentation

- Added "Package dependency" section explaining published models require the package to stay installed
- Clarified status deactivation semantics in README
- Documented non-interactive setup and `--fresh` re-import

## [3.1.0] - 2026

### Added

- City coordinates (latitude/longitude) support via `--with-city-coordinates`
- Coordinate migrations for separate tables and unite mode

### Changed

- Commands refactored to use Laravel 13 `#[Signature]` / `#[Description]` attributes
- Shared `PublishesIranCities` trait for publish commands

## [3.0.0] - 2026

### Changed

- **Breaking:** Requires Laravel 13 and PHP 8.3 or higher
- Minimum Illuminate component versions bumped to ^13.0

### Migration from 2.x

1. Upgrade your application to Laravel 13 and PHP 8.3+
2. Run `composer update salibhdr/typhoon-iran-cities`
3. Re-publish migrations/models if needed with `--force`
4. Re-run import if CSV data has changed
