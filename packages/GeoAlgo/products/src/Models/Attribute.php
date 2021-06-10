<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }


    public function value()
    {
        return $this->hasMany(AttributeValue::class)
        ->where('id',157);
    }
}