<?php

namespace SaliBhdr\TyphoonIranCities\Support;

use InvalidArgumentException;
use SaliBhdr\TyphoonIranCities\Enums\RegionType;

/**
 * Maps CLI import targets to the region types included in each import.
 */
final class ImportTargetMap
{
    /**
     * @var array<string, list<RegionType>>
     */
    private const REGION_TYPES_BY_TARGET = [
        'all' => [
            RegionType::Province,
            RegionType::County,
            RegionType::Sector,
            RegionType::City,
            RegionType::CityDistrict,
            RegionType::RuralDistrict,
            RegionType::Village,
        ],
        'provinces' => [
            RegionType::Province,
        ],
        'counties' => [
            RegionType::Province,
            RegionType::County,
        ],
        'sectors' => [
            RegionType::Province,
            RegionType::County,
            RegionType::Sector,
        ],
        'cities' => [
            RegionType::Province,
            RegionType::County,
            RegionType::Sector,
            RegionType::City,
        ],
        'city_districts' => [
            RegionType::Province,
            RegionType::County,
            RegionType::Sector,
            RegionType::City,
            RegionType::CityDistrict,
        ],
        'rural_districts' => [
            RegionType::Province,
            RegionType::County,
            RegionType::Sector,
            RegionType::RuralDistrict,
        ],
        'villages' => [
            RegionType::Province,
            RegionType::County,
            RegionType::Sector,
            RegionType::RuralDistrict,
            RegionType::Village,
        ],
    ];

    public static function isValid(string $target): bool
    {
        return isset(self::REGION_TYPES_BY_TARGET[$target]);
    }

    /**
     * @return list<RegionType>
     */
    public static function regionTypes(string $target): array
    {
        if (!self::isValid($target)) {
            throw new InvalidArgumentException("Unknown import target: {$target}");
        }

        return self::REGION_TYPES_BY_TARGET[$target];
    }

    /**
     * @return list<string>
     */
    public static function regionTypeValues(string $target): array
    {
        return array_map(
            fn (RegionType $type) => $type->value,
            self::regionTypes($target)
        );
    }

    /**
     * CSV file base names for unite mode (singular; Import pluralizes to "regions").
     *
     * @return list<string>
     */
    public static function uniteCsvSources(): array
    {
        return ['region'];
    }
}
