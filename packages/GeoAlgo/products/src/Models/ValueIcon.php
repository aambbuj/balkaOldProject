<?php

namespace GeoAlgo\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValueIcon extends Model
{
    use HasFactory;

    public function getCategoryAttribute(){
        $categories = CategoryRelation::whereIn("id", explode(",", $this->category_id))->with("parentRecursive")->with("getName")->with("getType")->get();
        $categories_list = array();
        foreach($categories as $key=>$value){
            $data = $value->toArray();
            $checkStr = $data["get_name"]["name"];
            if($data["parent_recursive"] != null){
                array_walk_recursive($data["parent_recursive"], function($a, $b) use(&$checkStr){
                    if($b == "name"){
                        $checkStr = $checkStr . " - " . $a;
                    }
                });
            }
            $checkStr = $checkStr . " - " . $data["get_type"]["name"];
            $categories_list[] = $checkStr;
        }
        return implode("<b>,</b> ", $categories_list);
    }

    public function getCategoryArrayAttribute(){
        $categories = CategoryRelation::whereIn("id", explode(",", $this->category_id))->with("parentRecursive")->with("getName")->with("getType")->get();
        $categories_list = array();
        foreach($categories as $key=>$value){
            $data = $value->toArray();
            $checkStr = $data["get_name"]["name"];
            if($data["parent_recursive"] != null){
                array_walk_recursive($data["parent_recursive"], function($a, $b) use(&$checkStr){
                    if($b == "name"){
                        $checkStr = $checkStr . " - " . $a;
                    }
                });
            }
            $checkStr = $checkStr . " - " . $data["get_type"]["name"];
            $categories_list[] = array("id"=> $data["id"], "text"=> $checkStr);
        }
        return $categories_list;
    }
}
