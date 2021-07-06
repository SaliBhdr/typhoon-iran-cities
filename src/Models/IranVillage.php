<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use SaliBhdr\TyphoonIranCities\Traits\HasStatusField;

/**
 * Class IranVillage (Abadi)
 * @package App
 */
class IranVillage extends Model
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
     * village belongs to a province
     */
    public function province()
    {
        return $this->belongsTo(IranProvince::class);
    }

    /**
     * village belongs to a county
     */
    public function county()
    {
        return $this->belongsTo(IranCounty::class);
    }

    /**
     * village belongs to a county
     */
    public function sector()
    {
        return $this->belongsTo(IranSector::class);
    }

    /**
     * village belongs to a rural district
     */
    public function ruralDistrict()
    {
        return $this->belongsTo(IranRuralDistrict::class);
    }

    /**
     * @return self[]|Collection
     */
    public static function getAll()
    {
        return static::all();
    }

    /**
     * @return self[]|Collection
     */
    public static function getAllActive()
    {
        return static::active()->get();
    }

    /**
     * @return self[]|Collection
     */
    public static function getAllNotActive()
    {
        return static::notActive()->get();
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
     * @return IranSector
     */
    public function getSector()
    {
        return $this->sector()->first();
    }

    /**
     * @return IranRuralDistrict
     */
    public function getRuralDistrict()
    {
        return $this->ruralDistrict()->first();
    }

}
