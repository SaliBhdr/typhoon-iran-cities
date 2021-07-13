<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCity;

trait HasCities
{
    /**
     * Sector has many cities
     */
    public function cities()
    {
        return $this->hasMany(IranCity::class, $this->getReferenceKey());
    }

    /**
     * @return IranCity[]\Illuminate\Database\Eloquent\Collection
     */
    public function getCities()
    {
        return $this->cities()->get();
    }

    /**
     * @return IranCity[]\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveCities()
    {
        return $this->cities()->active()->get();
    }

    /**
     * @return IranCity[]\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveCities()
    {
        return $this->cities()->notActive()->get();
    }
}
