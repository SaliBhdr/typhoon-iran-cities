<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use Illuminate\Support\Facades\File;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class InitInteractiveTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        File::ensureDirectoryExists(database_path('migrations'));
        File::cleanDirectory(database_path('migrations'));
        File::ensureDirectoryExists(app_path('Models'));
    }

    public function test_it_skips_steps_when_user_answers_no(): void
    {
        $this->artisan('iran:init', ['--target' => 'provinces'])
            ->expectsQuestion('Do you want to publish package migrations? (y/n)', 'n')
            ->expectsQuestion('Do you want to publish package models? (y/n)', 'n')
            ->expectsQuestion('Do you want to run `php artisan migrate` to migrate package migrations? (y/n)', 'n')
            ->expectsQuestion('Do you want to import data? (y/n)', 'n')
            ->assertSuccessful();

        $this->assertEmpty(File::glob(database_path('migrations/*create_iran_provinces_table.php')));
    }

    public function test_it_retries_on_invalid_bool_answer(): void
    {
        $this->artisan('iran:init', ['--target' => 'provinces'])
            ->expectsQuestion('Do you want to publish package migrations? (y/n)', 'maybe')
            ->expectsQuestion('Do you want to publish package migrations? (y/n)', 'n')
            ->expectsQuestion('Do you want to publish package models? (y/n)', 'n')
            ->expectsQuestion('Do you want to run `php artisan migrate` to migrate package migrations? (y/n)', 'n')
            ->expectsQuestion('Do you want to import data? (y/n)', 'n')
            ->assertSuccessful();
    }
}
