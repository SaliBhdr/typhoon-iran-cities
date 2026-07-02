<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Models\Traits\HasVillages;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToSector;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToProvince;

/**
 * Class IranRuralDistrict (Dehestan)
 */
class IranRuralDistrict extends BaseIranModel
{
    use BelongsToProvince, BelongsToCounty, BelongsToSector, HasVillages;

    protected $table = 'iran_rural_districts';

    /**
     * @inheritdoc
     */
    protected function getReferenceKey()
    {
        return 'rural_district_id';
    }
}
