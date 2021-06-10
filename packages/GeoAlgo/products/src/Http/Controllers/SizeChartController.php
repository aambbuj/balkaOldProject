<?php

namespace GeoAlgo\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GeoAlgo\Products\Models\VendorSetting;
use Log;
use Auth;
use Validator;

class SizeChartController extends Controller
{
    public function index(Request $request){
        try{
            $vendorSetting = VendorSetting::where("vendor_id", Auth::user()->id)->first();
            return view('products::size_chart.index', ["vendor_data"=>$vendorSetting]);
        }catch(\Exception $e){
            abort(500);
        }
    }

    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'file'      => 'required',
            ]);

            if ($validator->fails()) {
                return error_json($validator->errors()->first());
            }
            if(Auth::user()->is_admin == 2){
                $fileName = time().'.'.$request->file->extension();
                $request->file->move(public_path('size_chart_img'), $fileName);
                $vendorSetting = VendorSetting::where("vendor_id", Auth::user()->id)->first();
                if(empty($vendorSetting)){
                    $vendorSetting = new VendorSetting();
                    $vendorSetting->created_by = Auth::user()->id;
                    $vendorSetting->vendor_id = Auth::user()->id;
                }
                $vendorSetting->size_guide = $fileName;
                $vendorSetting->updated_by = Auth::user()->id;
                if($vendorSetting->save()){
                    return success_json("File Uploaded", "File Uploaded");
                }else{
                    return error_json("Size chart is not updated successfully");
                }
            }else{
                return error_json("You cannot update the size chart");
            }
        }catch(\Exception $e){
            Log::error($e);
            return error_json($e);
        }
    }
}
