<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCity;

trait HasCities
{
    /**
     * Sector has many cities
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function cities()
    {
        return $this->hasMany(IranCity::class, $this->getReferenceKey());
    }

    /**
     * @return IranCity[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCities()
    {
        return $this->cities()->orderBy('id','ASC')->get();
    }

    /**
     * @return IranCity[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveCities()
    {
        return $this->cities()->active()->orderBy('id','ASC')->get();
    }

    /**
     * @return IranCity[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveCities()
    {
        return $this->cities()->notActive()->orderBy('id','ASC')->get();
    }
}
