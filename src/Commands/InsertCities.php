<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertCities extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran-cities:import';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports cities, counties and provinces into the database';


    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->info('Starting to import data...');
        $this->line('');

        $files = $this->dirToArray(__DIR__ . '/../../csv/');

        $files = array_reverse($files);

        foreach ($files as $fileName) {
            $rows = $this->extractCsvArray($fileName);

            if (empty($rows))
                continue;

            $dbName = str_replace('.csv', '', $fileName);

            $this->line('importing ' . $dbName . '...');

            foreach ($rows as $row)
                DB::table($dbName)->updateOrInsert($row);

        }

        $this->line('');
        $this->info('Data has been imported successfully!!!');
    }

    protected function dirToArray($dir)
    {

        $result = [];

        $cdir = scandir($dir);

        foreach ($cdir as $key => $value) {
            if (!in_array($value, [".", ".."])) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                }
                else {
                    $result[] = $value;
                }
            }
        }

        return $result;
    }

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


}
