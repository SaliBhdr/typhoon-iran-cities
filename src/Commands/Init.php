<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Symfony\Component\Console\Input\InputOption;
use SaliBhdr\TyphoonIranCities\Commands\Abstracts\AbstractCommand;

class Init extends AbstractCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $name = 'iran:init';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Copies models and migrations then imports data';

    public function __construct()
    {
        parent::__construct();

        $this->getDefinition()->addOptions([
            new InputOption('force', null, InputOption::VALUE_NONE, 'Force to overwrite copied files'),
            new InputOption('unite', null, InputOption::VALUE_NONE, 'Unite will put all regions into one region table and will not separate regional tables'),
            new InputOption('target', null, InputOption::VALUE_OPTIONAL, 'Target region that you desire to have, options : [all, provinces, counties, sectors, cities, city_districts, rural_districts, villages]', 'all')
        ]);
    }

    public function handle()
    {
        if ($this->askBoolQuestion('Do you want to publish package migrations?')) {
            $this->call('iran:publish:migrations', [
                '--force'  => $this->option('force'),
                '--unite'  => $this->option('unite'),
                '--target' => $this->option('target'),
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
                '--unite'  => $this->option('unite'),
                '--target' => $this->option('target'),
            ]);
        }
    }

}
