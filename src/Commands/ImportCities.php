<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\Enums\IranCsvEnum;
use SaliBhdr\TyphoonIranCities\Commands\Abstracts\AbstractImport;

class ImportCities extends AbstractImport
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
        return IranCsvEnum::CITIES;
    }
}
