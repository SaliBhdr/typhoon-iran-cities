<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranRuralDistrict;

trait HasRuralDistricts
{
    /**
     * Sector has many rural districts
     */
    public function ruralDistricts()
    {
        return $this->hasMany(IranRuralDistrict::class, $this->getReferenceKey());
    }

    /**
     * @return IranRuralDistrict[]\Illuminate\Database\Eloquent\Collection
     */
    public function getRuralDistricts()
    {
        return $this->ruralDistricts()->get();
    }

    /**
     * @return IranRuralDistrict[]\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveRuralDistricts()
    {
        return $this->ruralDistricts()->active()->get();
    }

    /**
     * @return IranRuralDistrict[]\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveRuralDistricts()
    {
        return $this->ruralDistricts()->notActive()->get();
    }
}
