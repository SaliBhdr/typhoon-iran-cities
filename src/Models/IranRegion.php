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
 * @property int province_id
 * @property int county_id
 * @property int sector_id
 * @property int city_id
 * @property int rural_district_id
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

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class, $this->getReferenceKey());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(static::class, $this->getReferenceKey());
    }
    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(static::class, 'province_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function county()
    {
        return $this->belongsTo(static::class, 'county_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sector()
    {
        return $this->belongsTo(static::class, 'sector_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(static::class, 'city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ruralDistrict()
    {
        return $this->belongsTo(static::class, 'rural_district_id');
    }

}
