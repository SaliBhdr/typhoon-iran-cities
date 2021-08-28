<?php

namespace SaliBhdr\TyphoonIranCities\Commands\Abstracts;

use Symfony\Component\Console\Input\InputOption;

abstract class AbstractPublish extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct();

        $this->getDefinition()->addOptions([
            new InputOption('force', null, InputOption::VALUE_NONE, 'Force to copy and overwrite files'),
            new InputOption('mode', null, InputOption::VALUE_OPTIONAL, 'Target region that you want to copy files, options : [separate, unite]', 'separate'),
            new InputOption('target', null, InputOption::VALUE_OPTIONAL, 'Target region that you want to copy files, options : [all, provinces, counties, sectors, cities, city_districts, rural_districts, villages]', 'all')
        ]);
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $map = $this->getFileMap();

        foreach ($map as $src => $destination) {
            if ($this->option('force') || !file_exists($destination)) {
                $this->copyFile($src, $destination);
            } elseif (file_exists($destination) && !$this->option('force')) {
                if ($this->askBoolQuestion('The file ' . $destination . ' is exists. do you want to overwrite it?')) {
                    $this->copyFile($src, $destination);
                }
            }
        }

        $this->info('Done !!!');
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getFileMap()
    {
        $target = $this->option('target');

        if($this->option('mode') == 'unite')
            return $this->getTargets([8]);

        $map = [
            'all'             => $this->getTargets([1, 2, 3, 4, 5, 6, 7]),
            'provinces'       => $this->getTargets([1]),
            'counties'        => $this->getTargets([1, 2]),
            'sectors'         => $this->getTargets([1, 2, 3,]),
            'cities'          => $this->getTargets([1, 2, 3, 4]),
            'city_districts'  => $this->getTargets([1, 2, 3, 4, 5]),
            'rural_districts' => $this->getTargets([1, 2, 3, 6]),
            'villages'        => $this->getTargets([1, 2, 3, 6, 7]),
        ];

        if (isset($map[$target]))
            return $map[$target];

        throw new \Exception("Target Region ({$target}) Not Found", 404);
    }

    /**
     * @param $targets
     * @return mixed
     */
    abstract protected function getTargets($targets);

    /**
     * @param string $src
     * @param string $destination
     * @return void
     */
    abstract protected function copyFile($src, $destination);
}
