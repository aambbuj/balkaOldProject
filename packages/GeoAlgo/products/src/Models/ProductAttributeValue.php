<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function attributes(){
        return $this->belongsTo(Attribute::class ,'attribute_id' ,'id');
    }
    
    public function attributeValues(){
        return $this->belongsTo(AttributeValue::class ,'attribute_value_id' ,'id');
    }

    // public function attributeValue(){
    //     return $this->belongsToMany(Category::class,ProductCategory::class,'product_id','category_id');
    // }

    public function product(){
        return $this->hasOne(Product::class ,'id' ,'product_id');
    }

    public function attribute(){
        return $this->hasMany(Attribute::class ,'id' ,'attribute_id');
    }

    public function values(){
        return $this->hasMany(AttributeValue::class ,'id' ,'attribute_value_id');
    }


}


