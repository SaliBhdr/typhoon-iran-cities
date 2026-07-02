<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use SaliBhdr\TyphoonIranCities\Tests\Concerns\UsesFixtureCsv;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class ImportPreflightTest extends TestCase
{
    use UsesFixtureCsv;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bindFixtureCsv();
    }

    public function test_import_reports_missing_table(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Table iran_provinces does not exist');

        $this->artisan('iran:import', ['--target' => 'provinces']);
    }
}
