<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranVillage;

trait HasVillages
{
    /**
     * rural district has many districts
     */
    public function villages()
    {
        return $this->hasMany(IranVillage::class, $this->getReferenceKey());
    }

    /**
     * @return IranVillage[]\Illuminate\Database\Eloquent\Collection
     */
    public function getVillages()
    {
        return $this->villages()->get();
    }

    /**
     * @return IranVillage[]\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveVillages()
    {
        return $this->villages()->active()->get();
    }

    /**
     * @return IranVillage[]\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveVillages()
    {
        return $this->villages()->notActive()->get();
    }
}
