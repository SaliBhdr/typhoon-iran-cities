<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Unit;

use Illuminate\Support\Facades\DB;
use SaliBhdr\TyphoonIranCities\Models\IranCity;
use SaliBhdr\TyphoonIranCities\Models\IranCityDistrict;
use SaliBhdr\TyphoonIranCities\Models\IranProvince;
use SaliBhdr\TyphoonIranCities\Models\IranRegion;
use SaliBhdr\TyphoonIranCities\Models\IranRuralDistrict;
use SaliBhdr\TyphoonIranCities\Models\IranVillage;
use SaliBhdr\TyphoonIranCities\Tests\Concerns\SeedsIranHierarchy;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class HasStatusFieldTest extends TestCase
{
    use SeedsIranHierarchy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->runMigrationStub('1_create_iran_provinces_table.stub');
        $this->runMigrationStub('2_create_iran_counties_table.stub');
        $this->runMigrationStub('3_create_iran_sectors_table.stub');
        $this->runMigrationStub('4_create_iran_cities_table.stub');
        $this->runMigrationStub('5_create_iran_city_districts_table.stub');
        $this->runMigrationStub('6_create_iran_rural_districts_table.stub');
        $this->runMigrationStub('7_create_iran_villages_table.stub');

        DB::table('iran_provinces')->insert([
            'id' => 1, 'name' => 'Active Province', 'code' => '01', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_provinces')->insert([
            'id' => 2, 'name' => 'Inactive Province', 'code' => '02', 'short_code' => '02', 'status' => 0,
        ]);
        DB::table('iran_counties')->insert([
            'id' => 1, 'name' => 'County', 'province_id' => 1, 'code' => '0101', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_counties')->insert([
            'id' => 2, 'name' => 'County Inactive', 'province_id' => 2, 'code' => '0201', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_counties')->insert([
            'id' => 3, 'name' => 'Inactive County', 'province_id' => 1, 'code' => '0103', 'short_code' => '03', 'status' => 0,
        ]);
        DB::table('iran_sectors')->insert([
            'id' => 1, 'name' => 'Sector', 'province_id' => 1, 'county_id' => 1, 'code' => '010101', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_sectors')->insert([
            'id' => 2, 'name' => 'Sector Inactive', 'province_id' => 2, 'county_id' => 2, 'code' => '020101', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_sectors')->insert([
            'id' => 3, 'name' => 'Inactive Sector', 'province_id' => 1, 'county_id' => 1, 'code' => '010103', 'short_code' => '03', 'status' => 0,
        ]);
        DB::table('iran_cities')->insert([
            'id' => 1, 'name' => 'City Active Parent', 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'code' => '0101010001', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_cities')->insert([
            'id' => 2, 'name' => 'City Inactive Parent', 'province_id' => 2, 'county_id' => 2, 'sector_id' => 2, 'code' => '0201010001', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_cities')->insert([
            'id' => 3, 'name' => 'Inactive City', 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'code' => '0101010003', 'short_code' => '03', 'status' => 0,
        ]);
        DB::table('iran_city_districts')->insert([
            'id' => 1, 'name' => 'District', 'district' => 1, 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'city_id' => 1, 'code' => '010101000101', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_city_districts')->insert([
            'id' => 2, 'name' => 'District Inactive City', 'district' => 2, 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'city_id' => 3, 'code' => '010101000302', 'short_code' => '02', 'status' => 1,
        ]);
        DB::table('iran_rural_districts')->insert([
            'id' => 1, 'name' => 'Rural', 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'code' => '01010101', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_rural_districts')->insert([
            'id' => 2, 'name' => 'Inactive Rural', 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'code' => '01010102', 'short_code' => '02', 'status' => 0,
        ]);
        DB::table('iran_villages')->insert([
            'id' => 1, 'name' => 'Village', 'type' => 0, 'diag' => null, 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'rural_district_id' => 1, 'code' => '01010101001', 'short_code' => '01', 'status' => 1,
        ]);
        DB::table('iran_villages')->insert([
            'id' => 2, 'name' => 'Village Inactive Rural', 'type' => 0, 'diag' => null, 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'rural_district_id' => 2, 'code' => '01010101002', 'short_code' => '02', 'status' => 1,
        ]);
    }

    public function test_active_scope_excludes_cities_with_inactive_province(): void
    {
        $this->assertSame(1, IranCity::active()->count());
        $this->assertNull(IranCity::active()->find(2));
    }

    public function test_is_active_returns_false_when_province_is_inactive(): void
    {
        $city = IranCity::find(2);

        $this->assertTrue($city->status);
        $this->assertFalse($city->isActive());
    }

    public function test_is_active_returns_true_when_province_is_active(): void
    {
        $city = IranCity::find(1);

        $this->assertTrue($city->isActive());
    }

    public function test_deactivate_only_updates_local_record(): void
    {
        $province = IranProvince::find(1);
        $province->deactivate();

        $this->assertSame(0, DB::table('iran_provinces')->where('id', 1)->value('status'));
        $this->assertSame(1, DB::table('iran_cities')->where('id', 1)->value('status'));
    }

    public function test_activate_sets_status_to_active(): void
    {
        $province = IranProvince::find(2);
        $province->activate();

        $this->assertTrue($province->fresh()->isActive());
    }

    public function test_not_active_scope_returns_inactive_records(): void
    {
        $this->assertSame(1, IranProvince::notActive()->count());
    }

    public function test_is_not_active_returns_true_for_inactive_record(): void
    {
        $province = IranProvince::find(2);

        $this->assertTrue($province->isNotActive());
    }

    public function test_is_active_returns_false_when_county_is_inactive(): void
    {
        $city = IranCity::find(1);
        DB::table('iran_counties')->where('id', 1)->update(['status' => 0]);

        $this->assertFalse($city->fresh()->isActive());
    }

    public function test_is_active_returns_false_when_sector_is_inactive(): void
    {
        $city = IranCity::find(1);
        DB::table('iran_sectors')->where('id', 1)->update(['status' => 0]);

        $this->assertFalse($city->fresh()->isActive());
    }

    public function test_is_active_returns_false_when_city_is_inactive_for_district(): void
    {
        $district = IranCityDistrict::find(2);

        $this->assertFalse($district->isActive());
    }

    public function test_is_active_returns_false_when_rural_district_is_inactive_for_village(): void
    {
        $village = IranVillage::find(2);

        $this->assertFalse($village->isActive());
    }

    public function test_active_scope_excludes_records_with_inactive_ancestors(): void
    {
        $this->assertNull(IranCityDistrict::active()->find(2));
        $this->assertNull(IranVillage::active()->find(2));
    }

    public function test_is_not_active_returns_false_for_active_record(): void
    {
        $province = IranProvince::find(1);

        $this->assertFalse($province->isNotActive());
    }

    public function test_unite_region_active_scope_checks_parent_status(): void
    {
        $this->migrateUniteTables();
        $this->seedUniteHierarchy();

        $this->assertNull(IranRegion::active()->find(9));
        $this->assertFalse(IranRegion::find(9)->isActive());
    }

    public function test_unite_region_is_active_checks_parent_chain(): void
    {
        $this->migrateUniteTables();

        DB::table('iran_regions')->insert([
            'id' => 2, 'type' => 'province', 'parent_id' => null, 'province_id' => null, 'county_id' => null,
            'sector_id' => null, 'city_id' => null, 'rural_district_id' => null,
            'name' => 'Inactive Province', 'code' => '02', 'short_code' => '02', 'status' => 0,
        ]);
        DB::table('iran_regions')->insert([
            'id' => 10, 'type' => 'county', 'parent_id' => 2, 'province_id' => 2, 'county_id' => null,
            'sector_id' => null, 'city_id' => null, 'rural_district_id' => null,
            'name' => 'Child', 'code' => '0202', 'short_code' => '02', 'status' => 1,
        ]);

        $this->assertFalse(IranRegion::find(10)->isActive());
    }
}
