<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use SaliBhdr\TyphoonIranCities\Enums\TargetTypeEnum;
use Symfony\Component\Console\Input\InputOption;
use SaliBhdr\TyphoonIranCities\Commands\Abstracts\AbstractCommand;

class Import extends AbstractCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports all regions into the database (Can be selected by option)';

    /**
     * @var array
     */
    protected $map = [
        'all'             => TargetTypeEnum::ALL,
        'provinces'       => TargetTypeEnum::PROVINCES,
        'counties'        => TargetTypeEnum::COUNTIES,
        'sectors'         => TargetTypeEnum::SECTORS,
        'cities'          => TargetTypeEnum::CITIES,
        'city_districts'  => TargetTypeEnum::CITY_DISTRICTS,
        'rural_districts' => TargetTypeEnum::RURAL_DISTRICTS,
        'villages'        => TargetTypeEnum::VILLAGES
    ];

    public function __construct()
    {
        parent::__construct();

        $this->getDefinition()->addOptions([
            new InputOption('unite', null, InputOption::VALUE_NONE, 'Unite will put all regions into one region table and will not separate regional tables'),
            new InputOption('target', null, InputOption::VALUE_OPTIONAL, 'Target region that you want to import, options : [all, provinces, counties, sectors, cities, city_districts, rural_districts, villages]', 'all')
        ]);
    }

    /**
     * Execute the console command.
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $this->removePhpLimits();

        $this->info('Starting to import data...');

        $targets = $this->getTarget();

        $files = $this->getFiles($targets);

        foreach ($files as $fileName) {

            $startTime = microtime(true);

            $fileName = Str::plural($fileName);

            $rows = $this->csvToArray(__DIR__ . '/../../csv/' . $fileName . '.csv', function ($key, $data) use ($targets) {
                if ($this->option('unite') && !in_array($data['type'], $targets))
                    return false;

                return true;
            });

            if (empty($rows))
                continue;

            $targetName = str_replace('.csv', '', $fileName);

            $dbName = 'iran_' . $targetName;

            $chunkLength = 4000;

            $chunks = array_chunk($rows, $chunkLength);

            $chunksCount = count($chunks);

            $this->info("\nImporting " . str_replace("_", " ", $targetName) . "...");
            $this->line("{$chunksCount} data chunks with maximum {$chunkLength} row per chunk");

            $task = $this->output->createProgressBar($chunksCount);

            $task->start();

            foreach ($chunks as $chunk) {

                DB::table($dbName)->insertOrIgnore($chunk);

                $task->advance();
            }

            $task->finish();

            $runTime = number_format((microtime(true) - $startTime) * 1000, 2);

            $this->line("   {$runTime}ms");
        }

        $this->line('');
        $this->info('Data has been imported successfully!!!');
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getFiles($targets = [])
    {
        if (empty($targets))
            $targets = $this->getTarget();

        if ($this->option('unite'))
            return TargetTypeEnum::REGIONS;

        return $targets;
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getTarget()
    {
        $target = $this->option('target');

        if (isset($this->map[$target]))
            return $this->map[$target];

        throw new \Exception("Target Region ({$target}) Not Found", 404);
    }


    /**
     * prevents php throw error for importing very large data sets to database based on limits
     */
    protected function removePhpLimits()
    {
        @set_time_limit(0);
        @ini_set("memory_limit", "-1");
        @ini_set("max_execution_time", '-1');
        @ini_set('max_input_vars', '5000');
    }

    /**
     * @param $path
     * @param Closure|null $accept filters if data is accepted or not
     * @return array|null
     * @throws \Exception
     */
    protected function csvToArray($path, ?Closure $accept = null)
    {
        if (!$path || !file_exists($path))
            throw new \Exception('File ' . $path . ' not exists');

        $csv = array_map('str_getcsv', file($path));

        $arrFinal = [];
        array_walk($csv, function ($data, $key) use ($csv, &$arrFinal, $accept) {

            $data = array_map(function ($a) {
                return $a === "" ? null : $a;
            }, $data);

            $data = array_combine($csv[0], $data);

            if ($key != 0) {
                $data = array_combine($csv[0], $data);

                $isAccepted = true;

                if (!is_null($accept))
                    $isAccepted = $accept($key, $data);

                if (!empty($isAccepted))
                    $arrFinal[$key] = $data;
            }

        });

        return $arrFinal;
    }
}
