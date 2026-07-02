<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Unit;

use SaliBhdr\TyphoonIranCities\Models\IranRegion;
use SaliBhdr\TyphoonIranCities\Tests\Concerns\SeedsIranHierarchy;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class IranRegionRelationsTest extends TestCase
{
    use SeedsIranHierarchy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->migrateUniteTables();
        $this->seedUniteHierarchy();
    }

    public function test_region_exposes_hierarchy_relations(): void
    {
        $county = IranRegion::find(3);
        $city = IranRegion::find(5);
        $province = IranRegion::find(1);

        $this->assertSame(1, $county->parent->id);
        $this->assertCount(1, $province->children);
        $this->assertSame(1, $county->province->id);
        $this->assertNotNull($province->provinceChildren()->where('type', 'county')->first());
        $this->assertSame(3, $city->county->id);
        $this->assertNotNull($county->countyChildren()->where('type', 'sector')->first());
        $this->assertSame(4, $city->sector->id);
        $this->assertNotNull(IranRegion::find(4)->sectorChildren()->where('type', 'city')->first());
        $this->assertSame(5, IranRegion::find(6)->city->id);
        $this->assertNotNull($city->cityChildren()->where('type', 'city_district')->first());
        $this->assertSame(7, IranRegion::find(8)->ruralDistrict->id);
        $this->assertNotNull(IranRegion::find(7)->ruralDistrictChildren()->where('type', 'village')->first());
    }
}
