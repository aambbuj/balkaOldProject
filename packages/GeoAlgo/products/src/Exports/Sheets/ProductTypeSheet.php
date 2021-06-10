<?php

namespace GeoAlgo\Products\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use GeoAlgo\Products\Models\CategoryRelation;
use Log;

class ProductTypeSheet implements FromCollection, WithTitle, WithStyles
{
    private $month;

    public function __construct($month, $id)
    {
        $this->month = $month;
        $this->rel_id = $id;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => false, 'italic' => false, 'size' => 12]],
        ];
    }

    /**
     * @return Builder
     */
    public function collection()
    {
        $static_field = ['Name', 'SKU', 'Product Description', 'Short Description', 'Featured Image', 'Gallery Images', 'Value Icons', 'HSN Code', 'Stok Status', 'Stock Quantity', 'Low Stock Threshold', 'Weight (g)', 'Length (cm)', 'Width (cm)', 'Height (cm)', 'Delivery Timeline', 'Linked Product SKU', 'Parent SKU', ];

        //attribution
        $listingss = CategoryRelation::where("category_relations.deleted", 0)->where("category_relations.id", $this->rel_id)->with("attributeNonValue")->with("recursiveAttribution")->get()->toArray();
        // Log::error($listingss);
        $lists = array();
        $check = array();
        array_walk_recursive_array($listingss, function($a, $b) use(&$lists, &$check){              
          if($b === "attribute_non_value"){
            foreach($a as $key=>$value){
                if(!in_array($value["attribute_id"], $check)){
                    $lists[] = $value["get_attribute_name"]["name"];
                    $check[] = $value["attribute_id"];
                }
            //   if(!isset($lists[$value["attribute_id"]])){
            //     $lists[$value["attribute_id"]] = array();
            //     $lists[$value["attribute_id"]]["name"] = $value["get_attribute_name"]["name"];
            //     $lists[$value["attribute_id"]]["mandatory"] = $value["mandatory"];
            //   }
            //   $lists[$value["attribute_id"]][$value["attribute_value_id"]] = $value["get_attribute_value_name"]["value"];
            }
          }
        });

        $listss = array();
        $checks = array();
        $listings = CategoryRelation::where("category_relations.deleted", 0)->where("category_relations.id", $this->rel_id)->with("attributeValue")->with("recursiveVariation")->get()->toArray();
        array_walk_recursive_array($listings, function($a, $b) use(&$listss, &$checks){
            if($b === "attribute_value"){
                foreach($a as $key=>$value){
                    if(!in_array($value["attribute_id"], $checks)){
                        $listss[] = $value["get_attribute_name"]["name"]." (V)";
                        $checks[] = $value["attribute_id"];
                    }
                }
            }
        });


        return new Collection([
            array_merge($static_field, $listss, $lists)
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->month;
    }
}