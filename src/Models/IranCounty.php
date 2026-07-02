<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Models\Traits\HasCities;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasSectors;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasVillages;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasCityDistricts;
use SaliBhdr\TyphoonIranCities\Models\Traits\BelongsToProvince;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasRuralDistricts;

/**
 * Class IranCounty (Shahrestan)
 */
class IranCounty extends BaseIranModel
{
    use BelongsToProvince, HasSectors, HasCities, HasCityDistricts, HasRuralDistricts, HasVillages;

    protected $table = 'iran_counties';

    /**
     * @inheritdoc
     */
    protected function getReferenceKey()
    {
        return 'county_id';
    }
}
