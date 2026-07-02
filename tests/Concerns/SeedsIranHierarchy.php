<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Concerns;

use Illuminate\Support\Facades\DB;

trait SeedsIranHierarchy
{
    protected function seedFullHierarchy(): void
    {
        DB::table('iran_provinces')->insert([
            ['id' => 1, 'name' => 'Active Province', 'code' => '01', 'short_code' => '01', 'status' => 1],
            ['id' => 2, 'name' => 'Inactive Province', 'code' => '02', 'short_code' => '02', 'status' => 0],
        ]);

        DB::table('iran_counties')->insert([
            ['id' => 1, 'name' => 'Active County', 'province_id' => 1, 'code' => '0101', 'short_code' => '01', 'status' => 1],
            ['id' => 2, 'name' => 'Inactive County', 'province_id' => 2, 'code' => '0201', 'short_code' => '01', 'status' => 0],
        ]);

        DB::table('iran_sectors')->insert([
            ['id' => 1, 'name' => 'Active Sector', 'province_id' => 1, 'county_id' => 1, 'code' => '010101', 'short_code' => '01', 'status' => 1],
            ['id' => 2, 'name' => 'Inactive Sector', 'province_id' => 2, 'county_id' => 2, 'code' => '020101', 'short_code' => '01', 'status' => 0],
        ]);

        DB::table('iran_cities')->insert([
            ['id' => 1, 'name' => 'Active City', 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'code' => '0101010001', 'short_code' => '01', 'status' => 1],
            ['id' => 2, 'name' => 'Inactive City', 'province_id' => 2, 'county_id' => 2, 'sector_id' => 2, 'code' => '0201010001', 'short_code' => '01', 'status' => 0],
        ]);

        DB::table('iran_city_districts')->insert([
            ['id' => 1, 'name' => 'Active District', 'district' => 1, 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'city_id' => 1, 'code' => '010101000101', 'short_code' => '01', 'status' => 1],
            ['id' => 2, 'name' => 'Inactive District', 'district' => 2, 'province_id' => 2, 'county_id' => 2, 'sector_id' => 2, 'city_id' => 2, 'code' => '020101000101', 'short_code' => '01', 'status' => 0],
        ]);

        DB::table('iran_rural_districts')->insert([
            ['id' => 1, 'name' => 'Active Rural', 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'code' => '01010101', 'short_code' => '01', 'status' => 1],
            ['id' => 2, 'name' => 'Inactive Rural', 'province_id' => 2, 'county_id' => 2, 'sector_id' => 2, 'code' => '02010101', 'short_code' => '01', 'status' => 0],
        ]);

        DB::table('iran_villages')->insert([
            ['id' => 1, 'name' => 'Active Village', 'type' => 0, 'diag' => null, 'province_id' => 1, 'county_id' => 1, 'sector_id' => 1, 'rural_district_id' => 1, 'code' => '01010101001', 'short_code' => '01', 'status' => 1],
            ['id' => 2, 'name' => 'Inactive Village', 'type' => 0, 'diag' => null, 'province_id' => 2, 'county_id' => 2, 'sector_id' => 2, 'rural_district_id' => 2, 'code' => '02010101001', 'short_code' => '01', 'status' => 0],
        ]);
    }

    protected function seedUniteHierarchy(): void
    {
        DB::table('iran_regions')->insert([
            ['id' => 1, 'type' => 'province', 'parent_id' => null, 'province_id' => null, 'county_id' => null, 'sector_id' => null, 'city_id' => null, 'rural_district_id' => null, 'name' => 'Province', 'code' => '01', 'short_code' => '01', 'status' => 1],
            ['id' => 2, 'type' => 'province', 'parent_id' => null, 'province_id' => null, 'county_id' => null, 'sector_id' => null, 'city_id' => null, 'rural_district_id' => null, 'name' => 'Inactive Province', 'code' => '02', 'short_code' => '02', 'status' => 0],
            ['id' => 3, 'type' => 'county', 'parent_id' => 1, 'province_id' => 1, 'county_id' => null, 'sector_id' => null, 'city_id' => null, 'rural_district_id' => null, 'name' => 'County', 'code' => '0101', 'short_code' => '01', 'status' => 1],
            ['id' => 4, 'type' => 'sector', 'parent_id' => 3, 'province_id' => 1, 'county_id' => 3, 'sector_id' => null, 'city_id' => null, 'rural_district_id' => null, 'name' => 'Sector', 'code' => '010101', 'short_code' => '01', 'status' => 1],
            ['id' => 5, 'type' => 'city', 'parent_id' => 4, 'province_id' => 1, 'county_id' => 3, 'sector_id' => 4, 'city_id' => null, 'rural_district_id' => null, 'name' => 'City', 'code' => '0101010001', 'short_code' => '01', 'status' => 1],
            ['id' => 6, 'type' => 'city_district', 'parent_id' => 5, 'province_id' => 1, 'county_id' => 3, 'sector_id' => 4, 'city_id' => 5, 'rural_district_id' => null, 'name' => 'District', 'code' => '010101000101', 'short_code' => '01', 'status' => 1],
            ['id' => 7, 'type' => 'rural_district', 'parent_id' => 4, 'province_id' => 1, 'county_id' => 3, 'sector_id' => 4, 'city_id' => null, 'rural_district_id' => null, 'name' => 'Rural', 'code' => '01010101', 'short_code' => '01', 'status' => 1],
            ['id' => 8, 'type' => 'village', 'parent_id' => 7, 'province_id' => 1, 'county_id' => 3, 'sector_id' => 4, 'city_id' => null, 'rural_district_id' => 7, 'name' => 'Village', 'code' => '01010101001', 'short_code' => '01', 'status' => 1],
            ['id' => 9, 'type' => 'county', 'parent_id' => 2, 'province_id' => 2, 'county_id' => null, 'sector_id' => null, 'city_id' => null, 'rural_district_id' => null, 'name' => 'Child of Inactive', 'code' => '0201', 'short_code' => '01', 'status' => 1],
        ]);
    }
}
