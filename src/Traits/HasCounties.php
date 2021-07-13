<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCounty;

trait HasCounties
{
    /**
     * Province has many counties
     * @return \Illuminate\Database\Eloquent\Builder|\SaliBhdr\TyphoonIranCities\Models\BaseIranModel
     */
    public function counties()
    {
        return $this->hasMany(IranCounty::class, $this->getReferenceKey());
    }

    /**
     * @return IranCounty[]\Illuminate\Database\Eloquent\Collection
     */
    public function getCounties()
    {
        return $this->counties()->get();
    }

    /**
     * @return IranCounty[]\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveCounties()
    {
        return $this->counties()->active()->get();
    }

    /**
     * @return IranCounty[]\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveCounties()
    {
        return $this->counties()->notActive()->get();
    }

}
