<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranProvince;

/**
 * @property int $province_id
 */
trait BelongsToProvince
{
    /**
     * city belongs to a province
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
