<?php

namespace SaliBhdr\TyphoonIranCities\Commands\Traits;

use SaliBhdr\TyphoonIranCities\Enums\MigrationStub;

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
            $targets = [MigrationStub::Regions];

            if ($this->option('with-city-coordinates') && $this->targetIncludesCities()) {
                $targets[] = MigrationStub::CoordinatesRegions;
            }

            return $this->getTargets($targets);
        }

        $map = [
            'all' => $this->getTargets($this->withCoordinatesMigration([
                MigrationStub::Provinces,
                MigrationStub::Counties,
                MigrationStub::Sectors,
                MigrationStub::Cities,
                MigrationStub::CityDistricts,
                MigrationStub::RuralDistricts,
                MigrationStub::Villages,
            ])),
            'provinces' => $this->getTargets([MigrationStub::Provinces]),
            'counties' => $this->getTargets([MigrationStub::Provinces, MigrationStub::Counties]),
            'sectors' => $this->getTargets([MigrationStub::Provinces, MigrationStub::Counties, MigrationStub::Sectors]),
            'cities' => $this->getTargets($this->withCoordinatesMigration([
                MigrationStub::Provinces,
                MigrationStub::Counties,
                MigrationStub::Sectors,
                MigrationStub::Cities,
            ])),
            'city_districts' => $this->getTargets($this->withCoordinatesMigration([
                MigrationStub::Provinces,
                MigrationStub::Counties,
                MigrationStub::Sectors,
                MigrationStub::Cities,
                MigrationStub::CityDistricts,
            ])),
            'rural_districts' => $this->getTargets([
                MigrationStub::Provinces,
                MigrationStub::Counties,
                MigrationStub::Sectors,
                MigrationStub::RuralDistricts,
            ]),
            'villages' => $this->getTargets([
                MigrationStub::Provinces,
                MigrationStub::Counties,
                MigrationStub::Sectors,
                MigrationStub::RuralDistricts,
                MigrationStub::Villages,
            ]),
        ];

        if (isset($map[$target])) {
            return $map[$target];
        }

        throw new \Exception("Target Region ({$target}) Not Found", 404);
    }

    /**
     * @param list<MigrationStub> $targets
     * @return list<MigrationStub>
     */
    protected function withCoordinatesMigration(array $targets): array
    {
        if (!$this->option('with-city-coordinates') || !in_array(MigrationStub::Cities, $targets, true)) {
            return $targets;
        }

        return array_merge($targets, [MigrationStub::CoordinatesCities]);
    }

    /**
     * @return bool
     */
    protected function targetIncludesCities(): bool
    {
        return in_array($this->option('target'), ['all', 'cities', 'city_districts'], true);
    }

    /**
     * @param list<MigrationStub> $targets
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
