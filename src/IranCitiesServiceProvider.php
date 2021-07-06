<?php

namespace SaliBhdr\TyphoonIranCities;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use SaliBhdr\TyphoonIranCities\Commands\ImportIran;
use SaliBhdr\TyphoonIranCities\Commands\ImportCities;
use SaliBhdr\TyphoonIranCities\Commands\ImportSectors;
use SaliBhdr\TyphoonIranCities\Commands\ImportVillages;
use SaliBhdr\TyphoonIranCities\Commands\ImportCounties;
use SaliBhdr\TyphoonIranCities\Commands\ImportProvinces;
use SaliBhdr\TyphoonIranCities\Commands\ImportCityDistricts;
use SaliBhdr\TyphoonIranCities\Commands\ImportRuralDistricts;

class IranCitiesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->publishMigrations();

        $this->publishModels();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands([
            ImportIran::class,
            ImportProvinces::class,
            ImportCounties::class,
            ImportSectors::class,
            ImportCities::class,
            ImportCityDistricts::class,
            ImportRuralDistricts::class,
            ImportVillages::class,
        ]);
    }

    private function publishModels()
    {
        $this->publishes([
            __DIR__ . '/Models/' => $this->app->version() >= 8 ? app_path('Models') : app_path()
        ]);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function publishMigrations()
    {
        $src = __DIR__ . '/../migrations/';

        $timestamp = time();

        $this->publishes([
            $src . '1_create_iran_provinces_table.php'       => $this->getMigrationFileName('create_iran_provinces_table.php', $timestamp),
            $src . '2_create_iran_counties_table.php'        => $this->getMigrationFileName('create_iran_counties_table.php', $timestamp + 1),
            $src . '3_create_iran_sectors_table.php'         => $this->getMigrationFileName('create_iran_sectors_table.php', $timestamp + 2),
            $src . '4_create_iran_cities_table.php'          => $this->getMigrationFileName('create_iran_cities_table.php', $timestamp + 3),
            $src . '5_create_iran_city_districts_table.php'  => $this->getMigrationFileName('create_iran_city_districts_table.php', $timestamp + 4),
            $src . '6_create_iran_rural_districts_table.php' => $this->getMigrationFileName('create_iran_rural_districts_table.php', $timestamp + 5),
            $src . '7_create_iran_villages_table.php'        => $this->getMigrationFileName('create_iran_villages_table.php', $timestamp + 6),
        ]);
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

        $filesystem = $this->app->make(Filesystem::class);

        $targetDirPath = $this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR;

        return Collection::make($targetDirPath)
            ->flatMap(function ($path) use ($filesystem, $fileName) {
                return $filesystem->glob($path . '*_' . $fileName);
            })
            ->push($targetDirPath . date('Y_m_d_His', $timestamp) . "_{$fileName}")
            ->first();
    }
}
