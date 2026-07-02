<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Closure;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;
use SaliBhdr\TyphoonIranCities\Enums\RegionType;
use SaliBhdr\TyphoonIranCities\Support\ImportTargetMap;
use SaliBhdr\TyphoonIranCities\Support\PackagePath;

#[Signature('iran:import
    {--unite : Unite will put all regions into one region table and will not separate regional tables}
    {--target=all : Target region that you want to import, options : [all, provinces, counties, sectors, cities, city_districts, rural_districts, villages]}
    {--with-city-coordinates : Import city coordinates (lat/lon) when cities are included in the target}
    {--fresh : Truncate target tables before importing}')]
#[Description('Imports all regions into the database (Can be selected by option)')]
class Import extends Command
{
    protected ?string $csvBasePath = null;

    /**
     * Tables in reverse FK dependency order for truncation.
     *
     * @var list<string>
     */
    protected const TABLE_TRUNCATE_ORDER = [
        'iran_villages',
        'iran_city_districts',
        'iran_cities',
        'iran_rural_districts',
        'iran_sectors',
        'iran_counties',
        'iran_provinces',
        'iran_regions',
    ];

    /**
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $this->removePhpLimits();

        $this->info('Starting to import data...');

        $targets = $this->getTarget();

        $files = $this->getFiles($targets);

        $tables = $this->resolveTables($files);

        $this->assertTablesExist($tables);

        if ($this->option('fresh')) {
            $this->truncateTables($tables);
        }

        foreach ($files as $fileName) {

            $startTime = microtime(true);

            $fileName = Str::plural($fileName);

            $rows = $this->csvToArray($this->getCsvPath($fileName . '.csv'), function ($key, $data) use ($targets) {
                if ($this->option('unite') && !in_array($data['type'], $targets, true)) {
                    return false;
                }

                return true;
            });

            if (empty($rows)) {
                continue;
            }

            $targetName = str_replace('.csv', '', $fileName);

            $dbName = 'iran_' . $targetName;

            $chunkLength = 4000;

            $chunks = array_chunk($rows, $chunkLength);

            $chunksCount = count($chunks);

            $this->info("\nImporting " . str_replace("_", " ", $targetName) . "...");
            $this->line("{$chunksCount} data chunks with maximum {$chunkLength} row per chunk");

            $task = $this->output->createProgressBar($chunksCount);

            $task->start();

            DB::transaction(function () use ($dbName, $chunks, $task) {
                foreach ($chunks as $chunk) {
                    DB::table($dbName)->insertOrIgnore($chunk);

                    $task->advance();
                }
            });

            $task->finish();

            $runTime = number_format((microtime(true) - $startTime) * 1000, 2);

            $this->line("   {$runTime}ms");
        }

        if ($this->option('with-city-coordinates') && $this->targetsIncludeCities($targets)) {
            $this->importCityCoordinates();
        }

        $this->line('');
        $this->info('Data has been imported successfully!!!');
    }

    /**
     * @param array $targets
     * @return bool
     */
    protected function targetsIncludeCities(array $targets): bool
    {
        return in_array(RegionType::City->value, $targets, true);
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function importCityCoordinates()
    {
        $startTime = microtime(true);

        $rows = $this->csvToArray($this->getCsvPath('city_coordinates.csv'));

        if (empty($rows)) {
            return;
        }

        if ($this->option('unite')) {
            $this->importCityCoordinatesToRegions($rows, $startTime);
        } else {
            $this->importCityCoordinatesToCities($rows, $startTime);
        }
    }

    /**
     * @param array $rows
     * @param float $startTime
     * @return void
     */
    protected function importCityCoordinatesToCities(array $rows, float $startTime)
    {
        $coordinates = array_map(function ($row) {
            return [
                'id'  => $row['city_id'],
                'lat' => $row['lat'],
                'lon' => $row['lon'],
            ];
        }, $rows);

        $this->importCoordinatesInChunks($coordinates, function ($chunk) {
            foreach ($chunk as $row) {
                DB::table('iran_cities')
                    ->where('id', $row['id'])
                    ->update(['lat' => $row['lat'], 'lon' => $row['lon']]);
            }
        }, $startTime);
    }

    /**
     * @param array $rows
     * @param float $startTime
     * @return void
     * @throws \Exception
     */
    protected function importCityCoordinatesToRegions(array $rows, float $startTime)
    {
        $cities = $this->csvToArray($this->getCsvPath('cities.csv'));

        $cityCodes = [];

        foreach ($cities as $city) {
            $cityCodes[$city['id']] = $city['code'];
        }

        $coordinates = [];

        foreach ($rows as $row) {
            if (!isset($cityCodes[$row['city_id']])) {
                continue;
            }

            $coordinates[] = [
                'code' => $cityCodes[$row['city_id']],
                'lat'  => $row['lat'],
                'lon'  => $row['lon'],
            ];
        }

        $this->importCoordinatesInChunks($coordinates, function ($chunk) {
            foreach ($chunk as $row) {
                DB::table('iran_regions')
                    ->where('type', RegionType::City->value)
                    ->where('code', $row['code'])
                    ->update(['lat' => $row['lat'], 'lon' => $row['lon']]);
            }
        }, $startTime);
    }

    /**
     * @param array $coordinates
     * @param Closure $importer
     * @param float $startTime
     * @return void
     */
    protected function importCoordinatesInChunks(array $coordinates, Closure $importer, float $startTime)
    {
        if (empty($coordinates)) {
            return;
        }

        $chunkLength = 4000;

        $chunks = array_chunk($coordinates, $chunkLength);

        $chunksCount = count($chunks);

        $this->info("\nImporting city coordinates...");
        $this->line("{$chunksCount} data chunks with maximum {$chunkLength} row per chunk");

        $task = $this->output->createProgressBar($chunksCount);

        $task->start();

        foreach ($chunks as $chunk) {
            $importer($chunk);

            $task->advance();
        }

        $task->finish();

        $runTime = number_format((microtime(true) - $startTime) * 1000, 2);

        $this->line("   {$runTime}ms");
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getFiles($targets = [])
    {
        if (empty($targets)) {
            $targets = $this->getTarget();
        }

        if ($this->option('unite')) {
            return ImportTargetMap::uniteCsvSources();
        }

        return $targets;
    }

    /**
     * @return list<string>
     * @throws \Exception
     */
    protected function getTarget()
    {
        $target = $this->option('target');

        if (ImportTargetMap::isValid($target)) {
            return ImportTargetMap::regionTypeValues($target);
        }

        throw new \Exception("Target Region ({$target}) Not Found", 404);
    }

    /**
     * @param list<string> $files
     * @return list<string>
     */
    protected function resolveTables(array $files): array
    {
        if ($this->option('unite')) {
            return ['iran_regions'];
        }

        $tables = [];

        foreach ($files as $fileName) {
            $tables[] = 'iran_' . Str::plural($fileName);
        }

        return array_values(array_unique($tables));
    }

    /**
     * @param list<string> $tables
     * @return void
     */
    protected function assertTablesExist(array $tables): void
    {
        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                throw new RuntimeException(
                    "Table {$table} does not exist. Run `php artisan migrate` first."
                );
            }
        }
    }

