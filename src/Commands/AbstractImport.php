<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractImport extends Command
{
    /**
     * AbstractImportCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->getDefinition()->addOptions([
            new InputOption('force', null, InputOption::VALUE_NONE, 'Force to insert data and overwrite existed data')
        ]);
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->removePhpLimits();

        $this->info('Starting to import data...');

        $files = $this->getFiles();

        foreach ($files as $fileName) {
            $rows = $this->csvToArray($fileName);

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
     * @param string $file
     * @return array|null
     */
    protected function csvToArray($file)
    {
        $filePath = __DIR__ . '/../../csv/' . $file;

        if (!file_exists($filePath))
            return null;

        $csv = array_map('str_getcsv', file($filePath));

        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });

        array_shift($csv);

        return $csv;
    }

    /**
     * @param string $dbName
     * @param array $data
     */
    private function insertToDb($dbName, $data)
    {

        if (!$this->option('force') && DB::table($dbName)->where('id', $data['id'])->exists())
            return;

        $data = array_map(function ($value) {
            return $value === "" ? null : $value;
        }, $data);

        DB::table($dbName)->updateOrInsert(['id' => $data['id']], $data);
    }

    /**
     * prevents php throw error for importing very large data sets to database based on limits
     */
    private function removePhpLimits()
    {
        @set_time_limit(0);
        @ini_set("memory_limit", "-1");
        @ini_set("max_execution_time", '-1');
        @ini_set('max_input_vars', '5000');
    }

}