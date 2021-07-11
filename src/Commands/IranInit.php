<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\BufferedConsoleOutput;
use Symfony\Component\Console\Input\InputOption;

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
        $buffer = new BufferedConsoleOutput();

        if ($this->askBoolQuestion('Do you want to publish package migrations?')) {
            Artisan::call('iran:publish:migrations', [
                '--force'  => $this->option('force'),
                '--region' => $this->option('region'),
            ], $buffer);
        }

        if ($this->askBoolQuestion('Do you want to publish package models?')) {
            Artisan::call('iran:publish:models', [
                '--force'  => $this->option('force'),
                '--region' => $this->option('region'),
            ], $buffer);
        }

        if ($this->askBoolQuestion('Do you want to run `php artisan migrate` to migrate package migrations?')) {
            Artisan::call('migrate', [], $buffer);

            if ($this->askBoolQuestion('Do you want to import data?')) {
                Artisan::call('iran:import', [
                    '--force'  => $this->option('force'),
                    '--region' => $this->option('region'),
                ], $buffer);
            }
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
}
