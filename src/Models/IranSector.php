<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Traits\HasCities;
use SaliBhdr\TyphoonIranCities\Traits\HasVillages;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Traits\HasCityDistricts;
use SaliBhdr\TyphoonIranCities\Traits\HasRuralDistricts;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToProvince;

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
