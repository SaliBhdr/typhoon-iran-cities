<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\Enums\TargetTypeEnum;
use SaliBhdr\TyphoonIranCities\Commands\Abstracts\AbstractImport;

class ImportSectors extends AbstractImport
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
        return TargetTypeEnum::SECTORS;
    }
}
