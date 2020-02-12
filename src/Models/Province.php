<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable=['name'];


    public function cities(){

        return $this->hasMany(City::class,'province_id');
    }

    public function counties(){

        return $this->hasMany(County::class,'province_id');
    }
}
