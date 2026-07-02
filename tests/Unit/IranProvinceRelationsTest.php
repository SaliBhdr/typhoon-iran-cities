<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Unit;

use Illuminate\Support\Facades\DB;
use SaliBhdr\TyphoonIranCities\Models\IranCounty;
use SaliBhdr\TyphoonIranCities\Models\IranProvince;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class IranProvinceRelationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->runMigrationStub('1_create_iran_provinces_table.stub');
        $this->runMigrationStub('2_create_iran_counties_table.stub');

        DB::table('iran_provinces')->insert([
            'id' => 1, 'name' => 'Tehran', 'code' => '01', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_counties')->insert([
            'id' => 1, 'name' => 'Tehran County', 'province_id' => 1, 'code' => '0101', 'short_code' => '01', 'status' => 1,
        ]);
    }

    public function test_counties_relation_returns_related_records(): void
    {
        $province = IranProvince::find(1);

        $this->assertCount(1, $province->counties);
        $this->assertSame('Tehran County', $province->counties->first()->name);
    }

    public function test_get_counties_returns_collection(): void
    {
        $province = IranProvince::find(1);

        $this->assertCount(1, $province->getCounties());
    }

    public function test_county_belongs_to_province(): void
    {
        $county = IranCounty::find(1);

        $this->assertSame('Tehran', $county->getProvince()->name);
    }
}
