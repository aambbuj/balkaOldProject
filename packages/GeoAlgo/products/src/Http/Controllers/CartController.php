<?php

namespace GeoAlgo\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GeoAlgo\Products\Models\Product;
use GeoAlgo\Products\Models\Category;
use GeoAlgo\Products\Models\Coupon;
use GeoAlgo\Products\Models\coupon_vendor;
use GeoAlgo\Products\Models\ProductCategory;
use GeoAlgo\Products\Models\Attribute;
use GeoAlgo\Products\Models\CategoryAttributeValue;
use DB;
use Validator;
use DataTables;

class CartController extends Controller
{
    public function index()
    {
        try {             

              return view('products::coupon.index');

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

    public function list()
    {
        try {
              $coupons = Coupon::where("deleted",0);

              return DataTables::of($coupons)
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

     public function create(Request $request)
    {
        try{
            $coupon = array();
              if($request->edit == true){
                $coupon = Coupon::find($request->id);
              }
              $categories = Category::where('parent_id',NULL)->with('sub_categories')->get();
              $products = Product::select('id','sku','product_name',)->get();
        	return view('products::coupon.create', ["coupon"=>$coupon,'products' => $products ,'categories' =>$categories, "edit"=>$request->edit]);
        }catch(\Exeption $e){
        	return response()->json($e->getMessage());
        }
    }

    public function getProduct(Request $request)
    {
        $category_ids = json_decode($request->category_ids);
        $result = ProductCategory::whereIn('category_id',$category_ids)->get();
        return success_json($result);
    }
    
    public function store(Request $request)
    {
 

        try{
        	 
             if($request->edit == true || $request->edit == "true"){

                $validator = Validator::make($request->all(), [
                  'type'      => 'required',
                  'min_price'      => 'required',
                  'max_price'      => 'required',
                  'exp_date'      => 'required|date',
                 // 'category'      => 'required|array',
                  //'products'      => 'required|array'
                ]);
                $coupon = Coupon::find($request->id);
                $coupon_vendor = coupon_vendor::find($request->coupon_vendor_id);

             }else{

                $validator = Validator::make($request->all(), [
                    'type'      => 'required',
                    'min_price'      => 'required',
                    'max_price'      => 'required',
                    'exp_date'      => 'required|date',
                   // 'category'      => 'required|array',
                    //'products'      => 'required|array'
                ]);
                $coupon=new Coupon();
                $coupon_vendor = new coupon_vendor();

             }
             if ($validator->fails()) {
                return error_json($validator->errors()->first());
             }
             try {
                $coupon->user_id = auth()->user()->id;
                $coupon->type=request('type');
                $coupon->coupon_code=request('coupon_code');
                $coupon->coupon_value=request('coupon_value');
                $coupon->min_price=request('min_price');
                $coupon->max_price=request('max_price');
                $coupon->exp_date=request('exp_date');
                $coupon->created_by=auth()->user()->id;
                $coupon->save();
                try {

                    $categoryIds = ProductCategory::whereIn('category_id',$request->category)->get();   
                    $productIds = $request->products;
                    $catagoryProductIds = [];
                    foreach ($categoryIds as $catId) {

                        if (!empty($productIds)) {
                            foreach ($productIds as $product) {
                                if ($catId->product_id == $product) {
                                    $catagoryProductIds[] = ['coupon_id' => $coupon->id,'category_id' => $catId->category_id , 'product_id' => $product]; 
                                }
                            }
                        }

                        if (empty($productIds)) {
                            $catagoryProductIds[] = ['coupon_id' => $coupon->id,'category_id' => $catId->category_id , 'product_id' => null]; 
                        }

                    }
                    $result = coupon_vendor::insert($catagoryProductIds);
                    return success_json($result, "Coupon created successfully");


                } catch (\Throwable $th) {
                    //throw $th;
                }
             } catch (\Throwable $th) {
                 //throw $th;
             }

             
             if($coupon->save()){
              return success_json($coupon, "Coupon created successfully");
            }else{
              return error_json("Coupon cannot created!");
            }

        }catch(\Exeption $e){
        	return error_json($e);
        }

    }

    public function delete(Request $request){
        try {
            
            $category=Coupon::where('id',$request->id)->update(['deleted'=>1]);
            return success_json($category, "Coupon deleted successfully");
        } catch (\Exception $e) {
            return error_json($e);
        }
    }
}
