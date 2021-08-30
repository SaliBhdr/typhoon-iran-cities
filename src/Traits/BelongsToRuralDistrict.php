<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranRuralDistrict;

/**
 * @property int $rural_district_id
 */
trait BelongsToRuralDistrict
{
    /**
     * village belongs to a rural district
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
