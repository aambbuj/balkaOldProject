<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class CategoryRelation extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    // public function parentCategories()
    // {
    //     // return $this->hasMany('GeoAlgo\Products\Models\Category', 'id', 'category_id');
    //     // return $this->hasMany
    // }

    public function getName(){
        return $this->hasOne(Category::class, "id", "category_id");
    }

    public function getType(){
        return $this->hasOne(Category::class, "id", "type_id");
    }

    // parent
    public function parent()
    {
       $query =  $this->belongsTo(CategoryRelation::class,'category_parent_id')->with('getName');
       return $query;
    }

    public function attributeValue(){
        return $this->hasMany(CategoryAttributeValue::class, ["category_id", "category_parent_id", "type_id"], ["category_id", "category_parent_id", "type_id"])->where("deleted", 0)->where("gallery_mandatory", 1)->with("getAttributeName")->with("getAttributeValueName");
    }

    public function attributeNonValue(){
        return $this->hasMany(CategoryAttributeValue::class, ["category_id", "category_parent_id", "type_id"], ["category_id", "category_parent_id", "type_id"])->where("deleted", 0)->where("gallery_mandatory", 0)->with("getAttributeName")->with("getAttributeValueName");
    }

    // all ascendants
    public function parentRecursive()
    {
       return $this->parent()->with('parentRecursive');
    }


    public function recursiveVariation()
    {
        return $this->parent()->with("attributeValue")->with("recursiveVariation");        
    }

    public function recursiveAttribution()
    {
        return $this->parent()->with("attributeNonValue")->with("recursiveAttribution");        
    }

    public function getParentDataAttribute(){
        
    }

//     public function getAttrValueAttribute(){

    public function children()
    {
       $query =  $this->hasMany(CategoryRelation::class,'category_parent_id')->with('getName');
       return $query;
    }

    // all ascendants
    public function childRecursive()
    {
       return $this->children()->with('childRecursive');
    }

}
