<?php
/**
 * Created by PhpStorm.
 * User: s.bahador
 * Date: 2/12/2020
 * Time: 11:36 AM
 */
namespace SaliBhdr\TyphoonIranCities;

use Illuminate\Support\ServiceProvider;
use SaliBhdr\TyphoonIranCities\Commands\ImportCities;
use SaliBhdr\TyphoonIranCities\Commands\ImportCounties;
use SaliBhdr\TyphoonIranCities\Commands\ImportProvinces;

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
            ImportProvinces::class,
            ImportCounties::class,
            ImportCities::class,
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
