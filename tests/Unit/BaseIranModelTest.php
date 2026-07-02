<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Unit;

use Illuminate\Support\Facades\DB;
use SaliBhdr\TyphoonIranCities\Models\IranProvince;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class BaseIranModelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->runMigrationStub('1_create_iran_provinces_table.stub');

        DB::table('iran_provinces')->insert([
            ['id' => 1, 'name' => 'Active', 'code' => '01', 'short_code' => '01', 'status' => 1],
            ['id' => 2, 'name' => 'Inactive', 'code' => '02', 'short_code' => '02', 'status' => 0],
        ]);
    }

    public function test_get_all_returns_all_records(): void
    {
        $this->assertCount(2, IranProvince::getAll());
    }

    public function test_get_all_active_returns_only_active_records(): void
    {
        $this->assertCount(1, IranProvince::getAllActive());
    }

    public function test_get_all_not_active_returns_only_inactive_records(): void
    {
        $this->assertCount(1, IranProvince::getAllNotActive());
    }
}
