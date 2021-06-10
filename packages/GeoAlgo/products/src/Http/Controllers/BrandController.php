<?php

namespace GeoAlgo\Products\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GeoAlgo\Products\Models\Category;
use GeoAlgo\Products\Models\Brand;
use GeoAlgo\Products\Models\VendorAddress;
use App\Models\User;
use Validator;
use DataTables;
use Log;

class BrandController extends Controller
{
    public function index()
    {
        try {             

              return view('products::brand.index');

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

    public function list()
    {
        try {
              $allBrands = Brand::where("deleted",0)->orderBy('id','DESC');

              return DataTables::of($allBrands)
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
            $brand = array();
              if($request->edit == true){
                $brandData = Brand::find($request->id);

                 $brand =  User::where('id',$brandData->user_id)->with('brand','VendorAddress')->first();

              }
            //   echo "<pre>";
            //   print_r($brand);
            //   die();
        	return view('products::brand.create', ["brand"=>$brand, "edit"=>$request->edit]);
        }catch(\Exeption $e){
        	return response()->json($e->getMessage());
        }
    }

    public function store(Request $request)
    {   
        try {
            $userData = array('name' => $request->username,'email' => $request->email,'mobile' => $request->phone);
           
            User::where('id',$request->user_id)->update($userData);
            
            try {
                $imageName = null;
                if ($request->vendor_logo) {
                    $imageName = time().'.'.$request->vendor_logo->getClientOriginalExtension();
                    $request->vendor_logo->move(public_path('VendorLogo'), $imageName);
                }

                $vendorAddress = array('type_establishment' => $request->type_establishment,'reg_address' => $request->reg_address,
                            'shi_address' => $request->shi_address,'authorised_person' =>$request->authorised_person,'authorised_contact' =>$request->authorised_contact,
                            'authorised_email' =>$request->authorised_email,'commercial_terms' =>$request->commercial_terms,
                            'gst' =>$request->gst,'HSN_codes' =>$request->HSN_codes,'shipping_type' =>$request->shipping_type,'vendor_logo' => $imageName);

               // return success_json($vendorAddress, "Brand Update successfully");

                $vendorId = VendorAddress::where('id',$request->vendor_id)->update($vendorAddress);
              //  return success_json($vendorId, "Brand Update successfully");
                try {
                    $brandImage = null;
                    if ($request->brand_image) {
                        $brandImage = time().'.'.$request->brand_image->getClientOriginalExtension();
                        $request->brand_image->move(public_path('Bimages'), $brandImage);
                    }

                    $brand = array('name' => $request->brand_name,'image' => $brandImage,'percentage' => $request->percentage);
                    $brand_id = Brand::where('id',$request->brand_id)->update($brand);
                    return success_json($brand_id, "Brand Update successfully");
                } catch (\Exception $th) {
                    return error_json($th);

                    // return redirect()->back()->with('error', 'Something wrong, please try once');
                }
            } catch (\Exception $th) {
                return error_json($th);

                // return redirect()->back()->with('error', 'Vendor Not Created , please try once');
            }
        } catch (\Exception $th) {
            //print_r($th);die;
           // echo $th->getMessage();die;
           return error_json($th);
        }
    }

    public function editProfile(Request $request)
    {
        $brand =  User::where('id',auth()->user()->id)->where('is_admin','2')->with('brand','VendorAddress')->first();
        return view('products::profile.edit', ["brand"=>$brand, "edit"=>true]);
    }

    public function profileStore(Request $request)
    {
        try {
            $userData = array('name' => $request->username,'email' => $request->email,'mobile' => $request->phone);
           
            User::where('id',$request->user_id)->update($userData);
            
            try {
                $imageName = null;
                if ($request->vendor_logo) {
                    $imageName = time().'.'.$request->vendor_logo->getClientOriginalExtension();
                    $request->vendor_logo->move(public_path('VendorLogo'), $imageName);
                }

                $vendorAddress = array('type_establishment' => $request->type_establishment,'reg_address' => $request->reg_address,
                            'shi_address' => $request->shi_address,'authorised_person' =>$request->authorised_person,'authorised_contact' =>$request->authorised_contact,
                            'authorised_email' =>$request->authorised_email,'commercial_terms' =>$request->commercial_terms,
                            'gst' =>$request->gst,'HSN_codes' =>$request->HSN_codes,'shipping_type' =>$request->shipping_type,'vendor_logo' => $imageName);

               // return success_json($vendorAddress, "Brand Update successfully");

                $vendorId = VendorAddress::where('id',$request->vendor_id)->update($vendorAddress);
              //  return success_json($vendorId, "Brand Update successfully");
                try {
                    $brandImage = null;
                    if ($request->brand_image) {
                        $brandImage = time().'.'.$request->brand_image->getClientOriginalExtension();
                        $request->brand_image->move(public_path('Bimages'), $brandImage);
                    }

                    $brand = array('name' => $request->brand_name,'image' => $brandImage,'percentage' => $request->percentage);
                    $brand_id = Brand::where('id',$request->brand_id)->update($brand);
                    return redirect()->back()->with('success', 'Profile Update Successfully!');
                } catch (\Exception $th) {
                    return error_json($th);

                    // return redirect()->back()->with('error', 'Something wrong, please try once');
                }
            } catch (\Exception $th) {
                return error_json($th);

                // return redirect()->back()->with('error', 'Vendor Not Created , please try once');
            }
        } catch (\Exception $th) {
            //print_r($th);die;
           // echo $th->getMessage();die;
           return error_json($th);
        }
    }
    
    // public function store(Request $request)
    // {

    //     try{
        	 
    //          if($request->edit == true || $request->edit == "true"){

    //             $validator = Validator::make($request->all(), [
    //               'name'      => 'required|min:3|max:255|string',
    //               'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    //             ]);
    //             $brand = Brand::find($request->id);
    //          }else{

    //             $validator = Validator::make($request->all(), [
    //               'name'      => 'required|min:3|max:255|string',
    //               'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    //             ]);
    //             $brand=new Brand();
    //          }
    //          if ($validator->fails()) {
    //             return error_json($validator->errors()->first());
    //          }
    //          //Category::create($validatedData);
    //          if($request->hasfile('image'))
    //          {
    //           $imageName = time().'.'.$request->image->getClientOriginalExtension();
    //             $request->image->move(public_path('Bimages'), $imageName);
    //             $brand->image=$imageName;
    //          }
             
    //          $brand->name=request('name');
    //          $brand->created_by=auth()->user()->id;
             
    //          if($brand->save()){
    //           return success_json($brand, "Brand created successfully");
    //         }else{
    //           return error_json("Brand cannot created!");
    //         }

    //     }catch(\Exeption $e){
    //     	return error_json($e);
    //     }

    // }

    public function delete(Request $request){
        try {
            
            $category=Brand::where('id',$request->id)->update(['deleted'=>1]);
            return success_json($category, "Brand deleted successfully");
        } catch (\Exception $e) {
            return error_json($e);
        }
    }
}
