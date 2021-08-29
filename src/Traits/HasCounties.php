<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCounty;

trait HasCounties
{
    /**
     * Province has many counties
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function counties()
    {
        return $this->hasMany(IranCounty::class, $this->getReferenceKey());
    }

    /**
     * @return IranCounty[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCounties()
    {
        return $this->counties()->orderBy('id','ASC')->get();
    }

    /**
     * @return IranCounty[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveCounties()
    {
        return $this->counties()->active()->orderBy('id','ASC')->get();
    }

    /**
     * @return IranCounty[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveCounties()
    {
        return $this->counties()->notActive()->orderBy('id','ASC')->get();
    }

}
