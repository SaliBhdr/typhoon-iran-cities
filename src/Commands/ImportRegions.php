<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\Enums\TargetTypeEnum;
use SaliBhdr\TyphoonIranCities\Commands\Abstracts\AbstractImport;

class ImportRegions extends AbstractImport
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import:regions';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports all regions in one table';

    /**
     * @return array
     */
    protected function getFiles()
    {
        return TargetTypeEnum::REGIONS;
    }

    protected function canImport($data)
    {
        $target = $this->option('target');
    }
}
