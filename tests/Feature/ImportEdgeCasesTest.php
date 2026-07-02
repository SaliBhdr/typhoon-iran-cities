<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use Illuminate\Support\Facades\File;
use ReflectionMethod;
use SaliBhdr\TyphoonIranCities\Commands\Import;
use SaliBhdr\TyphoonIranCities\Commands\PublishMigrations;
use SaliBhdr\TyphoonIranCities\Tests\Concerns\UsesFixtureCsv;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class ImportEdgeCasesTest extends TestCase
{
    use UsesFixtureCsv;

    private string $tempCsvPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tempCsvPath = sys_get_temp_dir() . '/iran-csv-' . uniqid('', true);
        File::makeDirectory($this->tempCsvPath);

        $this->app->resolving(Import::class, function (Import $command) {
            $command->useCsvFrom($this->tempCsvPath);
        });
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->tempCsvPath);

        parent::tearDown();
    }

    public function test_unite_import_skips_rows_filtered_by_target(): void
    {
        File::put($this->tempCsvPath . '/regions.csv', implode("\n", [
            '"id","type","parent_id","province_id","county_id","sector_id","city_id","rural_district_id","name","code","short_code"',
            '"3","county","1","1",,,,,"County One","0101","01"',
        ]));

        $this->migrateUniteTables();

        $this->artisan('iran:import', [
            '--unite'  => true,
            '--target' => 'provinces',
        ])->assertSuccessful();

        $this->assertDatabaseCount('iran_regions', 0);
    }

    public function test_import_skips_empty_coordinates_file(): void
    {
        $this->copyFixture('provinces.csv');
        $this->copyFixture('counties.csv');
        $this->copyFixture('sectors.csv');
        $this->copyFixture('cities.csv');
        File::put($this->tempCsvPath . '/city_coordinates.csv', '"city_id","lat","lon"');

        $this->migrateSeparateTablesUpToCities();
        $this->runMigrationStub('9_add_coordinates_to_iran_cities_table.stub');

        $this->artisan('iran:import', [
            '--target'                => 'cities',
            '--with-city-coordinates'   => true,
        ])->assertSuccessful();
    }

    public function test_unite_import_skips_unknown_coordinate_city_ids(): void
    {
        $this->copyFixture('regions.csv');
        $this->copyFixture('cities.csv');
        File::put($this->tempCsvPath . '/city_coordinates.csv', implode("\n", [
            '"city_id","lat","lon"',
            '"999","35.6892","51.3890"',
        ]));

        $this->migrateUniteTables();
        $this->runMigrationStub('10_add_coordinates_to_iran_regions_table.stub');

        $this->artisan('iran:import', [
            '--unite'                   => true,
            '--target'                  => 'cities',
            '--with-city-coordinates'   => true,
        ])->assertSuccessful();

        $this->assertNull(
            \Illuminate\Support\Facades\DB::table('iran_regions')
                ->where('type', 'city')
                ->value('lat')
        );
    }

    public function test_csv_to_array_throws_when_file_is_missing(): void
    {
        $command = app(Import::class);
        $command->useCsvFrom($this->tempCsvPath);

        $method = new ReflectionMethod(Import::class, 'csvToArray');
        $method->setAccessible(true);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('not exists');

        $method->invoke($command, $this->tempCsvPath . '/missing.csv');
    }

    public function test_csv_to_array_returns_empty_array_for_header_only_file(): void
    {
        File::put($this->tempCsvPath . '/empty.csv', '"id","name"');

        $command = app(Import::class);
        $command->useCsvFrom($this->tempCsvPath);

        $method = new ReflectionMethod(Import::class, 'csvToArray');
        $method->setAccessible(true);

        $this->assertSame([], $method->invoke($command, $this->tempCsvPath . '/empty.csv'));
    }

    public function test_csv_to_array_returns_empty_array_for_completely_empty_file(): void
    {
        File::put($this->tempCsvPath . '/blank.csv', '');

        $command = app(Import::class);
        $command->useCsvFrom($this->tempCsvPath);

        $method = new ReflectionMethod(Import::class, 'csvToArray');
        $method->setAccessible(true);

        $this->assertSame([], $method->invoke($command, $this->tempCsvPath . '/blank.csv'));
    }

    public function test_csv_to_array_throws_when_file_cannot_be_opened(): void
    {
        $blockedPath = $this->tempCsvPath . '/unreadable.csv';
        File::put($blockedPath, '"id","name"');
        chmod($blockedPath, 0000);

        $command = app(Import::class);
        $command->useCsvFrom($this->tempCsvPath);

        $method = new ReflectionMethod(Import::class, 'csvToArray');
        $method->setAccessible(true);

        try {
            $this->expectException(\Exception::class);
            $this->expectExceptionMessage('Unable to open file');

            $method->invoke($command, $blockedPath);
        } finally {
            chmod($blockedPath, 0644);
        }
    }

    public function test_get_files_uses_current_target_when_empty_list_is_passed(): void
    {
        $command = $this->app->make(Import::class);
        $command->setLaravel($this->app);

        $input = new \Symfony\Component\Console\Input\ArrayInput(
            ['--target' => 'cities'],
            $command->getDefinition()
        );
        $command->setInput($input);

        $method = new ReflectionMethod(Import::class, 'getFiles');
        $method->setAccessible(true);

        $this->assertSame(
            ['province', 'county', 'sector', 'city'],
            $method->invoke($command, [])
        );
    }

    public function test_get_migration_file_name_uses_current_timestamp_when_empty(): void
    {
        File::ensureDirectoryExists(database_path('migrations'));

        $command = $this->app->make(PublishMigrations::class);
        $command->setLaravel($this->app);

        $method = new ReflectionMethod(PublishMigrations::class, 'getMigrationFileName');
        $method->setAccessible(true);

        $path = $method->invoke($command, 'create_iran_provinces_table.php', null);

        $this->assertStringContainsString('create_iran_provinces_table.php', $path);
    }

    private function copyFixture(string $fileName): void
    {
        File::copy($this->fixturesPath() . '/' . $fileName, $this->tempCsvPath . '/' . $fileName);
    }
}
