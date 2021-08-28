<?php

namespace SaliBhdr\TyphoonIranCities\Commands\Abstracts;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractImport extends AbstractCommand
{

    public function __construct()
    {
        parent::__construct();

        $this->getDefinition()->addOptions([
            new InputOption('force', null, InputOption::VALUE_NONE, 'Force to insert data and overwrite existed data'),
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

        $files = $this->getFiles();

        foreach ($files as $fileName) {

            $fileName = Str::plural($fileName);

            $rows = $this->csvToArray(__DIR__ . '/../../../csv/' . $fileName . '.csv');

            if (empty($rows))
                continue;

            $targetName = str_replace('.csv', '', $fileName);

            $dbName = 'iran_' . $targetName;

            $this->info("\nImporting " . str_replace("_", " ", $targetName) . "...");

            $task = $this->output->createProgressBar(count($rows));

            $task->start();

            foreach ($rows as $rowData) {

                $this->insertToDb($dbName, $rowData);

                $task->advance();
            }

            $task->finish();
        }

        $this->line('');
        $this->info('Data has been imported successfully!!!');
    }

    /**
     * @return array
     */
    abstract protected function getFiles();

    /**
     * @return boolean
     */
    abstract protected function canImport($data);

    /**
     * @param string $dbName
     * @param array $data
     */
    protected function insertToDb($dbName, $data)
    {
        if (!$this->option('force') && DB::table($dbName)->where('id', $data['id'])->exists())
            return;

        $data = array_map(function ($value) {
            return $value === "" ? null : $value;
        }, $data);


        if ($this->canImport($data))
            DB::table($dbName)->updateOrInsert(['id' => $data['id']], $data);
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
     * @return array|null
     * @throws \Exception
     */
    protected function csvToArray($path)
    {
        if (!$path || !file_exists($path))
            throw new \Exception('File ' . $path . ' not exists');

        $csv = array_map('str_getcsv', file($path));

        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });

        array_shift($csv);

        return $csv;
    }

}
