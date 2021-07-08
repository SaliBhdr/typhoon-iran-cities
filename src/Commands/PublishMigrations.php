<?php

namespace SaliBhdr\TyphoonIranCities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class PublishMigrations extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $name = 'iran:publish:migrations';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Copies migrations into migrations directory';


    public function __construct()
    {
        parent::__construct();

        $this->getDefinition()->addOptions([
            new InputOption('force', null, InputOption::VALUE_NONE, 'Force to copy and overwrite files')
        ]);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        $src = $this->getSrcDir();

        $timestamp = time();

        $map = [
            $src . '1_create_iran_provinces_table.stub'       => $this->getMigrationFileName('create_iran_provinces_table.php', $timestamp),
            $src . '2_create_iran_counties_table.stub'        => $this->getMigrationFileName('create_iran_counties_table.php', $timestamp + 1),
            $src . '3_create_iran_sectors_table.stub'         => $this->getMigrationFileName('create_iran_sectors_table.php', $timestamp + 2),
            $src . '4_create_iran_cities_table.stub'          => $this->getMigrationFileName('create_iran_cities_table.php', $timestamp + 3),
            $src . '5_create_iran_city_districts_table.stub'  => $this->getMigrationFileName('create_iran_city_districts_table.php', $timestamp + 4),
            $src . '6_create_iran_rural_districts_table.stub' => $this->getMigrationFileName('create_iran_rural_districts_table.php', $timestamp + 5),
            $src . '7_create_iran_villages_table.stub'        => $this->getMigrationFileName('create_iran_villages_table.php', $timestamp + 6),
        ];


        foreach ($map as $stubFile => $migrationFile) {
            if ($this->option('force') || !file_exists($migrationFile)) {
                file_put_contents($migrationFile, file_get_contents($stubFile));
            }
        }
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param string $fileName
     * @param null $timestamp
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getMigrationFileName($fileName, $timestamp = null)
    {
        if (empty($timestamp))
            $timestamp = time();

        $filesystem = $this->laravel->make(Filesystem::class);

        $targetDirPath = database_path() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR;

        return Collection::make($targetDirPath)
                         ->flatMap(function ($path) use ($filesystem, $fileName) {
                             return $filesystem->glob($path . '*_' . $fileName);
                         })
                         ->push($targetDirPath . date('Y_m_d_His', $timestamp) . "_{$fileName}")
                         ->first();
    }

    /**
     * Get models src dir
     *
     * @return string
     */
    protected function getSrcDir()
    {
        return realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'migrations') . DIRECTORY_SEPARATOR;
    }
}
