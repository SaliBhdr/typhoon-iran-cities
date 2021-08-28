<?php

namespace SaliBhdr\TyphoonIranCities\Enums;

final class TargetTypeEnum
{
    const ALL = [
        RegionTypeEnum::PROVINCE,
        RegionTypeEnum::COUNTY,
        RegionTypeEnum::SECTOR,
        RegionTypeEnum::CITY,
        RegionTypeEnum::CITY_DISTRICT,
        RegionTypeEnum::RURAL_DISTRICT,
        RegionTypeEnum::VILLAGE,
    ];

    const PROVINCES = [
        RegionTypeEnum::PROVINCE,
    ];

    const COUNTIES = [
        RegionTypeEnum::PROVINCE,
        RegionTypeEnum::COUNTY,
    ];

    const SECTORS = [
        RegionTypeEnum::PROVINCE,
        RegionTypeEnum::COUNTY,
        RegionTypeEnum::SECTOR,
    ];

    const CITIES = [
        RegionTypeEnum::PROVINCE,
        RegionTypeEnum::COUNTY,
        RegionTypeEnum::SECTOR,
        RegionTypeEnum::CITY,
    ];

    const CITY_DISTRICTS = [
        RegionTypeEnum::PROVINCE,
        RegionTypeEnum::COUNTY,
        RegionTypeEnum::SECTOR,
        RegionTypeEnum::CITY,
        RegionTypeEnum::CITY_DISTRICT,
    ];

    const RURAL_DISTRICTS = [
        RegionTypeEnum::PROVINCE,
        RegionTypeEnum::COUNTY,
        RegionTypeEnum::SECTOR,
        RegionTypeEnum::RURAL_DISTRICT,
    ];

    const VILLAGES = [
        RegionTypeEnum::PROVINCE,
        RegionTypeEnum::COUNTY,
        RegionTypeEnum::SECTOR,
        RegionTypeEnum::RURAL_DISTRICT,
        RegionTypeEnum::VILLAGE,
    ];

    const REGIONS = [
        'region'
    ];
}
