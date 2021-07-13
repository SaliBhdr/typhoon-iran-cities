<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Traits\HasVillages;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToSector;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToProvince;

/**
 * Class IranRuralDistrict (Dehestan)
 */
class IranRuralDistrict extends BaseIranModel
{
    use BelongsToProvince, BelongsToCounty, BelongsToSector, HasVillages;

    /**
     * @inheritdoc
     */
    protected function getReferenceKey()
    {
        return 'rural_district_id';
    }
}
