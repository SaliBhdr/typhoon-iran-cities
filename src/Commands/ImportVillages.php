<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\IranCsvEnum;
use SaliBhdr\TyphoonIranCities\Commands\Abstracts\AbstractImport;

class ImportVillages extends AbstractImport
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import:villages';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports villages, rural districts, sectors, counties and provinces into the database';

    /**
     * @return array
     */
    protected function getFiles()
    {
        return IranCsvEnum::VILLAGES;
    }
}
