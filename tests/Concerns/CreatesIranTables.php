<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Concerns;

use SaliBhdr\TyphoonIranCities\Support\PackagePath;

trait CreatesIranTables
{
    protected function runMigrationStub(string $stubFile): void
    {
        $path = PackagePath::stubs('migrations') . DIRECTORY_SEPARATOR . $stubFile;

        $migration = require $path;

        $migration->up();
    }

    protected function migrateSeparateTablesUpToCities(): void
    {
        $this->runMigrationStub('1_create_iran_provinces_table.stub');
        $this->runMigrationStub('2_create_iran_counties_table.stub');
        $this->runMigrationStub('3_create_iran_sectors_table.stub');
        $this->runMigrationStub('4_create_iran_cities_table.stub');
    }

    protected function migrateAllSeparateTables(): void
    {
        $this->migrateSeparateTablesUpToCities();
        $this->runMigrationStub('5_create_iran_city_districts_table.stub');
        $this->runMigrationStub('6_create_iran_rural_districts_table.stub');
        $this->runMigrationStub('7_create_iran_villages_table.stub');
    }

    protected function migrateUniteTables(): void
    {
        $this->runMigrationStub('8_create_iran_regions_table.stub');
    }

    protected function fixturesPath(): string
    {
        return dirname(__DIR__) . '/fixtures';
    }
}
