<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\BufferedConsoleOutput as ConsoleBuffer;

class IranInit extends Command
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
            new InputOption('region', null, InputOption::VALUE_OPTIONAL, 'Target region that you want to copy files, options : [provinces, counties, sectors, cities, city_districts, rural_districts, villages]', 'all')
        ]);
    }

    public function handle()
    {
        if ($this->askBoolQuestion('Do you want to publish package migrations?')) {
            $this->artisanCall('iran:publish:migrations', [
                '--force'  => $this->option('force'),
                '--region' => $this->option('region'),
            ]);
        }

        if ($this->askBoolQuestion('Do you want to publish package models?')) {
            $this->artisanCall('iran:publish:models', [
                '--force'  => $this->option('force'),
                '--region' => $this->option('region'),
            ]);
        }

        if (!$this->askBoolQuestion('Do you want to run `php artisan migrate` to migrate package migrations?'))
            return;

        $this->artisanCall('migrate');

        if ($this->askBoolQuestion('Do you want to import data?')) {
            $this->artisanCall('iran:import', [
                '--force'  => $this->option('force'),
                '--region' => $this->option('region'),
            ]);
        }
    }

    /**
     * @param string $question
     * @return bool
     */
    private function askBoolQuestion($question)
    {
        $answer = strtolower($this->ask("$question (y/n)", 'y'));

        $answerMap = [
            'y'   => true,
            'yes' => true,
            'n'   => false,
            'no'  => false,
        ];

        if (isset($answerMap[$answer]))
            return $answerMap[$answer];

        $this->error('Unknown Answer');

        return $this->askBoolQuestion($question);
    }

    private function artisanCall($command, array $parameters = [])
    {
        $laravelVersion = $this->laravel->version();

        if ($laravelVersion < 5.6) {
            Artisan::call($command, $parameters);
        } else {
            Artisan::call($command, $parameters, new ConsoleBuffer);
        }
    }
}
