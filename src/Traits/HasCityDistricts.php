<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCityDistrict;

trait HasCityDistricts
{
    /**
     * city has many city districts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cityDistricts()
    {
        return $this->hasMany(IranCityDistrict::class, $this->getReferenceKey());
    }

    /**
     * @return IranCityDistrict[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCityDistricts()
    {
        return $this->cityDistricts()->orderBy('id','ASC')->get();
    }

    /**
     * @return IranCityDistrict[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveCityDistricts()
    {
        return $this->cityDistricts()->active()->orderBy('id','ASC')->get();
    }

    /**
     * @return IranCityDistrict[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveCityDistricts()
    {
        return $this->cityDistricts()->notActive()->orderBy('id','ASC')->get();
    }
}
