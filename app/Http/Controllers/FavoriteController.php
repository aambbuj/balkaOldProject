<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GeoAlgo\Products\Models\Product;
use GeoAlgo\Products\Models\Category;
use GeoAlgo\Products\Models\CategoryAttributeValue;
use GeoAlgo\Products\Models\ProductCategory;

class FavoriteController extends Controller
{
    public function index()
    {
        try {
            $categoryMains = Category::where('parent_id',NULL)->with('products')->get();
            $categoryProducts = Category::with('products')->get();
                    // echo "<pre>";
                    //  print_r($categoryProducts);die;
        return view('products.favorite',compact('categoryMains','categoryProducts'));
        } catch (\Exception $categoyEx) {
            $categoryProducts=[];
            return view('products.favorite',compact('categoryProducts'));
        }
    }

}
