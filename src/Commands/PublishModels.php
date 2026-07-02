<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use SaliBhdr\TyphoonIranCities\Commands\Traits\PublishesIranCities;
use SaliBhdr\TyphoonIranCities\Enums\MigrationStub;
use SaliBhdr\TyphoonIranCities\Support\PackagePath;

#[Signature('iran:publish:models' . PublishModels::SIGNATURE_OPTIONS)]
#[Description('Copies related models')]
class PublishModels extends Command
{
    use PublishesIranCities;

    /**
     * @param list<MigrationStub> $targets
     * @return array
     */
    protected function getTargets($targets)
    {
        $stubsDir = $this->getStubsDir();

        $target = $this->getTargetDir();

        $map = [
            MigrationStub::Provinces->value => [$stubsDir . 'IranProvince.stub' => $target . 'IranProvince.php'],
            MigrationStub::Counties->value => [$stubsDir . 'IranCounty.stub' => $target . 'IranCounty.php'],
            MigrationStub::Sectors->value => [$stubsDir . 'IranSector.stub' => $target . 'IranSector.php'],
            MigrationStub::Cities->value => [$stubsDir . 'IranCity.stub' => $target . 'IranCity.php'],
            MigrationStub::CityDistricts->value => [$stubsDir . 'IranCityDistrict.stub' => $target . 'IranCityDistrict.php'],
            MigrationStub::RuralDistricts->value => [$stubsDir . 'IranRuralDistrict.stub' => $target . 'IranRuralDistrict.php'],
            MigrationStub::Villages->value => [$stubsDir . 'IranVillage.stub' => $target . 'IranVillage.php'],
            MigrationStub::Regions->value => [$stubsDir . 'IranRegion.stub' => $target . 'IranRegion.php'],
        ];

        $result = [];

        foreach ($targets as $stub) {
            $key = $stub instanceof MigrationStub ? $stub->value : $stub;

            if (isset($map[$key])) {
                $result = array_merge($result, $map[$key]);
            }
        }

        return $result;
    }

    /**
     * Get model stubs directory.
     *
     * @return string
     */
    protected function getStubsDir()
    {
        return PackagePath::stubs('models') . DIRECTORY_SEPARATOR;
    }

    /**
     * Get models target dir
     *
     * @return string
     */
    protected function getTargetDir()
    {
        return realpath(is_dir(app_path('Models')) ? app_path('Models') : app_path()) . DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $src
     * @param string $destination
     * @return void
     */
    protected function copyFile($src, $destination)
    {
        $modelContent = str_replace("{{ namespace }}", $this->getTargetNamespace(), file_get_contents($src));

        file_put_contents($destination, $modelContent);
    }

    /**
     * Get the default namespace for the class.
     *
     * @return string
     */
    protected function getTargetNamespace()
    {
        $rootNamespace = $this->laravel->getNamespace();

        return stripslashes(rtrim(is_dir(app_path('Models')) ? "{$rootNamespace}\Models" : $rootNamespace, '\\'));
    }
}
