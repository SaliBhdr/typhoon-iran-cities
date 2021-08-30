<?php

namespace SaliBhdr\TyphoonIranCities;

use Illuminate\Support\ServiceProvider;
use SaliBhdr\TyphoonIranCities\Commands\Init;
use SaliBhdr\TyphoonIranCities\Commands\Import;
use SaliBhdr\TyphoonIranCities\Commands\PublishModels;
use SaliBhdr\TyphoonIranCities\Commands\PublishMigrations;

class IranCitiesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands([
            Init::class,
            PublishMigrations::class,
            PublishModels::class,
            Import::class,
        ]);
    }
}
