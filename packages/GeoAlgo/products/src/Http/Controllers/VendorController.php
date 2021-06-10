<?php

namespace GeoAlgo\Products\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GeoAlgo\Products\Models\Product;
use GeoAlgo\Products\Models\Category;
use GeoAlgo\Products\Models\VendorAddress;
use GeoAlgo\Products\Models\ProductCategory;
use GeoAlgo\Products\Models\Order;
use GeoAlgo\Products\Models\Order_details;
use GeoAlgo\Products\Models\Item;
use GeoAlgo\Products\Models\Assignorder;
use GeoAlgo\Products\Models\Brand;
use App\Models\Company;
use App\Models\User;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;
use Log;

class VendorController extends Controller
{
    public function show()
    {
        try {
             return view('products::vendor.show');
        } catch (\Exception $e) {
        	return error_json($e);
        }
    }

    public function store(Request $request)
    {
      //  print_r($request->all());die;
        try {
            $userData = array('name' => $request->username, 'is_admin' => 2,'email' => $request->email,'password' => Hash::make($request->password));
            $userId = User::create($userData)->id;
            try {
                User::where('id',$userId)->update(['is_admin' => 2 ,'mobile' => $request->phone]);
                $imageName = time().'.'.$request->vendor_logo->getClientOriginalExtension();
                $request->vendor_logo->move(public_path('VendorLogo'), $imageName);

                $vendorAddress = array('user_id' => $userId, 'type_establishment' => $request->type_establishment,'reg_address' => $request->reg_address,
                            'shi_address' => $request->shi_address,'authorised_person' =>$request->authorised_person,'authorised_contact' =>$request->authorised_contact,
                            'authorised_email' =>$request->authorised_email,'product_category' =>implode(",",$request->product_category),'commercial_terms' =>$request->commercial_terms,
                            'gst' =>$request->gst,'HSN_codes' =>$request->HSN_codes,'shipping_type' =>$request->shipping_type,'vendor_logo' => $imageName);
                $vendorId = VendorAddress::create($vendorAddress)->id;
                try {

                    $brandImage = time().'.'.$request->brand_image->getClientOriginalExtension();
                    $request->brand_image->move(public_path('Bimages'), $brandImage);
                    $brand = array('user_id'=>$userId ,'name' => $request->brand_name,'image' => $brandImage,'percentage' => $request->percentage);
                    $brand_id = Brand::create($brand)->id;
                    return view('products::brand.index');
                } catch (\Exception $th) {
                    Log::error($th);
                    VendorAddress::where('id',$vendorId)->delete();
                    User::where('id',$userId)->delete();
                    return redirect()->back()->with('error', 'Something wrong, please try once');
                }
            } catch (\Exception $th) {
                User::where('id',$userId)->delete();
                return redirect()->back()->with('error', 'Vendor Not Created , please try once');
            }
        } catch (\Exception $th) {
            //print_r($th);die;
           // echo $th->getMessage();die;
           Log::error($th);
            return redirect()->back()->with('error',  $th->getMessage());
        }
    }

    public function vendorLogin(Request $request)
    {
        return view('products::vendor.login');
    }

    public function login(Request $request)
    {
       if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        $user = Auth::user();
        return redirect()->route('admin.dashboard');
        }else {
            return redirect()->route('products::vendor.login');
        }
    }
}
