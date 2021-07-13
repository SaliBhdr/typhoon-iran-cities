<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCounty;

trait BelongsToCounty
{
    /**
     * city belongs to a county
     * @return \Illuminate\Database\Eloquent\Builder|\SaliBhdr\TyphoonIranCities\Models\BaseIranModel|IranCounty
     */
    public function county()
    {
        return $this->belongsTo(IranCounty::class, 'county_id');
    }

    /**
     * @return IranCounty
     */
    public function getCounty()
    {
        return $this->county()->first();
    }
}
