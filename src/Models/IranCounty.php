<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use SaliBhdr\TyphoonIranCities\Traits\HasStatusField;

class IranCounty extends Model
{
    use HasStatusField;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * County belongs to province
     */
    public function province()
    {
        return $this->belongsTo(IranProvince::class);
    }

    /**
     * County has many sectors
     */
    public function sectors()
    {
        return $this->hasMany(IranSector::class);
    }

    /**
     * County has many cities
     */
    public function cities()
    {
        return $this->hasMany(IranCity::class);
    }

    /**
     * County has many city districts
     */
    public function cityDistricts()
    {
        return $this->hasMany(IranCityDistrict::class);
    }

    /**
     * @return IranProvince
     */
    public function getProvince()
    {
        return $this->province()->first();
    }

    /**
     * @return IranSector[]|Collection
     */
    public function getSectors()
    {
        return $this->sectors()->get();
    }

    /**
     * @return IranSector[]|Collection
     */
    public function getActiveSectors()
    {
        return $this->sectors()->active()->get();
    }

    /**
     * @return IranSector[]|Collection
     */
    public function getNotActiveSectors()
    {
        return $this->sectors()->notActive()->get();
    }

    /**
     * @return IranCity[]|Collection
     */
    public function getCities()
    {
        return $this->cities()->get();
    }

    /**
     * @return IranCity[]|Collection
     */
    public function getActiveCities()
    {
        return $this->cities()->active()->get();
    }

    /**
     * @return IranCity[]|Collection
     */
    public function getNotActiveCities()
    {
        return $this->cities()->notActive()->get();
    }

    /**
     * @return IranCityDistrict[]|Collection
     */
    public function getCityDistricts()
    {
        return $this->cityDistricts()->get();
    }

    /**
     * @return IranCityDistrict[]|Collection
     */
    public function getActiveCityDistricts()
    {
        return $this->cityDistricts()->active()->get();
    }

    /**
     * @return IranCityDistrict[]|Collection
     */
    public function getNotActiveCityDistricts()
    {
        return $this->cityDistricts()->notActive()->get();
    }
}
