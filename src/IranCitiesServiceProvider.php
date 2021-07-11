<?php

namespace SaliBhdr\TyphoonIranCities;

use Illuminate\Support\ServiceProvider;
use SaliBhdr\TyphoonIranCities\Commands\ImportIran;
use SaliBhdr\TyphoonIranCities\Commands\ImportCities;
use SaliBhdr\TyphoonIranCities\Commands\ImportSectors;
use SaliBhdr\TyphoonIranCities\Commands\IranInit;
use SaliBhdr\TyphoonIranCities\Commands\PublishModels;
use SaliBhdr\TyphoonIranCities\Commands\ImportVillages;
use SaliBhdr\TyphoonIranCities\Commands\ImportCounties;
use SaliBhdr\TyphoonIranCities\Commands\ImportProvinces;
use SaliBhdr\TyphoonIranCities\Commands\PublishMigrations;
use SaliBhdr\TyphoonIranCities\Commands\ImportCityDistricts;
use SaliBhdr\TyphoonIranCities\Commands\ImportRuralDistricts;

class IranCitiesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands([
            IranInit::class,
            PublishMigrations::class,
            PublishModels::class,
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
}
