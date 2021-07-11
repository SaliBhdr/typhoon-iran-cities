<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\IranCsvEnum;

class ImportRuralDistricts extends AbstractImport
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import:rural-districts';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports rural districts, sectors, counties and provinces into the database';

    /**
     * @return array
     */
    protected function getFiles()
    {
        return IranCsvEnum::RURAL_DISTRICTS;
    }
}
