<?php

namespace GeoAlgo\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GeoAlgo\Products\Models\Item;
use GeoAlgo\Products\Models\Product;
use App\Models\Company;
use App\Models\CustomItem;
use App\Models\User;
use App\Traits\Bars\BarsCRUD;
use DB;
use Validator;
use DataTables;
use Illuminate\Support\Str;

class ItemController extends Controller
{
	use BarsCRUD;

    public function index()
    {
        try {             

              return view('products::inventory.index');

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

    public function list()
    {
        try {
              $items = Item::where("deleted", 0)->with('product');

              return DataTables::of($items)
                  ->addIndexColumn()
                   ->addColumn('product_name', function(Item $item){
                  //     $permission_str = "";
                  //     foreach ($row->permissions as $key=>$value){
                  //       $permission_str .= $value->name.", ";
                  //     }
                  //     return $permission_str;
                   	return $item->product->product_name;
                  })
                  // ->rawColumns(['permission'])
                  ->make(true);

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

     public function create(Request $request)
    {
    	 
        try{
            $item = array();
              if($request->edit == true){
                $item = Item::find($request->id);
              }
        	$products = Product::where("deleted", 0)->get();
        	$bars = $this->getBarOwnars();

        	return view('products::inventory.create', ["products"=>$products, "item"=>$item, "edit"=>$request->edit ,"bars"=>$bars]);
        }catch(\Exeption $e){
        	return response()->json($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try{
        	  // $items = Item::where("deleted", 0)->where('product_id',$request->product_id)->where('company_id',$request->company_id)->value('id');

           //   if($items){
                   if($request->edit == true || $request->edit == "true"){

		                $validator = Validator::make($request->all(), [
		                  'product_id' => 'required|numeric',
		                  'bar_id' => 'required|numeric',
		                  'mrp'      => 'required|numeric',
		                  'discount' => 'sometimes|nullable|numeric',
		                  'price'    => 'required|numeric',
		                  'qty'      => 'required|numeric',
		                  'sold'     => 'required|numeric'
		                  //'available'  => 'required|numeric'
		                  
		                ]);

		                $item = Item::find($request->id);
		             }else{

		                $validator = Validator::make($request->all(), [
		                  'product_id' => 'required|numeric',
		                  'bar_id' => 'required|numeric',
		                  'mrp'      => 'required|numeric',
		                  'discount' => 'sometimes|nullable|numeric',
		                  'price'    => 'required|numeric',
		                  'qty'      => 'required|numeric',
		                  'sold'     => 'required|numeric'
		                  //'available'  => 'required|numeric'
		                  
		                ]);

		                $company=Company::where('assign_to',$request->bar_id)->value('id');
		               // return error_json($company);

		                $items = Item::where("deleted", 0)->where('product_id',$request->product_id)->where('company_id',$company)->value('id');

		                if($items){
		                	return error_json("Product all ready in inventory!");
		                }

		                $item=new Item();
		             }
		             if ($validator->fails()) {
		                return error_json($validator->errors()->first());
		             }
		             $product=Product::find($request->product_id);
		             $item->sku=$product->sku;
		             $item->product_id=request('product_id');
		             $item->company_id=request('bar_id');
		             $item->cost=request('cost');
		             $item->discount=request('discount');
		             $item->sale_price=request('sale_price');
		             $item->qty=request('qty');
		             $item->sold=request('sold');
		             $item->available=request('qty')-request('sold');
		             $item->created_by=auth()->user()->id;
		             
		            if($item->save()){
		              return success_json($item, "Inventory created successfully");
		            }else{
		              return error_json("Inventory cannot created!");
		            }
             // }else{

             // }

        }catch(\Exeption $e){
        	return error_json($e);
        }

    }

    public function delete(Request $request){
        try {
            
            $item=Item::find($request->id)->update(['deleted'=>1]);
            return success_json($item, "Category deleted successfully");
        } catch (\Exception $e) {
            return error_json($e);
        }
    }

    /////////////////// functions for api ///////////////////////
    public function storeProduct(Request $request)
    {
      try {
             if($request->id==NULL || $request->id=="")
             {
               $validator = Validator::make($request->all(), [
                      'category_id' => 'required|numeric',
                      'product_id' => 'required|numeric',
                      'sale_price'    => 'required|numeric',
                      'qty'      => 'required|numeric',
                      
                    ]);

               $companyId=Company::where('assign_to',auth()->user()->id)->value('id');
                   //return response()->json(['data' => $companyId]);

                    $items = Item::where("deleted", 0)->where('product_id',$request->product_id)->where('category_id',$request->category_id)->where('company_id',$companyId)->value('id');
                     //return response()->json(['data1' => $items]);
                    if(!empty($items)){
                      return error_json("Product all ready in inventory!");
                    }
                    
                    $item=new Item();
                    $item->company_id=$companyId;
                    $item->created_by=auth()->user()->id;
             } 
             else
             {
                  $validator = Validator::make($request->all(), [
                      'category_id' => 'required|numeric',
                      'product_id' => 'required|numeric',
                      'sale_price'    => 'required|numeric',
                      'qty'      => 'required|numeric',
                      
                    ]);
                  $item = Item::find($request->id);
             } 
             if ($validator->fails()) {
                    return error_json($validator->errors()->first());
             }

                 $item->category_id=request('category_id');
                 $item->product_id=request('product_id');
                 $item->sale_price=request('sale_price');
                 $item->qty=request('qty');

                 if($item->save()){
                  return success_json($item, "Inventory created successfully");
                }else{
                  return error_json("Inventory cannot created!");
                }

      } catch (\Exception $e) {
        return error_json($e);
      }
    }

    public function showProducts(Request $request)
    {
      try {

           if(!empty($request->category_id)){
              try {
                $productDetails=Item::where('deleted',0)->where('category_id',$request->category_id)->with('product')->get();
                $responce =  $this->productsInfo($productDetails);
                return response()->json(['data' => $responce ,'success'=> 'Success']);
              } catch (\Exception $e) {
                return error_json($e);
              }

        }else{
          $companyId = '';
           $companyId=Company::where('assign_to',auth()->user()->id)->value('id');
            if($companyId == '')
            {
              $parent_id=User::where('id',auth()->user()->id)->value('parent_id');
              $companyId=Company::where('assign_to',$parent_id)->value('id');
            }
            
            $itemDetails=Item::where('deleted',0)->where('company_id',$companyId)->with('product')->get();
            
            $responce =  $this->inventoryDetails($itemDetails);
            
            return response()->json(['data' => $responce ,'success'=> 'Success']);
        }
           
      } catch (\Exception $e) {
        return error_json($e);
      }
    }

    public function inventoryDetails($itemDetails)
    {
      $data=[];

      foreach($itemDetails as $detail)
        {
            $data[]=[
              'id' => $detail->id,
              'qty' => $detail->qty,
              'product_id' => $detail->product->id,
              'product_name' => $detail->product->product_name,
              'product_description' => $detail->product->product_description,
              'unit_price' => $detail->product->unit_price,
              'sale_price' => $detail->sale_price,
              'image' => url('Pimages/'.$detail->product->image)
            ];
        }
        return $data;  
    }

    public function getInventoryProducts(Request $request)
    {
        if(!empty($request->category_id)){
              try {
                $productDetails=Item::where('deleted',0)->where('category_id',$request->category_id)->with('product')->get();
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
          'category_id' => $details->category_id,
          'product_id' => $details->product_id,
          'product_name' => $details->product->product_name,
          'product_description' => $details->product->product_description,
          'qty' => $details->qty,
          'unit_price' => $details->product->unit_price,
          'discount' => $details->product->discount,
          'image' => url('Pimages/'.$details->product->image)
        ];
      }

      return $data;
    }

    public function addCustomProduct(Request $request)
    {
      try {
        if($request->id==null)
         {
         $validator = Validator::make($request->all(), [
           'catagory_name' => 'required|string',
           'product_name' => 'required|string',
           'cost' => 'required|numeric',
           'sale_price' => 'required|numeric',
           'product_desc' => 'required|string'
         ]);

          $CustomItem =  new CustomItem();
          $CustomItem->user_id = auth()->user()->id;

         }
         else
         {
         $validator = Validator::make($request->all(), [
          'catagory_name' => 'required|string',
          'product_name' => 'required|string',
          'cost' => 'required|numeric',
          'sale_price' => 'required|numeric',
          'product_desc' => 'required|string'
         ]);

           $CustomItem = CustomItem::find($request->id);
         }    

     if ($validator->fails()) {
       return error_json($validator->errors()->first());
     }  

     if ($file = base64_decode($request['image'])) 
     {
         $destinationPath = public_path('Pimages');;
         if (!is_dir($destinationPath)) {
             mkdir($destinationPath);
         }                
             $time = md5(date("Y/m/d-H:ia")); 
             $imageName = Str::random(10).'.'.'jpeg';
             $profileImage = $time.'_'.$imageName;
             $productImages = $profileImage;
             $success = file_put_contents(public_path().'/Pimages/'.$profileImage, $file);
             $CustomItem->image = $productImages;
     }
     $CustomItem->category_name = $request->catagory_name;
     $CustomItem->product_name = $request->product_name; 
     $CustomItem->cost = $request->cost;
     $CustomItem->sale_price = $request->sale_price;
     $CustomItem->product_description = $request->product_desc;

     if($CustomItem->save()){
     return success_json( '', "Product created successfully");
     }else{
       return error_json("Product cannot created!");
     }
      } catch (\Exception $e) {
        return error_json($e);
      }
    }

    public function deleteEmployee(Request $request)
    {
      try {
          if ($request->id!=null || $request->id != '') {
              $result = User::where('id',$request->id)->update( ['deleted' => 1] );
              return response()->json(['success'=>'Employee Deleted Successfully.']);

          } else {
            return response()->json(['error' => 'Dosenot metch any Employee']);
          }
          
      } catch (\Exception $th) {
          return response()->json(['error'=>'Something Wrong !Please try once']);
      }
    }

    public function deleteProduct(Request $request)
    {
      try {
          if ($request->id!=null || $request->id != '') {
              $result = Item::where('id',$request->id)->update( ['deleted' => 1] );
              return response()->json(['success'=>'Product Deleted Successfully.']);

          } else {
            return response()->json(['error' => 'Dosenot metch any Product']);
          }
          
      } catch (\Exception $th) {
          return response()->json(['error'=>'Something Wrong !Please try once']);
      }
    }

    public function updateqty(Request $request)
    {
        try {
              $item=Item::where('id',$request->id)->first();

              if ($request->sold_qty <= $item->qty) {
                $item->qty=$item->qty-$request->sold_qty;
                $item->update();

              return response()->json(['data'=> $item->qty,'success'=>'Quantity Updated Successfully.']);
              } else {
                return response()->json(['error'=>'Sold quantity can not be greater than available quantity']);
              }
              

        } catch (\Exception $e) {
          return error_json($e);
        }
    }
}
