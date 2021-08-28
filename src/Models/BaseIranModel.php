<?php

namespace SaliBhdr\TyphoonIranCities\Models;

use Illuminate\Database\Eloquent\Model;
use SaliBhdr\TyphoonIranCities\Traits\HasStatusField;

/**
 * @property int $id
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
        'code'   => 'string',
    ];

    /**
     * @return self[]\Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return static::query()->orderBy('id', 'ASC')->get();
    }

    /**
     * @return self[]\Illuminate\Database\Eloquent\Collection
     */
    public static function getAllActive()
    {
        return static::active()->orderBy('id', 'ASC')->get();
    }

    /**
     * @return self[]\Illuminate\Database\Eloquent\Collection
     */
    public static function getAllNotActive()
    {
        return static::notActive()->orderBy('id', 'ASC')->get();
    }

    /**
     * @return string
     */
    abstract protected function getReferenceKey();
}
