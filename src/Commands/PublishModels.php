<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;

class PublishModels extends Command
{
    protected $name = 'iran:publish:models';

    public function handle()
    {
        $src = __DIR__ . '/../Models/';

        $target = $this->getTargetDir();

        $namespace = $this->getNamespace();

        $map = [
//            $src . 'IranProvince.stub'       => $target.'IranProvince.php',
//            $src . 'IranCounty.stub'       => $target.'IranCounty.php',
//            $src . 'IranSector.stub'       => $target.'IranSector.php',
            $src . 'IranCity.stub'       => $target.'IranCity.php',
//            $src . 'IranCityDistrict.stub'       => $target.'IranCityDistrict.php',
//            $src . 'IranRuralDistrict.stub'       => $target.'IranRuralDistrict.php',
//            $src . 'IranVillage.stub'       => $target.'IranVillage.php',
        ];

        foreach ($map as $stub => $target) {

            $md = file_get_contents($stub);
            $md = str_replace("{{ namespace }}",$namespace, $md);

            file_put_contents($target, $md);
        }
    }

    /**
     * Get the default namespace for the class.
     *
     * @return string
     */
    protected function getNamespace()
    {
        $rootNamespace = $this->laravel->getNamespace();

        return is_dir(app_path('Models')) ? $rootNamespace.'\\'.'Models' : $rootNamespace;
    }

    /**
     * Get the default namespace for the class.
     *
     * @return string
     */
    protected function getTargetDir()
    {
        return is_dir(app_path('Models')) ?  app_path('Models') : app_path();
    }

}
