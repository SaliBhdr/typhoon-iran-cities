<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use SaliBhdr\TyphoonIranCities\Commands\Abstracts\AbstractPublish;

class PublishMigrations extends AbstractPublish
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $name = 'iran:publish:migrations';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Copies migrations into migrations directory';

    /**
     * @param array[int] $targets
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getTargets($targets)
    {
        $src = $this->getSrcDir();

        $timestamp = time();

        $map = [
            1 => [$src . '1_create_iran_provinces_table.stub'       => $this->getMigrationFileName('create_iran_provinces_table.php', $timestamp)],
            2 => [$src . '2_create_iran_counties_table.stub'        => $this->getMigrationFileName('create_iran_counties_table.php', ++$timestamp)],
            3 => [$src . '3_create_iran_sectors_table.stub'         => $this->getMigrationFileName('create_iran_sectors_table.php', ++$timestamp)],
            4 => [$src . '4_create_iran_cities_table.stub'          => $this->getMigrationFileName('create_iran_cities_table.php', ++$timestamp)],
            5 => [$src . '5_create_iran_city_districts_table.stub'  => $this->getMigrationFileName('create_iran_city_districts_table.php', ++$timestamp)],
            6 => [$src . '6_create_iran_rural_districts_table.stub' => $this->getMigrationFileName('create_iran_rural_districts_table.php', ++$timestamp)],
            7 => [$src . '7_create_iran_villages_table.stub'        => $this->getMigrationFileName('create_iran_villages_table.php', ++$timestamp)],
            8 => [$src . '8_create_iran_regions_table.stub'         => $this->getMigrationFileName('create_iran_regions_table.php', ++$timestamp)],
        ];

        $result = [];

        foreach ($targets as $target) {
            if (isset($map[$target]))
                $result = array_merge($result, $map[$target]);
        }

        return $result;
    }

    /**
     * Get models src dir
     *
     * @return string
     */
    protected function getSrcDir()
    {
        return realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'migrations') . DIRECTORY_SEPARATOR;
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
