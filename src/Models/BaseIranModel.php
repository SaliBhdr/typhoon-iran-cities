<?php
namespace SaliBhdr\TyphoonIranCities\Models;

use Illuminate\Database\Eloquent\Model;
use SaliBhdr\TyphoonIranCities\Traits\HasStatusField;

/**
 * @property string $name
 * @property string $code
 * Class BaseIranModel
 * @package SaliBhdr\TyphoonIranCities\Models
 */
abstract class BaseIranModel extends Model
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
     * @return self[]\Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return static::all();
    }

    /**
     * @return self[]\Illuminate\Database\Eloquent\Collection
     */
    public static function getAllActive()
    {
        return static::active()->get();
    }

    /**
     * @return self[]\Illuminate\Database\Eloquent\Collection
     */
    public static function getAllNotActive()
    {
        return static::notActive()->get();
    }

    /**
     * @return string
     */
    abstract protected function getReferenceKey();
}
