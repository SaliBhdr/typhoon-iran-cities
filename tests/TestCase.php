<?php

namespace SaliBhdr\TyphoonIranCities\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SaliBhdr\TyphoonIranCities\IranCitiesServiceProvider;
use SaliBhdr\TyphoonIranCities\Tests\Concerns\CreatesIranTables;

abstract class TestCase extends Orchestra
{
    use CreatesIranTables;

    protected function getPackageProviders($app): array
    {
        return [
            IranCitiesServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function defineDatabaseMigrations(): void
    {
        // Migrations are applied per test via CreatesIranTables helpers.
    }
}
