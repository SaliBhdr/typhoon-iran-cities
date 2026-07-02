<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use SaliBhdr\TyphoonIranCities\Tests\Concerns\UsesFixtureCsv;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class InitTest extends TestCase
{
    use UsesFixtureCsv;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bindFixtureCsv();

        File::ensureDirectoryExists(database_path('migrations'));
        File::ensureDirectoryExists(app_path('Models'));
    }

    public function test_it_runs_all_steps_in_non_interactive_mode(): void
    {
        $this->artisan('iran:init', [
            '--no-interaction' => true,
            '--force'          => true,
            '--target'         => 'provinces',
        ])->assertSuccessful();

        $this->assertNotEmpty(File::glob(database_path('migrations/*create_iran_provinces_table.php')));
        $this->assertFileExists(app_path('Models/IranProvince.php'));
        $this->assertSame(2, DB::table('iran_provinces')->count());
    }
}
