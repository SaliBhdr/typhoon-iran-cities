<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToCity;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToSector;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToProvince;

/**
 * Class IranCityDistrict (Mantaghe Shahri)
 */
class IranCityDistrict extends BaseIranModel
{
    use BelongsToProvince, BelongsToCounty, BelongsToSector, BelongsToCity;

    protected $table = 'iran_city_districts';

    /**
     * @inheritdoc
     */
    protected function getReferenceKey()
    {
        return 'city_district_id';
    }
}
