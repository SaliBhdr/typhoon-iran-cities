<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranRuralDistrict;

trait HasRuralDistricts
{
    /**
     * Sector has many rural districts
     * @return \Illuminate\Database\Eloquent\Builder|\SaliBhdr\TyphoonIranCities\Models\BaseIranModel
     */
    public function ruralDistricts()
    {
        return $this->hasMany(IranRuralDistrict::class, $this->getReferenceKey());
    }

    /**
     * @return IranRuralDistrict[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRuralDistricts()
    {
        return $this->ruralDistricts()->orderBy('id','ASC')->get();
    }

    /**
     * @return IranRuralDistrict[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveRuralDistricts()
    {
        return $this->ruralDistricts()->active()->orderBy('id','ASC')->get();
    }

    /**
     * @return IranRuralDistrict[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveRuralDistricts()
    {
        return $this->ruralDistricts()->notActive()->orderBy('id','ASC')->get();
    }
}
