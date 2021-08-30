<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCity;

/**
 * @property int $city_id
 */
trait BelongsToCity
{
    /**
     * city district belongs to a county
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(IranCity::class, 'city_id');
    }

    /**
     * @return IranCity
     */
    public function getCity()
    {
        return $this->city()->first();
    }
}
