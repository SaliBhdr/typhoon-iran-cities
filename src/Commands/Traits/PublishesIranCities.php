<?php

namespace SaliBhdr\TyphoonIranCities\Commands\Traits;

trait PublishesIranCities
{
    use AsksBoolQuestions;

    public const SIGNATURE_OPTIONS = '
    {--force : Force to overwrite copied files}
    {--unite : Unite will put all regions into one region table and will not separate regional tables}
    {--target=all : Target region that you desire to have, options : [all, provinces, counties, sectors, cities, city_districts, rural_districts, villages]}
    {--with-city-coordinates : Publish city coordinates migration (lat/lon) when cities are included in the target}';

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

        if ($this->option('unite')) {
            $targets = [8];

            if ($this->option('with-city-coordinates') && $this->targetIncludesCities())
                $targets[] = 10;

            return $this->getTargets($targets);
        }

        $map = [
            'all'             => $this->getTargets($this->withCoordinatesMigration([1, 2, 3, 4, 5, 6, 7])),
            'provinces'       => $this->getTargets([1]),
            'counties'        => $this->getTargets([1, 2]),
            'sectors'         => $this->getTargets([1, 2, 3,]),
            'cities'          => $this->getTargets($this->withCoordinatesMigration([1, 2, 3, 4])),
            'city_districts'  => $this->getTargets($this->withCoordinatesMigration([1, 2, 3, 4, 5])),
            'rural_districts' => $this->getTargets([1, 2, 3, 6]),
            'villages'        => $this->getTargets([1, 2, 3, 6, 7]),
        ];

        if (isset($map[$target]))
            return $map[$target];

        throw new \Exception("Target Region ({$target}) Not Found", 404);
    }

    /**
     * @param array $targets
     * @return array
     */
    protected function withCoordinatesMigration(array $targets): array
    {
        if (!$this->option('with-city-coordinates') || !in_array(4, $targets))
            return $targets;

        return array_merge($targets, [9]);
    }

    /**
     * @return bool
     */
    protected function targetIncludesCities(): bool
    {
        return in_array($this->option('target'), ['all', 'cities', 'city_districts']);
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
