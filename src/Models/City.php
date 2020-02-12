<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable=['province_id','county_id','name'];

    public function province(){

        return $this->belongsTo(Province::class,'province_id');
    }

    public function county(){

        return $this->belongsTo(County::class,'county_id');
    }
}
