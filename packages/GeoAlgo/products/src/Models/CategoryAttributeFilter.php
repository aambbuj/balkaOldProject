<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAttributeFilter extends Model
{
    use HasFactory;

    public function parentCategoryDetail(){
        return $this->hasOne(CategoryRelation::class, "id", "category_parent_id");
    }

    public function getAttributeName(){
        return $this->hasOne(Attribute::class, "id", "attribute_id");
    }

    public function getType(){
        return $this->hasOne(Category::class, "id", "type_id");
    }
}
