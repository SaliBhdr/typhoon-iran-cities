<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use SaliBhdr\TyphoonIranCities\HasStatusField;

/**
 * @property int $province_id
 * @property int $county_id
 * @property string name
 * @property bool $status
 * Class City
 * @package App
 */
class City extends Model
{
    use HasStatusField;

    protected $fillable = ['province_id', 'county_id', 'name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * city belongs to a province
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * city belongs to a county
     */
    public function county()
    {
        return $this->belongsTo(County::class);
    }

    /**
     * @return City[]|Collection
     */
    public static function getAll()
    {
        return static::all();
    }

    /**
     * @return City[]|Collection
     */
    public static function getAllActive()
    {
        return static::active()->get();
    }

    /**
     * @return City[]|Collection
     */
    public static function getAllNotActive()
    {
        return static::notActive()->get();
    }

    /**
     * @return Province
     */
    public function getProvince()
    {
        return $this->province()->first();
    }

    /**
     * @return County
     */
    public function getCounty()
    {
        return $this->county()->first();
    }
}
