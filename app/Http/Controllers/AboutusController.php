<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aboutus;
use App\Models\AboutusProfile;
use DB;
use Validator;

class AboutusController extends Controller
{
    public function index()
    {
        $aboutuses = Aboutus::where('deleted',0)->get();
        $aboutusprofiles = AboutusProfile::where('deleted',0)->get();
        // echo "<pre>";
        // print_r($aboutuses);die;
        return view('aboutus.aboutus',['aboutuses'=>$aboutuses, 'aboutusprofiles'=>$aboutusprofiles]);
    }

    public function showAboutus()
    {
        $aboutuses = Aboutus::where('deleted',0)->get();
        return view('aboutus.index',['aboutuses'=>$aboutuses]);
    }

    public function editAboutus($id = 0)
    {
        $aboutus=Aboutus::find($id);
        return view('aboutus.edit',['aboutus'=>$aboutus]);
    }

    public function updateAboutus(Request $request,$id)
    {
       try {
            $validator = Validator::make($request->all(), [
                'style' => 'required|min:3|max:255|string',
                'signature' => 'required|min:3|max:255|string',
                'paragraph' => 'required|min:3|max:255|string',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

            if ($validator->fails()) {
                //return error_json($validator->errors()->first());
                return redirect()->route('aboutus.edit', $id)->withErrors($validator)->withInput();
            }
                $aboutus=Aboutus::find($id);

            if($request->hasfile('image'))
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('theme/aboutusimg'), $imageName);
                $aboutus->image=$imageName;
            }

            $aboutus->style=$request->style;
            $aboutus->signature=$request->signature;
            $aboutus->paragraph=$request->paragraph;
            $aboutus->update();

            return redirect()->route('aboutus.index')->withSuccess('You have successfully updated Aboutus section!');

       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showAboutusProfile()
    {
        $aboutusprofiles = AboutusProfile::where('deleted',0)->get();
        return view('aboutus.profile.index',['aboutusprofiles'=>$aboutusprofiles]);
    }

    public function editAboutusProfile($id = 0)
    {
        $aboutusprofile=AboutusProfile::find($id);
        return view('aboutus.profile.edit',['aboutusprofile'=>$aboutusprofile]);
    }

    public function updateAboutusProfile(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'pname' => 'required|min:3|max:255|string',
                    'ptext' => 'required|min:3|max:255|string',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('aboutusprofile.edit', $id)->withErrors($validator)->withInput();
                }
                  $aboutusprofile=AboutusProfile::find($id);

                  if($request->hasfile('image'))
                  {
                      $imageName = time().'.'.$request->image->getClientOriginalExtension();
                      $request->image->move(public_path('theme/aboutusimg'), $imageName);
                      $aboutusprofile->image=$imageName;
                    }

                    $aboutusprofile->pname=$request->pname;
                    $aboutusprofile->ptext=$request->ptext;
                    $aboutusprofile->update();

                    return redirect()->route('aboutusprofile.index')->withSuccess('You have successfully updated Aboutus profile section!');

       } catch (\Throwable $th) {
        return error_json($th);
       }
    }
}
