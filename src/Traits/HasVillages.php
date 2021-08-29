<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranVillage;

trait HasVillages
{
    /**
     * rural district has many districts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function villages()
    {
        return $this->hasMany(IranVillage::class, $this->getReferenceKey());
    }

    /**
     * @return IranVillage[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getVillages()
    {
        return $this->villages()->orderBy('id','ASC')->get();
    }

    /**
     * @return IranVillage[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveVillages()
    {
        return $this->villages()->active()->orderBy('id','ASC')->get();
    }

    /**
     * @return IranVillage[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveVillages()
    {
        return $this->villages()->notActive()->orderBy('id','ASC')->get();
    }
}
