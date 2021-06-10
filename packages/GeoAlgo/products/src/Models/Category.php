<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GeoAlgo\Products\Models\CategoryRelation;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subcategory(){

        return $this->hasMany(Category::class, 'parent_id');
    }
    public function childrenCategories()
    {
        return $this->hasMany(CategoryRelation::class, 'parent_id');
    }


    // public function childrenCategories()
    // {
    //     return $this->hasMany(CategoryRelation::class, 'parent_id');
    // }

    public function getParentCategories()
    {
        return $this->hasMany(CategoryRelation::class, 'category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class,'parent_id')->with('childrenCategories');
    }


    public function sub_categories()
    {
        return $this->hasMany(Category::class,'parent_id')->with('childrenCategory');
    }

    public function childrenCategory()
    {
        return $this->hasMany(Category::class,'parent_id');
    }


    public function products(){

        return $this->belongsToMany(Product::class,ProductCategory::class,'category_id','product_id');
        //return $this->belongsToMany(Product::class,Order_details::class,'order_id', 'product_id')->withPivot('total_amount', 'qty','status','deleted');;
    }

    public function detail_name(){
        return "Hello";
    }
}
