<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use SaliBhdr\TyphoonIranCities\Enums\TargetTypeEnum;
use Symfony\Component\Console\Input\InputOption;
use SaliBhdr\TyphoonIranCities\Commands\Abstracts\AbstractImport;

class Import extends AbstractImport
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
            new InputOption('mode', null, InputOption::VALUE_OPTIONAL, 'The method of importing data. separate will put data in separate database and unite will put all regions into one region table, options : [separate, unite]', 'separate'),
            new InputOption('target', null, InputOption::VALUE_OPTIONAL, 'Target region that you want to import, options : [all, provinces, counties, sectors, cities, city_districts, rural_districts, villages]', 'all')
        ]);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getFiles()
    {
        if ($this->option('mode') == 'unite')
            return TargetTypeEnum::REGIONS;

        return $this->getTarget();
    }

    protected function canImport($data)
    {
        if ($this->option('mode') == 'separate' || !isset($data['type']))
            return true;

        $target = $this->getTarget();

        if (in_array($data['type'], $target))
            return true;

        return false;
    }

    private function getTarget()
    {
        $target = $this->option('target');

        $map = [
            'all'             => TargetTypeEnum::ALL,
            'provinces'       => TargetTypeEnum::PROVINCES,
            'counties'        => TargetTypeEnum::COUNTIES,
            'sectors'         => TargetTypeEnum::SECTORS,
            'cities'          => TargetTypeEnum::CITIES,
            'city_districts'  => TargetTypeEnum::CITY_DISTRICTS,
            'rural_districts' => TargetTypeEnum::RURAL_DISTRICTS,
            'villages'        => TargetTypeEnum::VILLAGES
        ];

        if (isset($map[$target]))
            return $map[$target];

        throw new \Exception("Target Region ({$target}) Not Found", 404);
    }
}
