<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use Illuminate\Support\Facades\File;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class PublishMigrationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        File::ensureDirectoryExists(database_path('migrations'));
    }

    public function test_it_publishes_province_migration_for_provinces_target(): void
    {
        $this->artisan('iran:publish:migrations', [
            '--target' => 'provinces',
            '--force'  => true,
        ])->assertSuccessful();

        $files = File::glob(database_path('migrations/*create_iran_provinces_table.php'));

        $this->assertCount(1, $files);
        $this->assertStringNotContainsString('TargetTypeEnum', File::get($files[0]));
    }

    public function test_it_publishes_city_migrations_with_coordinates_option(): void
    {
        $this->artisan('iran:publish:migrations', [
            '--target'                 => 'cities',
            '--with-city-coordinates'  => true,
            '--force'                  => true,
        ])->assertSuccessful();

        $this->assertNotEmpty(File::glob(database_path('migrations/*create_iran_provinces_table.php')));
        $this->assertNotEmpty(File::glob(database_path('migrations/*create_iran_cities_table.php')));
        $this->assertNotEmpty(File::glob(database_path('migrations/*add_coordinates_to_iran_cities_table.php')));
    }

    public function test_it_publishes_unite_migration_with_coordinates(): void
    {
        $this->artisan('iran:publish:migrations', [
            '--unite'                   => true,
            '--target'                  => 'cities',
            '--with-city-coordinates'   => true,
            '--force'                   => true,
        ])->assertSuccessful();

        $regionsMigration = File::glob(database_path('migrations/*create_iran_regions_table.php'));

        $this->assertCount(1, $regionsMigration);
        $this->assertStringNotContainsString('SaliBhdr\\TyphoonIranCities', File::get($regionsMigration[0]));
        $this->assertNotEmpty(File::glob(database_path('migrations/*add_coordinates_to_iran_regions_table.php')));
    }
}
