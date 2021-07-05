<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SaliBhdr\TyphoonIranCities\IranCsvEnum;

class ImportCounties extends AbstractImportCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import:counties';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports counties and provinces without cities into the database';


    /**
     * @return array
     */
    protected function getFiles()
    {
        return IranCsvEnum::COUNTY;
    }

}
