# Testing & Contributing

[← English docs](./README.md)

## Running tests

The package uses [Orchestra Testbench](https://github.com/orchestral/testbench) and PHPUnit.

```sh
composer install
composer test
```

### Coverage report

Requires the [PCOV](https://github.com/krakjoe/pcov) extension:

```sh
composer test:coverage
```

CI runs tests on every push and pull request. Coverage is published to [Codecov](https://codecov.io/gh/SaliBhdr/typhoon-iran-cities).

## Test structure

| Directory | Purpose |
|-----------|---------|
| `tests/Feature/` | Artisan commands, import flows, publish commands |
| `tests/Unit/` | Models, enums, support classes |
| `tests/fixtures/` | Minimal CSV files for import tests |
| `tests/Concerns/` | Shared test helpers (table creation, fixtures) |

## Contributing

Contributions, bug reports, and documentation fixes are welcome.

### Workflow

1. Fork the repository
2. Create a feature branch from `master` / `main`
3. Write tests for behavior changes
4. Run `composer test` locally
5. Open a pull request with a clear description

### Code style

- Follow existing patterns in `src/` — minimal scope, no over-abstraction
- Match Laravel conventions for commands and migrations
- Document user-facing changes in `CHANGELOG.md`

### Documentation

- English docs: `docs/en/`
- Persian docs: `docs/fa/`
- Keep both languages in sync for user-facing changes

## License

MIT — see [LICENSE](../../LICENSE).

Created by [Salar Bahador](https://github.com/SaliBhdr).

## Data attribution

Region data is based on [ahmadazizi/iran-cities](https://github.com/ahmadazizi/iran-cities) v3.

## Next steps

- [Documentation hub](../README.md)
- [GitHub Issues](https://github.com/SaliBhdr/typhoon-iran-cities/issues)
