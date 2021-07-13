<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranRuralDistrict;

trait BelongsToRuralDistrict
{
    /**
     * village belongs to a rural district
     */
    public function ruralDistrict()
    {
        return $this->belongsTo(IranRuralDistrict::class, 'rural_district_id');
    }

    /**
     * @return IranRuralDistrict
     */
    public function getRuralDistrict()
    {
        return $this->ruralDistrict()->first();
    }
}
