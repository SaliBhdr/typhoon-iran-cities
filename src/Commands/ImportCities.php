<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\IranCsvEnum;

class ImportCities extends AbstractImportCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import:cities';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports cities, sectors, counties and provinces into the database';

    /**
     * @return array
     */
    protected function getFiles()
    {
        return IranCsvEnum::CITY;
    }
}
