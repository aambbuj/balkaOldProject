<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $fillable = [
    //     'order_id','product_id','total_amount','qty','status','deleted','created_by','updated_by',
    // ];
}
