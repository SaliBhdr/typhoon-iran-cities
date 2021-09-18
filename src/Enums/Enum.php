<?php

namespace SaliBhdr\TyphoonIranCities\Enums;

use League\Flysystem\NotSupportedException;
use ReflectionClass;

/**
 * Class Gender
 *
 * @package \App\Constants
 */
abstract class Enum
{


    /**
     * Enum constructor.
     */
     private function __construct()
    {
        throw new NotSupportedException(); //
    }

    /**
     *
     */
     private function __clone()
    {
        throw new NotSupportedException();
    }

    /**
     * @return array
     */
     public static function toArray(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    /**
     * @param $value
     *
     * @return bool
     */
     public static function isValid($value): bool
    {
        return in_array($value, static::toArray());
    }

}
