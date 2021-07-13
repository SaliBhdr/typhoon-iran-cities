<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Traits\HasCities;
use SaliBhdr\TyphoonIranCities\Traits\HasSectors;
use SaliBhdr\TyphoonIranCities\Traits\HasVillages;
use SaliBhdr\TyphoonIranCities\Traits\HasCounties;
use SaliBhdr\TyphoonIranCities\Traits\HasCityDistricts;
use SaliBhdr\TyphoonIranCities\Traits\HasRuralDistricts;

/**
 * Class IranProvince (Ostan)
 */
class IranProvince extends BaseIranModel
{
    use HasCounties, HasSectors, HasCities, HasCityDistricts, HasRuralDistricts, HasVillages;

    /**
     * @return string
     */
    protected function getReferenceKey()
    {
        return 'province_id';
    }
}
