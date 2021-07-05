<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractImportCommand extends Command
{
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
            $rows = $this->extractCsvArray($fileName);

            if (empty($rows))
                continue;

            $targetName = str_replace('.csv', '', $fileName);

            $dbName = 'iran_' . $targetName;

            $this->info("\nImporting " . str_replace("_", " ", $targetName) . "...");

            $bar = $this->output->createProgressBar(count($rows));

            $bar->start();

            foreach ($rows as $rowData) {

                if (
                    $this->option('force')
                    || DB::table($dbName)->where('id', $rowData['id'])->doesntExist()
                ) {
                    $rowData = array_map(function ($value) {
                        return $value === "" ? null : $value;
                    }, $rowData);

                    DB::table($dbName)->updateOrInsert(['id' => $rowData['id']], $rowData);

                    $bar->advance();
                }
            }

            $bar->finish();
        }

        $this->line('');
        $this->info('Data has been imported successfully!!!');
    }

    /**
     * @return array
     */
    abstract protected function getFiles();

    protected function extractCsvArray($file)
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
