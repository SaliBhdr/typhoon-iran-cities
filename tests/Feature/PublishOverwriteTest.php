<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use Illuminate\Support\Facades\File;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class PublishOverwriteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        File::ensureDirectoryExists(app_path('Models'));
    }

    public function test_it_overwrites_existing_model_when_user_confirms(): void
    {
        $path = app_path('Models/IranProvince.php');
        file_put_contents($path, '<?php // stale');

        $this->artisan('iran:publish:models', ['--target' => 'provinces'])
            ->expectsQuestion("The file {$path} is exists. do you want to overwrite it? (y/n)", 'yes')
            ->assertSuccessful();

        $this->assertStringContainsString('namespace App\\Models;', File::get($path));
    }

    public function test_publish_migrations_rejects_unknown_target(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Target Region (unknown) Not Found');

        $this->artisan('iran:publish:migrations', ['--target' => 'unknown']);
    }

    public function test_publish_models_rejects_unknown_target(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Target Region (unknown) Not Found');

        $this->artisan('iran:publish:models', ['--target' => 'unknown']);
    }
}
