<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCityDistrict;

trait HasCityDistricts
{
    /**
     * city has many city districts
     * @return \Illuminate\Database\Eloquent\Builder|\SaliBhdr\TyphoonIranCities\Models\BaseIranModel
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
        return $this->cityDistricts()->get();
    }

    /**
     * @return IranCityDistrict[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveCityDistricts()
    {
        return $this->cityDistricts()->active()->get();
    }

    /**
     * @return IranCityDistrict[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveCityDistricts()
    {
        return $this->cityDistricts()->notActive()->get();
    }
}
