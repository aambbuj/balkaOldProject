<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAttributeValue extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    protected $guarded = [];

    public function attributValueProduct()
    {
        return $this->belongsToMany(Category::class,ProductCategory::class,'product_id','category_id');
    }

    public function attributs()
    {
        return $this->hasOne(Attribute::class,'id','attribute_id')->with('values');
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class,'id','attribute_value_id');
    }

    public function parentCategoryDetail(){
        return $this->hasOne(CategoryRelation::class, "id", "category_parent_id");
    }

    public function getAttributeName(){
        return $this->hasOne(Attribute::class, "id", "attribute_id");
    }

    public function getAttributeValueName(){
        return $this->hasOne(AttributeValue::class, "id", "attribute_value_id");
    }

    public function getType(){
        return $this->hasOne(Category::class, "id", "type_id");
    }
}

