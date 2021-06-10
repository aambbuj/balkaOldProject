<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserAddress;
use GeoAlgo\Products\Models\Order_details;
use GeoAlgo\Products\Models\Order;
use DB;
use DataTables;
use Carbon\Carbon;

class UserController extends Controller
{
    
    public function showLoginForm()
    {
        return view('customer.log-in');
    }

    public function showSignupForm()
    {
        return view('customer.sign-up');
    }

    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm_password'
          ]);
        if ($validator->fails()) {
            return error_json($validator->errors()->first());
        }
        $fullname = $request->f_name . ' ' . $request->l_name;
        $user = new User();
        $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;
        $user->name = $fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('customer.dashboard');
    }
    
    public function signIn(Request $request) {

        if(Auth::attempt(['email' => request('email'), 'password' => request('password'), 'is_admin' => 0])){ 
            $user = Auth::user(); 
            return redirect()->route('customer.dashboard');
        } 
        else{ 
            return redirect()->route('customer.log-in'); 
        }
    }

    public function index()
    {
        return view('customer.dashboard-overview');
    }

    public function showprofile()
    {
        $user = User::where('id',auth()->user()->id)->first();
        $addresses = UserAddress::where('user_id',auth()->user()->id)->get();
        // echo "<pre>";
        // print_r($addresses);die;
        return view('customer.dashboard-profile',['user'=>$user,'addresses'=>$addresses]);
    }

    public function updateprofile(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'mobile' => 'required|numeric',
            'dob' => 'required|date'
          ]);
        if ($validator->fails()) {
            return error_json($validator->errors()->first());
        }
        $fullname = $request->f_name . ' ' . $request->l_name;
        $user = User::find($id);
        $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;
        $user->name = $fullname;
        $user->mobile = $request->mobile;
        $user->dob = $request->dob;
        if($request->password && $request->password!='')
        {
            $user->password = Hash::make($request->password);
        }
        $user->update();

        return redirect()->route('customer.profile');
    }

    public function addAddress(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'address1' => 'required|string|min:3|max:255',
            'address2' => 'required|string|min:3|max:255',
            'city' => 'required|string|min:3|max:50',
            'state' => 'required|string|min:3|max:50',
            'postal_code' => 'required|string|min:3|max:20',
            'country' => 'required|string|min:3|max:30'
          ]);
        if ($validator->fails()) {
            return error_json($validator->errors()->first());
        }
        $address = new UserAddress();
        $address->user_id=$id;
        $address->address1 = $request->address1;
        $address->address2 = $request->address2;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->postal_code = $request->postal_code;
        $address->country = $request->country;
        $address->save();

        return redirect()->route('customer.profile');
    }

    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address1' => 'required|string|min:3|max:255',
            'address2' => 'required|string|min:3|max:255',
            'city' => 'required|string|min:3|max:50',
            'state' => 'required|string|min:3|max:50',
            'postal_code' => 'required|string|min:3|max:20',
            'country' => 'required|string|min:3|max:30'
          ]);
        if ($validator->fails()) {
            return error_json($validator->errors()->first());
        }
        $address = UserAddress::find($request->id);
        $address->address1 = $request->address1;
        $address->address2 = $request->address2;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->postal_code = $request->postal_code;
        $address->country = $request->country;
        $address->update();

        return redirect()->route('customer.profile');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function orderDetails(Request $request)
    {
        return view('customer.dashboard-order');
    }

    public function getOrderHistory(Request $request)
    {
        $orders = Order::where('user_id',Auth::id())->with('orderDetails')->get();
        return response()->json(['orders' => $orders ]);
    }
}
