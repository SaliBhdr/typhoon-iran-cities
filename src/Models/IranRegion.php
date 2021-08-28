<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use SaliBhdr\TyphoonIranCities\Traits\BelongsToCounty;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToSector;
use SaliBhdr\TyphoonIranCities\Traits\HasCityDistricts;
use SaliBhdr\TyphoonIranCities\Traits\BelongsToProvince;

/**
 * @property int id
 * @property string $type
 * @property int parent_id
 *
 * Class IranRegion (all regions/ Manategh)
 */
class IranRegion extends BaseIranModel
{
    /**
     * @inheritdoc
     */
    protected function getReferenceKey()
    {
        return 'parent_id';
    }

    public function parent()
    {
        return $this->belongsTo(static::class, $this->getReferenceKey());
    }

    public function children()
    {
        return $this->hasMany(static::class, $this->getReferenceKey());
    }
}
