<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranSector;

trait HasSectors
{
    /**
     * Province has many sectors
     * @return \Illuminate\Database\Eloquent\Builder|\SaliBhdr\TyphoonIranCities\Models\BaseIranModel
     */
    public function sectors()
    {
        return $this->hasMany(IranSector::class, $this->getReferenceKey());
    }

    /**
     * @return IranSector[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getSectors()
    {
        return $this->sectors()->get();
    }

    /**
     * @return IranSector[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveSectors()
    {
        return $this->sectors()->active()->get();
    }

    /**
     * @return IranSector[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getNotActiveSectors()
    {
        return $this->sectors()->notActive()->get();
    }

}
