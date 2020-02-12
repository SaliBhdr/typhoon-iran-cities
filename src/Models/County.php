<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $fillable=['province_id','name'];

    public function province(){

        return $this->belongsTo(Province::class,'province_id');
    }
}
