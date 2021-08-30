<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToSector;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToProvince;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToRuralDistrict;

/**
 * Class IranVillage (Abadi)
 */
class IranVillage extends BaseIranModel
{
    use BelongsToProvince, BelongsToCounty, BelongsToSector, BelongsToRuralDistrict;

    protected $table = 'iran_villages';

    /**
     * @inheritdoc
     */
    protected function getReferenceKey()
    {
        return 'village_id';
    }
}
