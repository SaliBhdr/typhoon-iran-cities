<?php
/**
 * Created by PhpStorm.
 * User: s.bahador
 * Date: 2/12/2020
 * Time: 11:36 AM
 */
namespace SaliBhdr\TyphoonIranCities;

use Illuminate\Support\ServiceProvider;
use SaliBhdr\TyphoonIranCities\Commands\ImportIran;
use SaliBhdr\TyphoonIranCities\Commands\ImportCities;
use SaliBhdr\TyphoonIranCities\Commands\ImportCityDistricts;
use SaliBhdr\TyphoonIranCities\Commands\ImportCounties;
use SaliBhdr\TyphoonIranCities\Commands\ImportProvinces;
use SaliBhdr\TyphoonIranCities\Commands\ImportRuralDistricts;
use SaliBhdr\TyphoonIranCities\Commands\ImportSectors;
use SaliBhdr\TyphoonIranCities\Commands\ImportVillages;

class IranCitiesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
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
        if ($this->app->version() >= 8) {
            $targetModelsPath = app_path('Models');
        } else {
            $targetModelsPath = app_path();
        }

        $this->publishes([
            __DIR__ . '/Models/' => $targetModelsPath
        ], 'models');
    }

    private function publishMigrations()
    {
        $this->publishes([
            __DIR__ . '/../migrations/' => database_path('migrations')
        ], 'migrations');
    }

}
