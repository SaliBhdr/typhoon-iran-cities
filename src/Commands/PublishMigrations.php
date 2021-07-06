<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;

class PublishMigrations extends Command
{
    protected $name = 'iran:publish:migrations';

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        $src = __DIR__ . '/../../migrations/';

        $timestamp = time();

        $map = [
            $src . '1_create_iran_provinces_table.stub'       => $this->getMigrationFileName('create_iran_provinces_table.php', $timestamp),
            $src . '2_create_iran_counties_table.stub'        => $this->getMigrationFileName('create_iran_counties_table.php', $timestamp + 1),
            $src . '3_create_iran_sectors_table.stub'         => $this->getMigrationFileName('create_iran_sectors_table.php', $timestamp + 2),
            $src . '4_create_iran_cities_table.stub'          => $this->getMigrationFileName('create_iran_cities_table.php', $timestamp + 3),
            $src . '5_create_iran_city_districts_table.stub'  => $this->getMigrationFileName('create_iran_city_districts_table.php', $timestamp + 4),
            $src . '6_create_iran_rural_districts_table.stub' => $this->getMigrationFileName('create_iran_rural_districts_table.php', $timestamp + 5),
            $src . '7_create_iran_villages_table.stub'        => $this->getMigrationFileName('create_iran_villages_table.php', $timestamp + 6),
        ];

        foreach ($map as $stub => $target) {
            file_put_contents($target, file_get_contents($stub));
        }
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
}
