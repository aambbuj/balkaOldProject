<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromisingPick extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo('GeoAlgo\Products\Models\Product','product_id','id');
    }
}
