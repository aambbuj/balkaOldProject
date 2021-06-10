<?php

namespace GeoAlgo\Products\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use GeoAlgo\Products\Exports\Sheets\ProductTypeSheet;
use GeoAlgo\Products\Models\CategoryRelation;
use Log;

class ExportProductSheet implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        try{
            $children = CategoryRelation::where("type_id", 4)->whereNotNull("category_parent_id")->with("getName")->with("parentRecursive")->get()->toArray();
            $sheets = [];
            foreach($children as $key => $value){
                $strr = $value["get_name"]["name"];
                if($value["parent_recursive"] != null){
                    array_walk_recursive($value["parent_recursive"], function($a, $b) use(&$strr){
                        if($b == "name"){
                            $strr = $strr . " - " . $a;
                        }
                    });
                }
                $sheets[] = new ProductTypeSheet($strr, $value["id"]);
            }
            return $sheets;
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
    }
}
