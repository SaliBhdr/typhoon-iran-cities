<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\IranCsvEnum;

class ImportSectors extends AbstractImportCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import:sectors';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports sectors, counties and provinces into the database';

    /**
     * @return array
     */
    protected function getFiles()
    {
        return IranCsvEnum::SECTORS;
    }
}
