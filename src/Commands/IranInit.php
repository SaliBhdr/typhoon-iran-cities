<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Symfony\Component\Console\Input\InputOption;
use SaliBhdr\TyphoonIranCities\Commands\Abstracts\AbstractCommand;

class IranInit extends AbstractCommand
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
            new InputOption('force', null, InputOption::VALUE_NONE, 'Force to copy and overwrite files'),
            new InputOption('mode', null, InputOption::VALUE_OPTIONAL, 'Target region that you want to copy files, options : [separate, unite]', 'separate'),
            new InputOption('target', null, InputOption::VALUE_OPTIONAL, 'Target region that you want to copy files, options : [all, provinces, counties, sectors, cities, city_districts, rural_districts, villages]', 'all')
        ]);
    }

    public function handle()
    {
        if ($this->askBoolQuestion('Do you want to publish package migrations?')) {
            $this->call('iran:publish:migrations', [
                '--force'  => $this->option('force'),
                '--mode'   => $this->option('mode'),
                '--target' => $this->option('target'),
            ]);
        }

        if ($this->askBoolQuestion('Do you want to publish package models?')) {
            $this->call('iran:publish:models', [
                '--force'  => $this->option('force'),
                '--mode'   => $this->option('mode'),
                '--target' => $this->option('target'),
            ]);
        }

        if (!$this->askBoolQuestion('Do you want to run `php artisan migrate` to migrate package migrations?'))
            return;

        $this->call('migrate');

        if ($this->askBoolQuestion('Do you want to import data?')) {
            $this->call('iran:import', [
                '--force'  => $this->option('force'),
                '--mode'   => $this->option('mode'),
                '--target' => $this->option('target'),
            ]);
        }
    }

}
