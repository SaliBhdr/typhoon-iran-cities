<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCity;

trait BelongsToCity
{
    /**
     * city district belongs to a county
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
