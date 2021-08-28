<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranSector;

/**
 * @property int $sector_id
 */
trait BelongsToSector
{
    /**
     * city belongs to a county
     * @return \Illuminate\Database\Eloquent\Builder|\SaliBhdr\TyphoonIranCities\Models\BaseIranModel|IranSector
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
