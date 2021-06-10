<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contactus;
use App\Models\ContactusImage;
use DB;
use Validator;

class ContactusController extends Controller
{
    public function index()
    {
        $contactuses = Contactus::where('deleted',0)->get();
        $contactimgs = ContactusImage::where('deleted',0)->get();
        // echo "<pre>";
        // print_r($contactuses);die;
        return view('contactus.contactus',['contactuses'=>$contactuses,'contactimgs'=>$contactimgs]);
    }

    public function showContactus()
    {
        $contactuses = Contactus::where('deleted',0)->get();
        return view('contactus.index',['contactuses'=>$contactuses]);
    }

    public function editContactus($id = 0)
    {
        $contactus=Contactus::find($id);
        return view('contactus.edit',['contactus'=>$contactus]);
    }

    public function updateContactus(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'text' => 'required|min:3|max:255|string',
                    'url' => 'required|min:3|max:255|string',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('contactus.edit', $id)->withErrors($validator)->withInput();
                }
                  $contactus=Contactus::find($id); 

                //   if($request->hasfile('image'))
                //   {
                //       $imageName = time().'.'.$request->image->getClientOriginalExtension();
                //       $request->image->move(public_path('theme/contactusimg'), $imageName);
                //       $contactus->image=$imageName;
                //     }  

                    $contactus->text=$request->text;
                    $contactus->url=$request->url;
                    $contactus->update();

                    return redirect()->route('contactus.index')->withSuccess('You have successfully updated Contact us section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showContactusImage()
    {
        $contactusimages = ContactusImage::where('deleted',0)->get();
        return view('contactus.image.index',['contactusimages'=>$contactusimages]);
    }

    public function editContactusImage($id = 0)
    {
        $contactusimage=ContactusImage::find($id);
        return view('contactus.image.edit',['contactusimage'=>$contactusimage]);
    }

    public function updateContactusImage(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('contactusimage.edit', $id)->withErrors($validator)->withInput();
                }
                  $contactusimage=ContactusImage::find($id); 

                  if($request->hasfile('image'))
                  {
                      $imageName = time().'.'.$request->image->getClientOriginalExtension();
                      $request->image->move(public_path('theme/contactusimg'), $imageName);
                      $contactusimage->image=$imageName;
                    }  

                    $contactusimage->update();

                    return redirect()->route('contactusimage.index')->withSuccess('You have successfully updated Contact us image section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }
}
