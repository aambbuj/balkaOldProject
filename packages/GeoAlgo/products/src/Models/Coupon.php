<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

   // protected $table = 'coupons';

    public function coupons(){
        return $this->hasMany(coupon_vendor::class , 'coupon_id' , 'id');
    }
}
