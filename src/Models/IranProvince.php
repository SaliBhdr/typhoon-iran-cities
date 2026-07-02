<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Models\Traits\HasCities;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasSectors;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasVillages;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasCounties;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasCityDistricts;
use SaliBhdr\TyphoonIranCities\Models\Traits\HasRuralDistricts;

/**
 * Class IranProvince (Ostan)
 */
class IranProvince extends BaseIranModel
{
    use HasCounties, HasSectors, HasCities, HasCityDistricts, HasRuralDistricts, HasVillages;

    protected $table = 'iran_provinces';

    /**
     * @return string
     */
    protected function getReferenceKey()
    {
        return 'province_id';
    }
}
