<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $fillable = [
    //     'customer_id','company_id','payment_id','user_id','shipper_id','order_number','order_date','ship_date','required_date',
    //     'payment_date','total_amount','sell_tex','transact_status','status','deleted','created_by','updated_by',
    // ];
    
    public function details(){
        return $this->belongsToMany(Product::class,Order_details::class,'order_id', 'product_id')->withPivot('total_amount', 'qty','status','deleted');
    }

    public function orderDetails(){
        return $this->hasMany(Order_details::class,'order_id', 'id');
    }

    public function products(){
        return $this->hasOne(Product::class,'id', 'product_id');
    }

    public function bars(){
        return $this->hasOne(Company::class,'id','company_id');
    }
}
