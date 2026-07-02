<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use Illuminate\Support\Facades\File;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class PublishModelsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        File::ensureDirectoryExists(app_path('Models'));
    }

    public function test_it_publishes_models_with_app_namespace(): void
    {
        $this->artisan('iran:publish:models', [
            '--target' => 'cities',
            '--force'  => true,
        ])->assertSuccessful();

        $path = app_path('Models/IranCity.php');

        $this->assertFileExists($path);

        $contents = File::get($path);

        $this->assertStringContainsString('namespace App\\Models;', $contents);
        $this->assertStringContainsString('extends BaseModel', $contents);
    }

    public function test_it_publishes_unite_region_model(): void
    {
        $this->artisan('iran:publish:models', [
            '--unite'  => true,
            '--target' => 'cities',
            '--force'  => true,
        ])->assertSuccessful();

        $this->assertFileExists(app_path('Models/IranRegion.php'));
    }
}
