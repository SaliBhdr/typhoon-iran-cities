<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProvinces extends AbstractImportCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import-provinces';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports provinces only into the database';


    /**
     * @return array
     */
    protected function getFiles()
    {
        return $this->dirToArray(__DIR__ . '/../../csv/', ['cities.csv', 'counties.csv']);
    }

}
