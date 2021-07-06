<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use SaliBhdr\TyphoonIranCities\Traits\HasStatusField;

class IranSector extends Model
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
     * Sector belongs to province
     */
    public function province()
    {
        return $this->belongsTo(IranProvince::class);
    }

    /**
     * Sector belongs to a county
     */
    public function county()
    {
        return $this->belongsTo(IranCounty::class);
    }

    /**
     * Sector has many cities
     */
    public function cities()
    {
        return $this->hasMany(IranCity::class);
    }

    /**
     * Sector has many city districts
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
     * @return IranCounty
     */
    public function getCounty()
    {
        return $this->county()->first();
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
