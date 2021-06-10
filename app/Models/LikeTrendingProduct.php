<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeTrendingProduct extends Model
{
    use HasFactory;

    public function product(){

        return $this->belongsTo('GeoAlgo\Products\Models\Product','product_id','id');


        //return $this->belongsToMany(Product::class,Order_details::class,'order_id', 'product_id')->withPivot('total_amount', 'qty','status','deleted');;

    }
}
