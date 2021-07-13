<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranSector;

trait BelongsToSector
{
    /**
     * city belongs to a county
     */
    public function sector()
    {
        return $this->belongsTo(IranSector::class, 'sector_id');
    }

    /**
     * @return IranSector
     */
    public function getSector()
    {
        return $this->sector()->first();
    }
}
