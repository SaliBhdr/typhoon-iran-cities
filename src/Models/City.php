<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SaliBhdr\TyphoonIranCities\HasStatusField;

class City extends Model
{
    use HasStatusField;

    protected $fillable = ['province_id', 'county_id', 'name'];

    /**
     * city belongs to a province
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * city belongs to a county
     */
    public function county()
    {
        return $this->belongsTo(County::class, 'county_id');
    }

}
