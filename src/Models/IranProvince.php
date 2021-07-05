<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use SaliBhdr\TyphoonIranCities\HasStatusField;

/**
 * @property string $name
 * @property bool $status
 * Class Province
 * @package App
 */
class IranProvince extends Model
{
    use HasStatusField;

    protected $fillable = ['name'];

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
     * province has many cities
     */
    public function cities()
    {
        return $this->hasMany(IranCity::class);
    }

    /**
     * province has many counties
     */
    public function counties()
    {
        return $this->hasMany(IranCounty::class);
    }

    /**
     * @return IranProvince[]|Collection
     */
    public static function getAll()
    {
        return static::all();
    }

    /**
     * @return IranProvince[]|Collection
     */
    public static function getAllActive()
    {
        return static::active()->get();
    }

    /**
     * @return IranProvince[]|Collection
     */
    public static function getAllNotActive()
    {
        return static::notActive()->get();
    }

    /**
     * @return IranCounty[]|Collection
     */
    public function getCounties()
    {
        return $this->counties()->get();
    }

    /**
     * @return IranCounty[]|Collection
     */
    public function getActiveCounties()
    {
        return $this->counties()->active()->get();
    }

    /**
     * @return IranCounty[]|Collection
     */
    public function getNotActiveCounties()
    {
        return $this->counties()->notActive()->get();
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

}
