<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToSector;
use SaliBhdr\TyphoonIranCities\Traits\HasCityDistricts;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToProvince;

/**
 * Class IranCity (Shahr)
 */
class IranCity extends BaseIranModel
{
    use BelongsToProvince, BelongsToCounty, BelongsToSector, HasCityDistricts;

    protected $table = 'iran_cities';

    /**
     * @inheritdoc
     */
    protected function getReferenceKey()
    {
        return 'city_id';
    }
}
