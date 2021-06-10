<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeakoutBrand extends Model
{
    use HasFactory;

    public function brand()
    {
        return $this->belongsTo('GeoAlgo\Products\Models\Brand','brand_id','id');
    }
}
