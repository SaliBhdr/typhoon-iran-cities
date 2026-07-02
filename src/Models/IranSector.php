<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Models\Traits\HasCities;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasVillages;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasCityDistricts;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasRuralDistricts;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToProvince;

/**
 * Class IranSector (Bakhsh)
 */
class IranSector extends BaseIranModel
{
    use BelongsToProvince, BelongsToCounty, HasCities, HasCityDistricts, HasRuralDistricts, HasVillages;

    protected $table = 'iran_sectors';

    /**
     * @inheritdoc
     */
    protected function getReferenceKey()
    {
        return 'sector_id';
    }
}
