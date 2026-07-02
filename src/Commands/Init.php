<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use SaliBhdr\TyphoonIranCities\Commands\Traits\AsksBoolQuestions;

#[Signature('iran:init
    {--force : Force to overwrite copied files}
    {--unite : Unite will put all regions into one region table and will not separate regional tables}
    {--target=all : Target region that you desire to have, options : [all, provinces, counties, sectors, cities, city_districts, rural_districts, villages]}
    {--with-city-coordinates : Publish city coordinates migration and import lat/lon when cities are included in the target}')]
#[Description('Copies models and migrations then imports data')]
class Init extends Command
{
    use AsksBoolQuestions;

    public function handle()
    {
        if ($this->askBoolQuestion('Do you want to publish package migrations?')) {
            $this->call('iran:publish:migrations', [
                '--force'            => $this->option('force'),
                '--unite'            => $this->option('unite'),
                '--target'           => $this->option('target'),
                '--with-city-coordinates' => $this->option('with-city-coordinates'),
            ]);
        }

        if ($this->askBoolQuestion('Do you want to publish package models?')) {
            $this->call('iran:publish:models', [
                '--force'  => $this->option('force'),
                '--unite'  => $this->option('unite'),
                '--target' => $this->option('target'),
            ]);
        }

        if ($this->askBoolQuestion('Do you want to run `php artisan migrate` to migrate package migrations?'))
            $this->call('migrate');

        if ($this->askBoolQuestion('Do you want to import data?')) {
            $this->call('iran:import', [
                '--unite'            => $this->option('unite'),
                '--target'           => $this->option('target'),
                '--with-city-coordinates' => $this->option('with-city-coordinates'),
            ]);
        }
    }
}
