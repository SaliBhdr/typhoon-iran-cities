<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Traits\HasCities;
use SaliBhdr\TyphoonIranCities\Traits\HasSectors;
use SaliBhdr\TyphoonIranCities\Traits\HasVillages;
use SaliBhdr\TyphoonIranCities\Traits\HasCityDistricts;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToProvince;
use SaliBhdr\TyphoonIranCities\Traits\HasRuralDistricts;

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
