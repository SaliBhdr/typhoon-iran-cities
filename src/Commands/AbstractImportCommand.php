<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

abstract class AbstractImportCommand extends Command
{
    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->info('Starting to import data...');
        $this->line('');

        $files = $this->getFiles();

        $files = array_reverse($files);

        foreach ($files as $fileName) {
            $rows = $this->extractCsvArray($fileName);

            if (empty($rows))
                continue;

            $dbName = str_replace('.csv', '', $fileName);

            $this->line('importing ' . $dbName . '...');

            foreach ($rows as $row){
                if(DB::table($dbName)->where('id', $row['id'])->doesntExist()){
                    $row['created_at'] = Carbon::now();
                    $row['updated_at'] = Carbon::now();
                    DB::table($dbName)->insert($row);
                }
            }
        }

        $this->line('');
        $this->info('Data has been imported successfully!!!');
    }

    /**
     * @return array
     */
    abstract protected function getFiles();

    protected function dirToArray($dir, array $skip = [])
    {

        $skip = array_merge($skip, [".", ".."]);

        $result = [];

        $targetDirFiles = scandir($dir);

        foreach ($targetDirFiles as $key => $value) {
            if (!in_array($value, $skip)) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                } else {
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
