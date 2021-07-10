<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\IranCsvEnum;
use Symfony\Component\Console\Input\InputOption;

class ImportIran extends AbstractImport
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'iran:import';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports all regions into the database (Can be selected by option)';

    public function __construct()
    {
        parent::__construct();

        $this->getDefinition()->addOptions([
            new InputOption('region', null, InputOption::VALUE_OPTIONAL, 'Target region that you want to import, options : [provinces, counties, sectors, cities, city_districts, rural_districts, villages]', 'all')
        ]);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getFiles()
    {
        $region = $this->option('region');

        $target = [
            'all'             => IranCsvEnum::ALL,
            'provinces'       => IranCsvEnum::PROVINCES,
            'counties'        => IranCsvEnum::COUNTIES,
            'sectors'         => IranCsvEnum::SECTORS,
            'cities'          => IranCsvEnum::CITIES,
            'city_districts'  => IranCsvEnum::CITY_DISTRICTS,
            'rural_districts' => IranCsvEnum::RURAL_DISTRICTS,
            'villages'        => IranCsvEnum::VILLAGES
        ];

        if (isset($target[$region]))
            return $target[$region];

        throw new \Exception("Target Region ({$region}) Not Found", 404);
    }
}
