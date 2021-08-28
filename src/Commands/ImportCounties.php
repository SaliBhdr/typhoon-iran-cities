<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\Enums\IranCsvEnum;
use SaliBhdr\TyphoonIranCities\Commands\Abstracts\AbstractImport;

class ImportCounties extends AbstractImport
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
        return IranCsvEnum::COUNTIES;
    }

}
