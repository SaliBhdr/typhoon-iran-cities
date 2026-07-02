<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToSector;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasCityDistricts;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToProvince;

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
