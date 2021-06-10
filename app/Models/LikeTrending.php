<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeTrending extends Model
{
    use HasFactory;

    public function products(){

        return $this->belongsToMany('GeoAlgo\Products\Models\Product','App\Models\LikeTrendingProduct','like_trending_id','product_id');


        //return $this->belongsToMany(Product::class,Order_details::class,'order_id', 'product_id')->withPivot('total_amount', 'qty','status','deleted');;

    }
}
