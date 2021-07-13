<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Traits\BelongsToCity;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToSector;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToProvince;

/**
 * Class IranCityDistrict (Mantaghe Shahri)
 */
class IranCityDistrict extends BaseIranModel
{
    use BelongsToProvince, BelongsToCounty, BelongsToSector, BelongsToCity;

    /**
     * @inheritdoc
     */
    protected function getReferenceKey()
    {
        return 'city_district_id';
    }
}
