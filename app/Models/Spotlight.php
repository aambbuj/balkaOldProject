<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spotlight extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo('GeoAlgo\Products\Models\Category','category_id','id');
    }

    public function products(){

        return $this->belongsToMany('GeoAlgo\Products\Models\Product','App\Models\SpotlightProduct','category_id','product_id');


        //return $this->belongsToMany(Product::class,Order_details::class,'order_id', 'product_id')->withPivot('total_amount', 'qty','status','deleted');;

    }
}
