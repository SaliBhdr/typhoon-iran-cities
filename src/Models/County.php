<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SaliBhdr\TyphoonIranCities\useActiveField;

class County extends Model
{
    use useActiveField;

    protected $fillable = ['province_id', 'name'];

    /**
     * County belongs to province
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

}
