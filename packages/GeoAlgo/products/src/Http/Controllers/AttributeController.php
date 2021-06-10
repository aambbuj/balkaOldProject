<?php

namespace GeoAlgo\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GeoAlgo\Products\Models\Attribute;
use GeoAlgo\Products\Models\AttributeValue;
use DB;
use Validator;
use DataTables;
use Illuminate\Support\Facades\Log;

class AttributeController extends Controller
{
      public function index()
    {
        try {

              return view('products::attribute.index');

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

    public function list()
    {
        try {
              $attributes = Attribute::where("deleted", 0)->with('values');
              /*echo "<pre>";
              print_r($attributes);die;*/

              return DataTables::of($attributes)
                  ->addIndexColumn()
                  ->addColumn('value', function($row){
                      $value_str = "";
                      foreach ($row->values as $key=>$value){
                        if(count($row->values)>1){
                            if(count($row->values)-1 > $key ){
                              $value_str .= $value->value.", ";
                            }else{
                                $value_str .= $value->value;
                            }
                        }else{
                          $value_str .= $value->value;
                        }
                      }
                      return $value_str;
                  })
                  ->rawColumns(['value'])
                  ->make(true);

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

     public function create(Request $request)
    {
        try{
            $attribute = array();
            if($request->edit == true){
                $attribute = Attribute::find($request->id);
            }
        	return view('products::attribute.create', [ "attribute"=>$attribute, "edit"=>$request->edit]);
        }catch(\Exeption $e){
        	return response()->json($e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try{
            $attribute = Attribute::find($request->id)->delete();
            if($attribute){
                return success_json($attribute, "Attribute deleted successfully");
            }else{
                return error_json("Attribute cannot be deleted");
            }
        }catch(\Exeption $e){
            Log::error($e);
        	return error_json($e);
        }
    }

    public function addAttributs(Request $request)
    {
      $attribute = Attribute::where('deleted',0)->with('values')->get();
      //  return response()->json(['attribute'=>$attribute]);
        return success_json($attribute, "Attributes");
     // return view("atrribute ")
    }



      public function store(Request $request)
      {
        try {

               if($request->edit == true || $request->edit == "true"){

	                $validator = Validator::make($request->all(), [
	                 'name' => 'required|min:3|max:255|string'

	                ]);

	                $attribute = Attribute::find($request->id);
                }else{

	                $validator = Validator::make($request->all(), [
	                 'name' => 'required|unique:attributes,name|min:3|max:255|string'

	                ]);

                   $attribute= new Attribute();
	             }

              if ($validator->fails()) {
                return error_json($validator->errors()->first());
              }
             $attribute->name=$request->name;
             $attribute->is_specific=$request->is_specific;

               if($attribute->save()){
	              return success_json($attribute, "Attribute created successfully");
	            }else{
	              return error_json("Attribute cannot created!");
	            }

              //$attributes=Attribute::where('product_id',$attribute->product_id)->get();
             // print_r($attributes);die();


              //return view('products::product.addattribute',['productId'=>$productId]);


        } catch (\Exception $e) {
          return error_json($e);
        }
     }

     public function getValue(Request $request, $id=0){
        try{
            $attribute = Attribute::find($id);
            return view("products::attribute.value_index", ["attribute"=>$attribute]);
        }catch(\Exception $e){
            abort(500);
        }
     }

     public function getValueList(Request $request){
         try{
            $attrValues = AttributeValue::where('attribute_id',$request->id)->select('id','attribute_id','value', 'relate')->get();
            return DataTables::of($attrValues)->make(true);
         }catch(\Exception $e){
             return error_json($e);
         }
     }

      public function addValue(Request $request)
      {
	       try {
	            $attribute = Attribute::find($request->id);
                return view('products::attribute.value', ['attribute'=>$attribute]);
	       } catch (\Exception $e) {
	           return error_json($e->getMessage());
	       }
      }

      public function deleteValue(Request $request)
      {
	       try {
	            $attribute = AttributeValue::find($request->id)->delete();
                if($attribute){
                    return success_json("Value deleted successfully");
                }else{
                    return error_json("Value cannot be deleted");
                }
	       } catch (\Exception $e) {
	           return error_json($e->getMessage());
	       }
      }

      public function editValue(Request $request){
        try {
            $attribute = Attribute::find($request->id);
            $attrValue = AttributeValue::find($request->value_id);
            return view('products::attribute.value', ['attribute'=>$attribute, "value"=>$attrValue]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return error_json($e->getMessage());
        }
      }

      public function storeValue(Request $request)
      {
        $validator = Validator::make($request->all(), [
          'value' => 'required'
         ]);
         if ($validator->fails()) {
          return error_json($validator->errors()->first());
        }
      	 try {
           if ($request->id) {
              $atrValue =AttributeValue::find($request->id);
           } else {
              $atrValue = new AttributeValue();
              $atrValue->attribute_id=$request->attribute_id;
           }
              $atrValue->id=$request->id;
              $atrValue->value=$request->value;
              $atrValue->relate=$request->relate;
              if($atrValue->save()){
	              return success_json($atrValue, "Attribute values save successfully");
	            }else{
	              return error_json("Attribute values  cannot save!");
	            }

      	 } catch (\Exception $e) {
      	 	return error_json($e);
      	 }
      }
}
