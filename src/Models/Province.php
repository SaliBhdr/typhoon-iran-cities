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
class Province extends Model
{
    use HasStatusField;

    protected $fillable = ['name'];

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
        return $this->hasMany(City::class);
    }

    /**
     * province has many counties
     */
    public function counties()
    {
        return $this->hasMany(County::class);
    }

    /**
     * @return Province[]|Collection
     */
    public static function getAll()
    {
        return static::all();
    }

    /**
     * @return Province[]|Collection
     */
    public static function getAllActive()
    {
        return static::active()->all();
    }

    /**
     * @return Province[]|Collection
     */
    public static function getAllNotActive()
    {
        return static::notActive()->all();
    }

    /**
     * @return County[]|Collection
     */
    public function getCounties()
    {
        return $this->counties()->get();
    }

    /**
     * @return County[]|Collection
     */
    public function getActiveCounties()
    {
        return $this->counties()->active()->get();
    }

    /**
     * @return County[]|Collection
     */
    public function getNotActiveCounties()
    {
        return $this->counties()->notActive()->get();
    }

    /**
     * @return City[]|Collection
     */
    public function getCities()
    {
        return $this->cities()->get();
    }

    /**
     * @return City[]|Collection
     */
    public function getActiveCities()
    {
        return $this->cities()->active()->get();
    }

    /**
     * @return City[]|Collection
     */
    public function getNotActiveCities()
    {
        return $this->cities()->notActive()->get();
    }

}
