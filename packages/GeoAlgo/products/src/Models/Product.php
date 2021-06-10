<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories(){
        return $this->belongsToMany(Category::class,ProductCategory::class,'product_id','category_id');
    }


    public function images(){

    	return $this->hasMany(ProductImage::class);
    }

    public function item(){

    	return $this->hasOne(Item::class);
    }

    public function brand()
    {
        return $this->belongsTo('GeoAlgo\Products\Models\Brand','brand_id','id');
    }



}
