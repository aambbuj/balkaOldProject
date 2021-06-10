<?php

namespace GeoAlgo\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GeoAlgo\Products\Models\Product;
use GeoAlgo\Products\Models\ProductAttributeValue;
use GeoAlgo\Products\Models\Category;
use GeoAlgo\Products\Models\ProductCategory;
use GeoAlgo\Products\Models\CategoryRelation;
use GeoAlgo\Products\Models\Attribute;
use GeoAlgo\Products\Models\Brand;
use GeoAlgo\Products\Models\SpecificationModel;
use GeoAlgo\Products\Models\ProductImage;
use App\Models\Company;
use App\Models\User;
use DB;
use Validator;
use DataTables;
use Log;

/**/
class ProductController extends Controller
{
    public function index()
    {
        try {/**/
        	 /**/
        	 //$productDetails = Product::where("deleted", 0)->get();

             return view('products::product.index');

        } catch (\Exception $e) {
        	return error_json($e);
        }
    }

    public function list()
    {
        try {
              $productDetails = Product::where("deleted", 0);

              return DataTables::of($productDetails)
                  ->addIndexColumn()
                  // ->addColumn('permission', function($row){
                  //     $permission_str = "";
                  //     foreach ($row->permissions as $key=>$value){
                  //       $permission_str .= $value->name.", ";
                  //     }
                  //     return $permission_str;
                  // })
                  // ->rawColumns(['permission'])
                  ->make(true);

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

    public function create()
    {
    	try {
            $brands=Brand::where("deleted", 0)->get();
            $type = Category::where("deleted", 0)->whereNull("parent_id")->get();
    	    return view('products::product.create', compact('type','brands'));
    	} catch (\Exception $e) {
    		return error_json($e);
    	}
    }



    public function store(Request $request)
    {

        try {
 
              $validator = Validator::make($request->all(), [
                  'name' => 'required|min:3|max:255|string',
                  'description' => 'min:3|max:255',
                  'short_description' => 'min:3|max:255',
                  'category_id' => 'required',
                  'brand_id' => 'required',
                  'main_stock_status' => 'required',
                  'main_stock_quantity' => 'required',
                  'price' => 'required',
                  //'discount' => 'numeric',
                 'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);
           
              if ($validator->fails()) {
                return error_json($validator->errors()->first());

               // return redirect()->route('product.create')->withErrors($validator)->withInput();
              }


              ////////////////////// upload featured_image /////////////////////
              if ($request->hasfile('featured_image')) {
                $imageName = time().'.'.$request->featured_image->getClientOriginalExtension();
                $request->featured_image->move(public_path('Pimages'), $imageName);
              }

            ///////////////////////      Add product table ////////////////////////////////////////////
             $product= new Product();
             $product->sku=uniqid();
             $product->product_name=request('name');
             $product->product_description=request('description');
             $product->short_description=request('short_description');
             $product->stock_status=request('main_stock_status');
             $product->qty_per_unit=request('main_stock_quantity');
             $product->stock_threshold=request('main_low_stock_threshold');
             $product->brand_id=request('brand_id');
             $product->type_id=request('type_id');
             $product->unit_weight=request('main_weight');
             $product->length=request('main_dimension_length');
             $product->width=request('main_dimension_width');
             $product->height=request('main_dimension_height');
             $product->exchange=request('exchange_form_select');
             $product->return_idea=request('return_form_select');
             $product->delivery_timeline=request('delivery_form_select');
             $product->unit_price=request('price');
             $product->image=$imageName;
             $product->created_by=auth()->user()->id;
             $product->save();
            //  echo "<pre>";
            //  print_r($request->all());
            //  die;
                ////////////////////// upload featured_image /////////////////////
       
                if($request->hasfile('gallery_image'))
                {
                  foreach($request->file('gallery_image') as $file)
                  {
                      $name = time().rand(1,100).'.'.$file->extension();
                      $file->move(public_path('gallery_image'), $name);  
                      $gallery_imag_name[]=[
                        'product_id' => $product->id,
                        'name' => $name,
                        'path' => '',  
                        'type' => 'gallery_image',
                      ];  
                  }

                  ProductImage::insert($gallery_imag_name);
                }


            //////////////   Add data productcategory table  with product id ///////////////////////////////////
                try {
                  $prdcat= new ProductCategory();
                  $prdcat->product_id=$product->id;
                  $prdcat->category_id=$request->category_id;
                  $prdcat->created_by=auth()->user()->id;
                  $prdcat->save();

           
                  try {
                        ///////////////////////    Add productAttributeValue table with productId attributeId and ValueId . multipale add section              ///////////////
                        $getAttributeValues = $request->variation;
           
                        if (!empty($getAttributeValues)) {
                            $attrbuteValueArr=[];
                            $subProductData = [];
                       
                          foreach ($getAttributeValues as $key => $getAttributeValue) {

                        
                              if (isset($getAttributeValue['variation_type']) && !empty($getAttributeValue['variation_type'])) {
                                foreach ($getAttributeValue['variation_type'] as $attrId => $AttrValueId) {
                                    if ($AttrValueId != '' ||  $AttrValueId != NULL) {
                                          $attrbuteValueArr[]=[
                                            'product_id' => $product->id,
                                            'attribute_id' => $attrId,
                                            'attribute_value_id' => $AttrValueId,
                                            'type' => 'variation',
                                          ];

                                          $subProductData[] = [  
                                            'sku' => $getAttributeValue['sku'],
                                            'unit_price' => $getAttributeValue['regular_price'],
                                            //'sale_price' => $getAttributeValue['sale_price'],
                                            'stock_status' => $getAttributeValue['stock_status'],
                                            'qty_per_unit' => $getAttributeValue['stock_quantity'],
                                            'stock_threshold' => $getAttributeValue['stock_threshold'],
                                            'unit_weight' => $getAttributeValue['weight'],
                                            'length' => $getAttributeValue['length'],
                                            'width' => $getAttributeValue['width'],
                                            'height' => $getAttributeValue['height'],
                                            'parent_id' => $product->id,
                                          ];
                                    }
                                }
                              }
                            }

                            $result = ProductAttributeValue::insert($attrbuteValueArr);
                            $result2 = Product::insert($subProductData);  

                              /////////  specification //////////////////////////
                              $specifications = $request->specification;
                              if (!empty($specifications)) {
                                    $specificationArr=[];

                                  foreach ($specifications as $sAttrId => $sAttrValID) {
                                        if ($sAttrValID != '' ||  $sAttrValID != NULL) {
                                              $specificationArr[]=[
                                                'product_id' => $product->id,
                                                'attribute_id' => $sAttrId,
                                                'attribute_value_id' => $sAttrValID,
                                                'type' => 'specification',
                                              ];
                                        }    
                                    }
                                }
                              $result = ProductAttributeValue::insert($specificationArr);
                                /////// End specifications ///////////////////////


                                
                                /////////  washcare //////////////////////////
                              $washcares = $request->washcare;
                              if (!empty($washcares)) {
                                    $washcareArr=[];

                                  foreach ($washcares as $wAttrId => $wAttrValID) {
                                        if ($wAttrValID != '' ||  $wAttrValID != NULL) {
                                              $washcareArr[]=[
                                                'product_id' => $product->id,
                                                'attribute_id' => $wAttrId,
                                                'attribute_value_id' => $wAttrValID,
                                                'type' => 'washcare',
                                              ];
                                        }    
                                    }
                                }
                                $result = ProductAttributeValue::insert($washcareArr);
                                  /////// End washcare ///////////////////////

                                  /////////  attribute //////////////////////////
                                $attributes = $request->attribute;
                                if (!empty($attributes)) {
                                      $attributeArr=[];
    
                                    foreach ($attributes as $aAttrId => $aAttrValID) {
                                          if ($aAttrValID != '' ||  $aAttrValID != NULL) {
                                                $attributeArr[]=[
                                                  'product_id' => $product->id,
                                                  'attribute_id' => $aAttrId,
                                                  'attribute_value_id' => $aAttrValID,
                                                  'type' => 'attribute',
                                                ];
                                          }    
                                      }
                                  }
                                $result = ProductAttributeValue::insert($attributeArr);
                                  /////// End attribute ///////////////////////
                               

                              // echo "<pre>";
                              // print_r($request->all());
                              // die();
                               return redirect()->route('product.index')->with('success', 'product Add Success With Attribute Value Wise');

                             // return redirect()->back()->with('success', 'product Add Success With Attribute Value Wise');   
                      } else {
                       
                        return redirect()->back()->with('success', 'Product Add Success');   
                      }
                  } catch (\Exception $productAttributeValueEx) {
                        ProductAttributeValue::where('product_id',$product->id)->delete();///////// when Ex delete from productCategory///////
                        ProductCategory::where('product_id',$product->id)->delete();///////// when Ex delete from productCategory///////
                        Product::where('id',$product->id)->delete();   ///////// when Ex delete from product table///////
                        // echo "<pre>";
                        // print_r($productAttributeValueEx->getMessage());
                        // die();
                        return back()->withError('error', 'product Doce,t Add Please try once')->withInput($request->all());
                  }
                } catch (\Exception $categoryEx) {
                  Product::where('id',$product->id)->delete(); ///////// when Ex delete from product table///////
        	          // return error_json($categoryEx);
                    return back()->withError('error', 'product Doce,t Add Category Exc')->withInput($request->all());
                  //  echo "<pre>";
                  //  print_r($categoryEx->getMessage());
                  //  die();
                }
        } catch (\Exception $productEx) {
        	return error_json($productEx);
        }
    }

    public function addAttributsImagePrice(Request $request)
    {

      $productAttValDetails = ProductAttributeValue::where('product_id',$request->product_id)->with('attributeValues','attributes')->get();
      // echo  "<pre>";
      // print_r($productAttValDetails);
      return view('products::product.add_attributs',['productAttValDetails' => $productAttValDetails]);
    }


    public function updateProductAttributeValue(Request $request)
    {
      foreach ($request->id as $key =>   $id) {
        ProductAttributeValue::where('id',$id)->update(['price' => $request->price[$key]]);

        if($files=$request->file('att_val_image'.$id)){
          foreach ($files as $key =>  $image) {
            $imageName[] = time().'.'.$image->getClientOriginalExtension();
            //  $imageName = time().'.'.$request->image->getClientOriginalExtension();
            //  $image->move(public_path('PAVimages'), $imageName[$key]);

          }
          $images = implode(",",$imageName);
          ProductAttributeValue::where('id',$id)->update(['att_val_image' => $images]);
        }
      }
       return success_json(route("product.index"), "good");

    }

    public function edit($id = 0)
    {
      $attributeIds=[];
    	try {
    		$product=Product::find($id);
        $attributsCount = ProductAttributeValue::where('product_id',$id)->count();
    		$categories=Category::where("deleted", 0)->get();
        $AllData = Attribute::where('deleted',0)->with('values')->get();
        $attributes = $this->getAttribute($id ,$AllData);
        $brands=Brand::where("deleted", 0)->get();
        $type = Category::where("deleted", 0)->whereNull("parent_id")->get();
        $productCategories=ProductCategory::where("deleted",0)->where('product_id',$id)->pluck('category_id')->toArray();
        // echo "<pre>";
        // print_r($attributes);
        // die;
    		return view('products::product.editbulk',['brands' => $brands , 'type' => $type, 'attributes' => $attributes,"product"=>$product, "categories"=>$categories,"productCategories"=>$productCategories,'attributsCount' => $attributsCount]);

    	} catch (\Exception $e) {
    		return error_json($e);
    	}
    }

    public function getAttribute($product_id , $attributes)
    {
      $data=[];
      foreach ($attributes as $attribute) {
        $data[]=[
          'id'=> $attribute->id,
          'name'=> $attribute->name,
          'attribute_id'=> ProductAttributeValue::where('product_id',$product_id)->where('attribute_id',$attribute->id)->value('attribute_id'),
          'Pro_attr_value_id'=> ProductAttributeValue::where('product_id',$product_id)->where('attribute_id',$attribute->id)->value('id'),
          'values' => $this->getAttributeValues($product_id,$attribute),
        ];

      }
      return $data;
    }

    public function getAttributeValues($product_id,$attribute)
    {
      $data=[];
      foreach ($attribute->values as  $value) {
       $data[]=[
        'id' => $value->id,
        'value' => $value->value,
        'attribute_id' => $value->attribute_id,
        'attribute_value_id'=> ProductAttributeValue::where('product_id',$product_id)->where('attribute_id',$value->attribute_id)->where('attribute_value_id',$value->id)->value('attribute_id'),
        'Pro_attr_value_id'=> ProductAttributeValue::where('product_id',$product_id)->where('attribute_id',$value->attribute_id)->where('attribute_value_id',$value->id)->value('id'),
       ];
      }
      return $data;
    }

    public function update(Request $request)
    {
      $id=json_decode($request->product_id);
    	     try {
                $validator = Validator::make($request->all(), [
                  'name' => 'required|min:3|max:255|string',
                  'description' => 'min:3|max:255',
                  'category_id' => 'required',
                  'qty' => 'required|numeric',
                  'price' => 'required|numeric',
                  'discount' => 'numeric',
                  'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

              if ($validator->fails()) {
                return error_json($validator->errors()->first());
              }

              $product=Product::where('id',$id)->where("deleted", 0)->first();

              if($request->hasfile('image'))
             {

    	     	    $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('Pimages'), $imageName);
                $product->image=$imageName;
              }

                $product->product_name=request('name');
                $product->product_description=request('description');
                $product->qty_per_unit=request('qty');
                $product->unit_price=request('price');
                $product->discount=request('discount');
                $product->updated_by=auth()->user()->id;
                $product->update();

               // foreach ($request->category_id as $cat) {
	              	$prdcat=ProductCategory::where('category_id',$request->category_id)->where('product_id', $product->id)->where("deleted", 0)->latest()->first();
	              	if (empty($prdcat)) {
	              		$prdcat= new ProductCategory();
	              		$prdcat->product_id=$product->id;
	              	    $prdcat->category_id=$request->category_id;
	              	    $prdcat->created_by=auth()->user()->id;
	              	    $prdcat->save();
	              //	}

              	}

              	$prdcat_list=ProductCategory::where('product_id', $product->id)->where("deleted", 0)->get();

              	foreach($prdcat_list as $key=> $value){
              	//	if(!in_array($value->category_id, $request->category_id)){
              			$proo = ProductCategory::find($value->id)->update(["deleted"=>1]);
              	//	}
              	}

                $attrValueData = json_decode($request->attribute_value);
               // return success_json($attrValueData, "product update Success");

                    // $attrbuteValueArr=[];
                     foreach ($attrValueData as $attrValue) {
                       $ProductAttributeValue = new ProductAttributeValue();
                       $ProductAttributeValue->product_id = $id;
                       $ProductAttributeValue->attribute_id = $attrValue->insert_attribute_id;
                       $ProductAttributeValue->attribute_value_id = $attrValue->insert_attribute_value_id;
                       $ProductAttributeValue->save();
                      // $attrbuteValueArr[]=$ProductAttributeValue->id;
                     }
                    return success_json($id, "product update Success");

    	     } catch (\Exception $e) {
    	     	return error_json($e);
    	     }
    }

   public function addQty(Request $request)
   {
       try {

             $product=Product::find($request->id);

             return view('products::product.addqty',["product"=>$product]);
            /*$validator = Validator::make($request->all(), [
                  'qty' => 'required|numeric'
                ]);

              if ($validator->fails()) {
                return error_json($validator->errors()->first());
              }
*/
       } catch (\Exception $e) {
         return error_json($e);
       }
   }

    public function qtyStore(Request $request)
   {
       try {
            $validator = Validator::make($request->all(), [
                  'qty' => 'required|numeric'
                ]);

              if ($validator->fails()) {
                return error_json($validator->errors()->first());
              }

              $product=Product::find($request->id);

              $tqty=$product->qty_per_unit+$request->qty;
              $product->qty_per_unit=$tqty;

              if($product->save()){
              return success_json($product, "Quantity added successfully");
              }else{
                return error_json("Quantity cannot added!");
              }

       } catch (\Exception $e) {
         return error_json($e);
       }
   }


    public function delete(Request $request)
    {
    	try {

    		$product=Product::where('id',$request->id)->first();
    		$product->update(['deleted'=>1]);
        $prdcat_list=ProductCategory::where('product_id', $product->id)->where("deleted", 0)->get();
        foreach($prdcat_list as $key=>$value){
           $proo = ProductCategory::find($value->id)->update(["deleted"=>1]);
        }


    		return success_json($product, "Product deleted successfully");
    	} catch (\Exception $e) {
    		return error_json($e);
    	}
    }

    //////////////////////////// functions for api /////////////////////////

    public function getProductCategories(Request $request)
    {
      try {
            $categories=Category::where('deleted',0)->get();
            $responce =  $this->categoryInfo($categories);
            return response()->json(['data' => $responce ,'success'=> 'Success']);

      } catch (\Exception $e) {
        return error_json($e);
      }
    }

    public function categoryInfo($categories)
    {
      $data=[];

      foreach($categories as $category)
      {
        $data[]=[
          'id' => $category->id,
          'name' => $category->name,
          'image' => url('images/'.$category->image)
        ];
      }

      return $data;

    }

    public function getProducts(Request $request)
    {
        if(!empty($request->category_id)){
              try {
                $productIds=ProductCategory::where('category_id',$request->category_id)->pluck('product_id');
                $productDetails=Product::whereIn('id',$productIds)->get();
                //return response()->json(['sucess'=>$productDetails]);
                $responce =  $this->productsInfo($productDetails);
                return response()->json(['data' => $responce ,'success'=> 'Success']);
              } catch (\Exception $e) {
                return error_json($e);
              }

        }else{
          return response()->json(['error'=> 'Does not have any Category']);
        }
    }

    public function productsInfo($productDetails)
    {
      $data=[];

      foreach ($productDetails as $details) {
        $data[]=[
          'id' => $details->id,
          'product_name' => $details->product_name,
          'product_description' => $details->product_description,
          'qty_per_unit' => $details->qty_per_unit,
          'unit_price' => $details->unit_price,
          'discount' => $details->discount,
          'image' => url('Pimages/'.$details->image)
        ];
      }

      return $data;
    }

    public function categoryWithProduct(Request $request)
    {
      try {
            $productDetailsWithCat=Category::where("deleted",0)->with('products')->get();
                $responce =  $this->productsDetails($productDetailsWithCat);
                return response()->json(['data' => $responce ,'success'=> 'Success']);
            //return response()->json(['sucess'=>$productDetailsWithCat]);
      } catch (\Exception $e) {
        return error_json($e);
      }
    }

    public function productsDetails($productDetailsWithCat)
    {
      $data=[];

      foreach ($productDetailsWithCat as $details) {
        $data[]=[
          'id' => $details->id,
          'name' =>$details->name,
          'products' => $this->productsInfoDetails($details->products),
          /*'product_id' => $details->products->id,
          'product_name' => $details->products->product_name,
          'unit_price' => $details->products->unit_price,
          'image' => url('Pimages/'.$details->products->image)*/
        ];
      }

      return $data;
    }

    public function productsInfoDetails($productDetails)
    {
      $data=[];

      foreach ($productDetails as $details) {
        $data[]=[
          'id' => $details->id,
          'product_name' => $details->product_name,
          'product_description' => $details->product_description,
          'unit_price' => $details->unit_price,
          'image' => url('Pimages/'.$details->image)
        ];
      }

      return $data;
    }

    public function category_select_list(Request $request){
        try{
            $listings = CategoryRelation::where("category_relations.deleted", 0)->whereIn("category_relations.id", $request->ids)->with("attributeValue")->with("recursiveVariation")->get()->toArray();
            $category_lists = array_map(function($value) {
              return intval($value);
            }, $request->ids);
            $list = array();
            $data = array();
            // Log::error($category_lists);
            array_walk_recursive_array($listings, function($a, $b) use(&$list, &$category_lists){
              if($b === "recursive_variation"){
                if($a != null){
                  $category_lists[] = $a["id"];
                }
              }
              if($b === "attribute_value"){
                  foreach($a as $key=>$value){
                    if(!isset($list[$value["attribute_id"]])){
                      $list[$value["attribute_id"]] = array();
                      $list[$value["attribute_id"]]["name"] = $value["get_attribute_name"]["name"];
                    }
                    $list[$value["attribute_id"]][$value["attribute_value_id"]] = $value["get_attribute_value_name"]["value"];
                  }
              }
            });
            $variation_count = 0;
            foreach($list as $key=>$value){
              if($variation_count == 0){
                $variation_count = 1;
              }
              $variation_count = $variation_count * (count($value) - 1);
            }
            $data["variations"] = $list;
            $data["variations_count"] = $variation_count;
            $data["variations_keys"] = array_keys($list);
            $data["variations_combination"] = $this->combinations($list);
            $specification_list = SpecificationModel::where("deleted", 0)->where("setting_id", 1)->where(function($query) use($category_lists){
                  if(is_array($category_lists)){
                      foreach($category_lists as $key=>$value){
                          $query->orWhereRaw("find_in_set(".$value.", category_id)");
                      }
                  }
                  return $query;
              })->with("getAttributeName")->get();
            $specification = array();
            foreach($specification_list as $key=>$valuee){
              $value = $valuee->toArray();
              $arr = array();
              $arr["id"] = $value["id"];
              $arr["attribute_id"] = $value["attribute_id"];
              $arr["attribute_name"] = $value["get_attribute_name"]["name"];
              $arr["attrbute_value"] = $valuee->attr_value_array->toArray();
              $specification[] = $arr;
            }
            $data["specification"] = $specification;

            $wash_care_list = SpecificationModel::where("deleted", 0)->where("setting_id", 3)->where(function($query) use($category_lists){
              if(is_array($category_lists)){
                  foreach($category_lists as $key=>$value){
                      $query->orWhereRaw("find_in_set(".$value.", category_id)");
                  }
              }
              return $query;
              })->with("getAttributeName")->get();
            $wash_care = array();
            foreach($wash_care_list as $key=>$valuee){
              $value = $valuee->toArray();
              $arr = array();
              $arr["id"] = $value["id"];
              $arr["attribute_id"] = $value["attribute_id"];
              $arr["attribute_name"] = $value["get_attribute_name"]["name"];
              $arr["attrbute_value"] = $valuee->attr_value_array->toArray();
              $wash_care[] = $arr;
            }
            $data["wash_care"] = $wash_care;


            //attribution
            $listingss = CategoryRelation::where("category_relations.deleted", 0)->whereIn("category_relations.id", $request->ids)->with("attributeNonValue")->with("recursiveAttribution")->get()->toArray();
            // Log::error($listingss);
            $lists = array();
            array_walk_recursive_array($listingss, function($a, $b) use(&$lists){              
              if($b === "attribute_non_value"){
                foreach($a as $key=>$value){
                  if(!isset($lists[$value["attribute_id"]])){
                    $lists[$value["attribute_id"]] = array();
                    $lists[$value["attribute_id"]]["name"] = $value["get_attribute_name"]["name"];
                    $lists[$value["attribute_id"]]["mandatory"] = $value["mandatory"];
                  }
                  $lists[$value["attribute_id"]][$value["attribute_value_id"]] = $value["get_attribute_value_name"]["value"];
                }
              }
            });
            $data["attribution"] = $lists;
            return success_json($data, "Reaching");
        }catch(\Exception $e){
            Log::error($e);
            return error_json($e);
        }
    }

    public function combinations($arrays, $i = 0) {
      if (!isset($arrays[$i])) {
          return array();
      }
      if ($i == count($arrays) - 1) {
          return $arrays[$i];
      }
  
      // get combinations from subsequent arrays
      $tmp = combinations($arrays, $i + 1);
  
      $result = array();
  
      // concat each array from tmp with each element from $arrays[$i]
      foreach ($arrays[$i] as $v) {
          foreach ($tmp as $t) {
              $result[] = is_array($t) ? 
                  array_merge(array($v), $t) :
                  array($v, $t);
          }
      }
  
      return $result;
  }
}
