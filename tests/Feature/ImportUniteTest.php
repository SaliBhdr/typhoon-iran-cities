<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use Illuminate\Support\Facades\DB;
use SaliBhdr\TyphoonIranCities\Enums\RegionType;
use SaliBhdr\TyphoonIranCities\Tests\Concerns\UsesFixtureCsv;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class ImportUniteTest extends TestCase
{
    use UsesFixtureCsv;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bindFixtureCsv();
    }

    public function test_it_imports_only_provinces_in_unite_mode(): void
    {
        $this->migrateUniteTables();

        $this->artisan('iran:import', [
            '--unite'  => true,
            '--target' => 'provinces',
        ])->assertSuccessful();

        $this->assertSame(2, DB::table('iran_regions')->where('type', RegionType::Province->value)->count());
        $this->assertSame(0, DB::table('iran_regions')->where('type', RegionType::County->value)->count());
    }
}
