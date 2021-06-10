<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GeoAlgo\Products\Models\Product;
use GeoAlgo\Products\Models\Category;
use GeoAlgo\Products\Models\CategoryAttributeValue;
use GeoAlgo\Products\Models\ProductCategory;
use GeoAlgo\Products\Models\Attribute;
use GeoAlgo\Products\Models\AttributeValue;
use GeoAlgo\Products\Models\ProductImage;
use GeoAlgo\Products\Models\ProductAttributeValue;
use GeoAlgo\Products\Models\CategoryRelation;
use GeoAlgo\Products\Models\Brand;
class ProductsController extends Controller
{
   
    public function showProductList(Request $request , $category_slug = null)
    {

        $currentQueries = $request->query();

        //Declare new queries you want to append to string:
        $newQueries = ['foo' => 'bar', 'popular'];
        
        //Merge together current and new query strings:
        $allQueries = array_merge($currentQueries, $newQueries);
        
        //Generate the URL with all the queries:
        $request->fullUrlWithQuery($allQueries);

       // print_r($request->fullUrlWithQuery($allQueries));die;

        if (!empty($request->sub_category)) {

            try {
                /// get category id///////////
                $category_ids = Category::where('slug',$request->sub_category)->value('id'); 
                /// get category parent id with banner image///////////
                $parent_ids = Category::where('slug',$request->sub_category)->select('parent_id','id','image','banner_image')->first();
                if (!empty($parent_ids)) {
                /// get category Related product category ///////////

                    $type_id = Category::where('slug',$request->type)->value('id');
                    $categoryId = Category::where('slug',$request->category)->value('id');
                    $relatedCategory =  CategoryRelation::where("type_id", $type_id)->where('category_id',$categoryId)->whereNULL("category_parent_id")->with("getName")->with('childRecursive')->get();
                  
                }       
                if ($category_ids > 0 ) {
                    
                /// get category category attribute wise value and related product details with selected data ///////////

                    $CategoryAttributeValue = CategoryAttributeValue::where('category_id',$category_ids)->groupBy('attribute_id')->with('attributs')->get();
                    if ($request->attribute) {
                        $attribute_ids = Attribute::where('name',$request->attribute)->pluck('id');
                        $attribute_value_ids = AttributeValue::where('value',$request->value)->pluck('id');
                        $product_ids = ProductAttributeValue::whereIn('attribute_id',$attribute_ids)->whereIn('attribute_value_id',$attribute_value_ids)->pluck('product_id');
                    }else{
                        $product_ids = ProductCategory::where('category_id',$category_ids)->pluck('product_id');
                    }
           
                    if ($request->more_like_this == 'yes') {

                        //////////////////////    MOre Like This Get All Products ////////////////////////////////////////////
                        $productTypes =  ProductAttributeValue::whereIn('product_id',$product_ids)->pluck('type');
                        $productIds =  ProductAttributeValue::whereIn('type',$productTypes)->pluck('product_id');
                        $ProductCategory = Product::whereIn('id',$productIds)->get();
                        /////////////////////////////   End More like   Get All Products  /////////////////////////////////////////
                    }else{
                        $ProductCategory = Product::whereIn('id',$product_ids)->get();

                    }
                
                    //////////////////////    MOre Like This  ////////////////////////////////////////////
                        try {
                            $productType =  ProductAttributeValue::whereIn('product_id',$product_ids)->distinct()->inRandomOrder()->limit(6)->pluck('type');
                            $productId =  ProductAttributeValue::whereIn('type',$productType)->pluck('product_id');
                            $moreLikeThis = Product::whereIn('id',$productId)->distinct()->inRandomOrder()->limit(6)->get();
                            /////////////////////////////   End More like /////////////////////////////////////////
                       
                        } catch (\Throwable $th) {
                            $moreLikeThis=[];
                        }

                 
                    return view('listing.listing',['parent_ids' => $parent_ids ,'moreLikeThis' => $moreLikeThis, 'CategoryAttributeValue' => $CategoryAttributeValue , 'ProductCategory' => $ProductCategory , 'relatedCategory' => $relatedCategory]);

                }
                return view('listing.listing',compact('category_slug'));
            } catch (\Throwable $th) {
                //throw $th;
            }

        }

        
    }

    public function showProductDetails(Request $request)
    {
        $product = Product::where('id',$request->product_id)->first();
        $attrIds = ProductAttributeValue::where('product_id',$request->product_id)->where('type','variation')->distinct()->pluck('attribute_id');
        $attrValIds = ProductAttributeValue::where('product_id',$request->product_id)->whereIn('attribute_id',$attrIds)->where('type','variation')->pluck('attribute_value_id');
        $attributs = Attribute::whereIn('id',$attrIds)->get();
        $attributValues = AttributeValue::whereIn('id',$attrValIds)->get();

        $brand_ids =  Product::where('id',$request->product_id)->pluck('brand_id');
        $moreLikeThis = Brand::whereIn('id',$brand_ids)->inRandomOrder()->limit(6)->get();

        $gallety_image = ProductImage::where('product_id',$request->product_id)->get();

        $category_id = ProductCategory::where('product_id',$request->product_id)->value('category_id');
        $categoryDetails = Category::where('id',$category_id)->first();


        //////////////////////    MOre Like This  ////////////////////////////////////////////
        $productTypes =  ProductAttributeValue::where('product_id',$request->product_id)->distinct()->inRandomOrder()->limit(4)->pluck('type');
        $productIds =  ProductAttributeValue::whereIn('type',$productTypes)->pluck('product_id');
        $differentProduct = Product::whereIn('id',$productIds)->distinct()->inRandomOrder()->limit(4)->get();
        /////////////////////////////   End More like /////////////////////////////////////////

        // echo "<pre>";
        // print_r($differentProduct);
        // die();
        return view('listing.details',['differentProduct' => $differentProduct ,'categoryDetails' => $categoryDetails , 'product' => $product ,'attributs' => $attributs ,'attributValues' => $attributValues ,'gallety_image' => $gallety_image, 'moreLikeThis' => $moreLikeThis]);

    }


    public function categoryIdWiseProducts(Request $request)
    {
        //return $request->category_id;
        try {
            $categoryProducts = Category::where('id',$request->category_id)->with('products')->get();
                    // echo "<pre>";
                    //  print_r($categoryProducts);die;
        return $categoryProducts;
        } catch (\Exception $categoyEx) {
            $categoryProducts=[];
            return $categoryProducts;
        }
    }

    public function getProductDetails(Request $request)
    {
        $productAttrId = ProductAttributeValue::where('product_id',$request->product_id)->where('type','variation')->pluck('attribute_id');
        $productAttrValue = ProductAttributeValue::where('product_id',$request->product_id)->where('type','variation')->pluck('attribute_value_id');
            $proAttrArr=[
                'product_id' => $request->product_id,
                'attribute' => Attribute::whereIn('id',$productAttrId)->get(),
                'attribute_value' => AttributeValue::whereIn('id',$productAttrValue)->get(),
                'gallety_image' => ProductImage::where('product_id',$request->product_id)->get(),
                'catehory_id' => ProductCategory::where('product_id',$request->product_id)->value('category_id'),
            ];
        return response()->json($proAttrArr);
    }
}
