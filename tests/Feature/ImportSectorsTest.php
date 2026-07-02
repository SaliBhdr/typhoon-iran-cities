<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use Illuminate\Support\Facades\DB;
use SaliBhdr\TyphoonIranCities\Models\IranProvince;
use SaliBhdr\TyphoonIranCities\Tests\Concerns\UsesFixtureCsv;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class ImportSectorsTest extends TestCase
{
    use UsesFixtureCsv;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bindFixtureCsv();
    }

    public function test_it_imports_sectors_after_prerequisite_tables(): void
    {
        $this->runMigrationStub('1_create_iran_provinces_table.stub');
        $this->runMigrationStub('2_create_iran_counties_table.stub');
        $this->runMigrationStub('3_create_iran_sectors_table.stub');

        $this->artisan('iran:import', ['--target' => 'sectors'])->assertSuccessful();

        $this->assertSame(2, DB::table('iran_provinces')->count());
        $this->assertSame(1, DB::table('iran_counties')->count());
        $this->assertSame(1, DB::table('iran_sectors')->count());
    }
}
