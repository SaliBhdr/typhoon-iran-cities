<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\IranCsvEnum;

class ImportProvinces extends AbstractImport
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import:provinces';

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
        return IranCsvEnum::PROVINCES;
    }

}