    /**
     * @param list<string> $tables
     * @return void
     */
    protected function truncateTables(array $tables): void
    {
        Schema::disableForeignKeyConstraints();

        foreach (self::TABLE_TRUNCATE_ORDER as $table) {
            if (!in_array($table, $tables, true) || !Schema::hasTable($table)) {
                continue;
            }

            DB::table($table)->truncate();
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * @return string
     */
    protected function getCsvPath(string $fileName): string
    {
        $base = $this->csvBasePath ?? PackagePath::csv();

        return rtrim($base, '/') . '/' . $fileName;
    }

    /**
     * Override the CSV directory (used in tests).
     */
    public function useCsvFrom(string $path): static
    {
        $this->csvBasePath = $path;

        return $this;
    }

    /**
     * prevents php throw error for importing very large data sets to database based on limits
     */
    protected function removePhpLimits()
    {
        @set_time_limit(0);
        @ini_set('memory_limit', '-1');
        @ini_set('max_execution_time', '-1');
        @ini_set('max_input_vars', '5000');
    }

    /**
     * @param string $path
     * @param Closure|null $accept filters if data is accepted or not
     * @return array<int, array<string, mixed>>
     * @throws \Exception
     */
    protected function csvToArray($path, ?Closure $accept = null)
    {
        if (!$path || !file_exists($path)) {
            throw new \Exception('File ' . $path . ' not exists');
        }

        $handle = @fopen($path, 'r');

        if ($handle === false) {
            throw new \Exception('Unable to open file ' . $path);
        }

        $headers = fgetcsv($handle);

        if ($headers === false) {
            fclose($handle);

            return [];
        }

        $arrFinal = [];
        $key = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $row = array_map(function ($value) {
                return $value === '' ? null : $value;
            }, $row);

            $data = array_combine($headers, $row);

            $isAccepted = is_null($accept) || $accept($key, $data);

            if ($isAccepted) {
                $arrFinal[$key] = $data;
            }

            $key++;
        }

        fclose($handle);

        return $arrFinal;
    }
}
