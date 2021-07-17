<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

class PublishModels extends AbstractPublish
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $name = 'iran:publish:models';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Copies related models';

    /**
     * @param array[int] $targets
     * @return array
     */
    protected function getTargets($targets)
    {
        $src = $this->getSrcDir();

        $target = $this->getTargetDir();

        $map = [
            1 => [$src . 'IranProvince.stub'        => $target . 'IranProvince.php'],
            2 => [$src . 'IranCounty.stub'          => $target . 'IranCounty.php'],
            3 => [$src . 'IranSector.stub'          => $target . 'IranSector.php'],
            4 => [$src . 'IranCity.stub'            => $target . 'IranCity.php'],
            5 => [$src . 'IranCityDistrict.stub'    => $target . 'IranCityDistrict.php'],
            6 => [$src . 'IranRuralDistrict.stub'   => $target . 'IranRuralDistrict.php'],
            7 => [$src . 'IranVillage.stub'         => $target . 'IranVillage.php'],
        ];

        $result = [];

        foreach ($targets as $target) {
            if (isset($map[$target]))
                $result = array_merge($result, $map[$target]);
        }

        return $result;
    }

    /**
     * Get models src dir
     *
     * @return string
     */
    protected function getSrcDir()
    {
        return realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'models') . DIRECTORY_SEPARATOR;
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
        $namespace = $this->getTargetNamespace();

        $modelContent = file_get_contents($src);
        $modelContent = str_replace("{{ namespace }}", $namespace, $modelContent);

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
