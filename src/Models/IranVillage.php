<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToSector;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToProvince;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToRuralDistrict;

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
