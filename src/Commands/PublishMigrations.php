<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use SaliBhdr\TyphoonIranCities\Commands\Traits\PublishesIranCities;
use SaliBhdr\TyphoonIranCities\Enums\MigrationStub;
use SaliBhdr\TyphoonIranCities\Support\PackagePath;

#[Signature('iran:publish:migrations' . PublishMigrations::SIGNATURE_OPTIONS)]
#[Description('Copies migrations into migrations directory')]
class PublishMigrations extends Command
{
    use PublishesIranCities;

    /**
     * @param list<MigrationStub> $targets
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getTargets($targets)
    {
        $stubsDir = $this->getStubsDir();

        $timestamp = time();

        $map = [
            MigrationStub::Provinces->value => [$stubsDir . '1_create_iran_provinces_table.stub' => $this->getMigrationFileName('create_iran_provinces_table.php', $timestamp)],
            MigrationStub::Counties->value => [$stubsDir . '2_create_iran_counties_table.stub' => $this->getMigrationFileName('create_iran_counties_table.php', ++$timestamp)],
            MigrationStub::Sectors->value => [$stubsDir . '3_create_iran_sectors_table.stub' => $this->getMigrationFileName('create_iran_sectors_table.php', ++$timestamp)],
            MigrationStub::Cities->value => [$stubsDir . '4_create_iran_cities_table.stub' => $this->getMigrationFileName('create_iran_cities_table.php', ++$timestamp)],
            MigrationStub::CityDistricts->value => [$stubsDir . '5_create_iran_city_districts_table.stub' => $this->getMigrationFileName('create_iran_city_districts_table.php', ++$timestamp)],
            MigrationStub::RuralDistricts->value => [$stubsDir . '6_create_iran_rural_districts_table.stub' => $this->getMigrationFileName('create_iran_rural_districts_table.php', ++$timestamp)],
            MigrationStub::Villages->value => [$stubsDir . '7_create_iran_villages_table.stub' => $this->getMigrationFileName('create_iran_villages_table.php', ++$timestamp)],
            MigrationStub::Regions->value => [$stubsDir . '8_create_iran_regions_table.stub' => $this->getMigrationFileName('create_iran_regions_table.php', ++$timestamp)],
            MigrationStub::CoordinatesCities->value => [$stubsDir . '9_add_coordinates_to_iran_cities_table.stub' => $this->getMigrationFileName('add_coordinates_to_iran_cities_table.php', ++$timestamp)],
            MigrationStub::CoordinatesRegions->value => [$stubsDir . '10_add_coordinates_to_iran_regions_table.stub' => $this->getMigrationFileName('add_coordinates_to_iran_regions_table.php', ++$timestamp)],
        ];

        $result = [];

        foreach ($targets as $target) {
            $key = $target instanceof MigrationStub ? $target->value : $target;

            if (isset($map[$key])) {
                $result = array_merge($result, $map[$key]);
            }
        }

        return $result;
    }

    /**
     * Get migration stubs directory.
     *
     * @return string
     */
    protected function getStubsDir()
    {
        return PackagePath::stubs('migrations') . DIRECTORY_SEPARATOR;
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param string $fileName
     * @param null $timestamp
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getMigrationFileName($fileName, $timestamp = null)
    {
        if (empty($timestamp))
            $timestamp = time();

        $filesystem = $this->laravel->make(Filesystem::class);

        $targetDirPath = database_path() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR;

        return Collection::make($targetDirPath)
            ->flatMap(function ($path) use ($filesystem, $fileName) {
                return $filesystem->glob($path . '*_' . $fileName);
            })
            ->push($targetDirPath . date('Y_m_d_His', $timestamp) . "_{$fileName}")
            ->first();
    }

    /**
     * @param string $src
     * @param string $destination
     * @return void
     */
    protected function copyFile($src, $destination)
    {
        file_put_contents($destination, file_get_contents($src));
    }
}
