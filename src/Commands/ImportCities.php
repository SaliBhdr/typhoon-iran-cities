<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

class ImportCities extends AbstractImportCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:cities';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports cities, counties and provinces into the database';

    /**
     * @return array
     */
    protected function getFiles()
    {
        return $this->dirToArray(__DIR__ . '/../../csv/');
    }
}
