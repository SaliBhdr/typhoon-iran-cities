<?php
/**
 * Created by PhpStorm.
 * User: s.bahador
 * Date: 2/12/2020
 * Time: 11:36 AM
 */
namespace SaliBhdr\TyphoonIranCities;

use Illuminate\Support\ServiceProvider;
use SaliBhdr\TyphoonIranCities\Commands\InsertCities;

class IranCitiesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/Models/' => app_path()
        ], 'models');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands([
            InsertCities::class,
        ]);
    }

}