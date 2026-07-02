<?php

namespace SaliBhdr\TyphoonIranCities\Enums;

enum RegionType: string
{
    case Province = 'province';

    case County = 'county';

    case Sector = 'sector';

    case City = 'city';

    case CityDistrict = 'city_district';

    case RuralDistrict = 'rural_district';

    case Village = 'village';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }
}
