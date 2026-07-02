<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use Illuminate\Support\Facades\DB;
use SaliBhdr\TyphoonIranCities\Enums\RegionType;
use SaliBhdr\TyphoonIranCities\Tests\Concerns\UsesFixtureCsv;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class ImportCoordinatesTest extends TestCase
{
    use UsesFixtureCsv;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bindFixtureCsv();
    }

    public function test_it_imports_coordinates_into_cities_table(): void
    {
        $this->migrateSeparateTablesUpToCities();
        $this->runMigrationStub('9_add_coordinates_to_iran_cities_table.stub');

        $this->artisan('iran:import', [
            '--target'                => 'cities',
            '--with-city-coordinates' => true,
        ])->assertSuccessful();

        $city = DB::table('iran_cities')->where('id', 1)->first();

        $this->assertEqualsWithDelta(35.6892, (float) $city->lat, 0.0001);
        $this->assertEqualsWithDelta(51.389, (float) $city->lon, 0.0001);
    }

    public function test_it_imports_coordinates_into_unite_regions_table(): void
    {
        $this->migrateUniteTables();
        $this->runMigrationStub('10_add_coordinates_to_iran_regions_table.stub');

        $this->artisan('iran:import', [
            '--unite'                   => true,
            '--target'                  => 'cities',
            '--with-city-coordinates'   => true,
        ])->assertSuccessful();

        $city = DB::table('iran_regions')
            ->where('type', RegionType::City->value)
            ->where('code', '0101010001')
            ->first();

        $this->assertEqualsWithDelta(35.6892, (float) $city->lat, 0.0001);
        $this->assertEqualsWithDelta(51.389, (float) $city->lon, 0.0001);
    }
}
