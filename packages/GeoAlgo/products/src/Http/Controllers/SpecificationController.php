<?php

namespace GeoAlgo\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GeoAlgo\Products\Models\SpecificationModel;
use DataTables;
use Log;
use Auth;
use Validator;

class SpecificationController extends Controller
{
    public function delete(Request $request){
        try{
            $specification = SpecificationModel::find($request->id);
            $specification->deleted = 1;
            if($specification->save()){
                return success_json($specification, "Specification deleted successfully");
            }else{
                return error_json("Specification cannot be deleted");
            }
        }catch(\Exception $e){
            Log::error($e);
            return error_json($e);
        }
    }
    public function create(Request $request){
        try{
            $specification = null;
            $category = null;
            $values = null;
            if($request->edit == true){
                $specification = SpecificationModel::where("id", $request->id)->with("getAttributeName")->first();
                $category = (object)$specification->category_array;
                $values = $specification->attr_value_array;
                Log::error($specification);
            }
            return view('products::specification.create', ["edit"=>$request->edit, "specification"=>($specification == null ? $specification:$specification->toArray()), "category"=>$category, "values"=>$values, "setting_id"=>$request->setting_id]);
        }catch(\Exception $e){
            Log::error($e);
            return error_json($e);
        }
    }

    public function store(Request $request){
        try{
            if($request->edit == true || $request->edit == "true"){

                $validator = Validator::make($request->all(), [
                  'id'      => 'required|numeric',
                  'attribute_id' => 'required|numeric',
                  'attribute_value_id' => 'required|array',
                  'category_id'      => 'required|array',
                  'mandatory'      => 'required|boolean',
                  'setting_id'      => 'required|numeric',
                  //'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                 // 'banner_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $specification = SpecificationModel::find($request->id);
            }else{

                $validator = Validator::make($request->all(), [
                    'attribute_id' => 'required|numeric',
                    'attribute_value_id' => 'required|array',
                    'category_id'      => 'required|array',
                    'mandatory'      => 'required|boolean',
                    'setting_id'      => 'required|numeric',
                  ]);

                $specification = new SpecificationModel();
            }
            if ($validator->fails()) {
                return error_json($validator->errors()->first());
            }
            $specification->setting_id = $request->setting_id;
            $specification->attribute_id = $request->attribute_id;
            $specification->category_id = implode(",", $request->category_id);
            $specification->attribute_value_id = implode(",", $request->attribute_value_id);
            $specification->mandatory = $request->mandatory;
            if($specification->save()){
                return success_json("Specification Created", "Some Data");
            }

            return error_json("Specification can not be saved !");
        }catch(\Exception $e){
            return error_json($e);
        }
    }

    public function list(Request $request){
        try{
            $specifications = SpecificationModel::where("deleted", 0)->where("setting_id", $request->setting_id)->with("getAttributeName")->get();
            // Log::error($request->all());
            return DataTables::of($specifications)
                ->addIndexColumn()
                ->addColumn('categories', function($row){
                    return $row->category;
                })
                ->addColumn('att_values', function($row){
                    return $row->attr_value;
                })
                ->rawColumns(['categories', 'att_values'])
                ->make(true);
        }catch(\Exception $e){
            Log::error($e);
            return error_json($e);
        }
    }
}
