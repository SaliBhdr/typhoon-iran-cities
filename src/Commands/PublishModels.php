<?php
namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class PublishModels extends Command
{
    protected $name = 'iran:publish:models';

    /**
     * AbstractImportCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->getDefinition()->addOptions([
            new InputOption('force', null, InputOption::VALUE_NONE, 'Force to copy and overwrite files')
        ]);
    }

    public function handle()
    {
        $src = $this->getSrcDir();

        $target = $this->getTargetDir();

        $namespace = $this->getTargetNamespace();

        $map = [
            $src . 'IranProvince.stub'      => $target . 'IranProvince.php',
            $src . 'IranCounty.stub'        => $target . 'IranCounty.php',
            $src . 'IranSector.stub'        => $target . 'IranSector.php',
            $src . 'IranCity.stub'          => $target . 'IranCity.php',
            $src . 'IranCityDistrict.stub'  => $target . 'IranCityDistrict.php',
            $src . 'IranRuralDistrict.stub' => $target . 'IranRuralDistrict.php',
            $src . 'IranVillage.stub'       => $target . 'IranVillage.php',
        ];


        foreach ($map as $stubFile => $modelFile) {
            if ($this->option('force') || !file_exists($modelFile)) {

                $modelContent = file_get_contents($stubFile);
                $modelContent = str_replace("{{ namespace }}", $namespace, $modelContent);

                file_put_contents($modelFile, $modelContent);
            }
        }
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
     * Get models src dir
     *
     * @return string
     */
    protected function getSrcDir()
    {
        return realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models') . DIRECTORY_SEPARATOR;
    }
}
