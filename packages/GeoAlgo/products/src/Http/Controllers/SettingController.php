<?php

namespace GeoAlgo\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index(Request $request){
        try{
            return view('products::settings.index');
        }catch(\Exception $e){
            abort(500);
        }
    }

    public function vendor_index(Request $request){
        try{
            return view('products::settings.vendor_index');
        }catch(\Exception $e){
            abort(500);
        }
    }
}
