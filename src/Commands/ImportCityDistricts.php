<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\IranCsvEnum;

class ImportCityDistricts extends AbstractImportCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import:city-districts';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports city districts, cities, sectors, counties and provinces into the database';

    /**
     * @return array
     */
    protected function getFiles()
    {
        return IranCsvEnum::CITY_DISTRICT;
    }
}
