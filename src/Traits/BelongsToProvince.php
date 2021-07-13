<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranProvince;

trait BelongsToProvince
{
    /**
     * city belongs to a province
     */
    public function province()
    {
        return $this->belongsTo(IranProvince::class, 'province_id');
    }

    /**
     * @return IranProvince
     */
    public function getProvince()
    {
        return $this->province()->first();
    }
}
