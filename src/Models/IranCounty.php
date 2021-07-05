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
class IranCounty extends Model
{
    use HasStatusField;

    protected $fillable = ['province_id', 'name'];

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
     * County has many cities
     */
    public function cities()
    {
        return $this->hasMany(IranCity::class);
    }

    /**
     * @return IranCounty[]|Collection
     */
    public static function getAll()
    {
        return static::all();
    }

    /**
     * @return IranCounty[]|Collection
     */
    public static function getAllActive()
    {
        return static::active()->get();
    }

    /**
     * @return IranCounty[]|Collection
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
