<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Unit;

use SaliBhdr\TyphoonIranCities\Enums\RegionType;
use SaliBhdr\TyphoonIranCities\Support\ImportTargetMap;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class ImportTargetMapTest extends TestCase
{
    public function test_cities_target_includes_required_region_types(): void
    {
        $this->assertSame(
            ['province', 'county', 'sector', 'city'],
            ImportTargetMap::regionTypeValues('cities')
        );
    }

    public function test_unite_csv_sources_use_singular_region_name(): void
    {
        $this->assertSame(['region'], ImportTargetMap::uniteCsvSources());
    }

    public function test_region_type_values_match_database_values(): void
    {
        $this->assertSame('city_district', RegionType::CityDistrict->value);
        $this->assertSame(RegionType::values(), ImportTargetMap::regionTypeValues('all'));
    }

    public function test_is_valid_rejects_unknown_targets(): void
    {
        $this->assertFalse(ImportTargetMap::isValid('unknown'));
    }

    public function test_region_types_throws_for_unknown_target(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown import target: unknown');

        ImportTargetMap::regionTypes('unknown');
    }
}
