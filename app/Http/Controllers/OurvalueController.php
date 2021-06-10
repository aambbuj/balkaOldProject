<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ourvalue;
use DB;
use Validator;

class OurvalueController extends Controller
{
    public function index()
    {
        $ourvalues = Ourvalue::where('deleted',0)->get();
        // echo "<pre>";
        // print_r($ourvalues);die;
        return view('ourvalue.ourvalue',['ourvalues'=>$ourvalues]);
    }

    public function showOurvalue()
    {
        $ourvalues = Ourvalue::where('deleted',0)->get();
        return view('ourvalue.index',['ourvalues'=>$ourvalues]);
    }

    public function editOurvalue($id = 0)
    {
        $ourvalue=Ourvalue::find($id);
        return view('ourvalue.edit',['ourvalue'=>$ourvalue]);
    }

    public function updateOurvalue(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'heading' => 'required|min:3|max:255|string',
                    'ptext' => 'required|min:3|string',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('ourvalue.edit', $id)->withErrors($validator)->withInput();
                }
                  $ourvalue=Ourvalue::find($id); 

                  if($request->hasfile('image'))
                  {
                      $imageName = time().'.'.$request->image->getClientOriginalExtension();
                      $request->image->move(public_path('theme/ourvalueimg'), $imageName);
                      $ourvalue->image=$imageName;
                    }  

                    $ourvalue->heading=$request->heading;
                    $ourvalue->ptext=$request->ptext;
                    $ourvalue->update();

                    return redirect()->route('ourvalue.index')->withSuccess('You have successfully updated Ourvalue section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }
}
