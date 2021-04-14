<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use SaliBhdr\TyphoonIranCities\HasStatusField;

/**
 * @property int $province_id
 * @property string $name
 * @property bool $status
 * Class County
 * @package App
 */
class County extends Model
{
    use HasStatusField;

    protected $fillable = ['province_id', 'name'];

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
        return $this->belongsTo(Province::class);
    }

    /**
     * County has many cities
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * @return County[]|Collection
     */
    public static function getAll()
    {
        return static::all();
    }

    /**
     * @return County[]|Collection
     */
    public static function getAllActive()
    {
        return static::active()->get();
    }

    /**
     * @return County[]|Collection
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
