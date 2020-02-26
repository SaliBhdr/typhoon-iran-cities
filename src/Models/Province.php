<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SaliBhdr\TyphoonIranCities\useActiveField;

class Province extends Model
{
    use useActiveField;

    protected $fillable = ['name'];

    /**
     * province has many cities
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'province_id');
    }

    /**
     * province has many counties
     */
    public function counties()
    {
        return $this->hasMany(County::class, 'province_id');
    }

}
