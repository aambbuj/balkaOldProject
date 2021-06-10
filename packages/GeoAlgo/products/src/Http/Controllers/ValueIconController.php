<?php

namespace GeoAlgo\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GeoAlgo\Products\Models\ValueIcon;
use DB;
use Validator;
use DataTables;
use Illuminate\Support\Facades\Log;

class ValueIconController extends Controller
{
    public function index(Request $request){
        try{
            return view('products::attribute.value_icon_index');
        }catch(\Exception $e){
            Log::error($e);
            abort(500);
        }
    }

    public function create(Request $request){
        try{
            $value_icon = array();

            if($request->edit == true){
                $value_icon = ValueIcon::find($request->id);
            }
            return view('products::attribute.value_icon_create', [ "value_icon"=>$value_icon, "edit"=>$request->edit]);
        }catch(\Exception $e){
            abort(500);
        }
    }

    public function store(Request $request)
      {
        try {

               if($request->edit == true || $request->edit == "true"){

	                $validator = Validator::make($request->all(), [
	                 'name' => 'required|min:3|max:255|string',
	                ]);

	                $valueIcon = ValueIcon::find($request->id);
                }else{

	                $validator = Validator::make($request->all(), [
	                 'name' => 'required|unique:value_icons,name|min:3|max:255|string',
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	                ]);

                   $valueIcon= new ValueIcon();
	             }

              if ($validator->fails()) {
                return error_json($validator->errors()->first());
              }
              if($request->hasfile('image')){
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('value_icon'), $imageName);
                $valueIcon->image=$imageName;
             }
             if($request->has("category") && $request->category != null){
                $valueIcon->category_id = implode(",", $request->category);
             }
             $valueIcon->name=$request->name;
             $valueIcon->description=$request->description;

               if($valueIcon->save()){
	              return success_json($valueIcon, "Value icons created successfully");
	            }else{
	              return error_json("Value icons cannot created!");
	            }

              //$attributes=Attribute::where('product_id',$attribute->product_id)->get();
             // print_r($attributes);die();


              //return view('products::product.addattribute',['productId'=>$productId]);


        } catch (\Exception $e) {
            Log::error($e);
          return error_json($e);
        }
     }

    public function delete(Request $request){
        try{
            $value_icon = ValueIcon::find($request->id)->delete();
            if($value_icon){
                return success_json($value_icon, "Value icon deleted successfully");
            }else{
                return error_json("Value icon cannot be deleted");
            }
        }catch(\Exeption $e){
        	return error_json($e);
        }
    }

    public function list(Request $request){
        try {
              $valueIcons = ValueIcon::where("deleted", 0);
              /*echo "<pre>";
              print_r($attributes);die;*/

              return DataTables::of($valueIcons)
                  ->addIndexColumn()
                  ->addColumn('categories', function($row){
                    return $row->category;
                  })
                  ->rawColumns(['categories'])
                  ->make(true);

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

    public function list_selected(Request $request){
        try {
            $arr1 = ValueIcon::where("deleted", 0)->where("category_id", "")->select("id", "name as text")->get()->toArray();
            $valueIconEmpty = ValueIcon::where("deleted", 0)->where(function($query) use($request){
                if(is_array($request->category_id)){
                    foreach($request->category_id as $key=>$value){
                        $query->orWhereRaw("find_in_set(".$value.", category_id)");
                    }
                }
                return $query;
            })->select("id", "name as text")->get()->toArray();
            $arr = array_merge($arr1, $valueIconEmpty);
            return success_json($arr, 'List Populated');
      } catch (\Exception $e) {
          Log::error($e);
          return error_json($e);
      }
    }
}
