<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use GeoAlgo\Products\Models\Order_details;
use GeoAlgo\Products\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Gst;
use App\Models\ShippingCharges;
use App\Models\UserAddress;
use App\Models\PickeerOrderDetails;
use App\Models\Checkout;
use GeoAlgo\Products\Models\Payment;
use GeoAlgo\Products\Models\Coupon;
use GeoAlgo\Products\Models\ProductCategory;
use GeoAlgo\Products\Models\CouponApplyed;
use GeoAlgo\Products\Models\Product;
use GeoAlgo\Products\Models\AttributeValue;
use GeoAlgo\Products\Models\Attribute;
use Razorpay\Api\Api;
use Session;
use Redirect;
use Illuminate\Support\Facades\Cookie;
use Auth;
use Log;

use App\Http\Traits\PikerrTraits;

class CartController extends Controller
{
    use PikerrTraits;

    public function cartDetails()
    {
        $machin_ip = getHostByName(getHostName()); ///////get machin ip ..................
        $cartIds = Cart::where('machin_ip',$machin_ip)->pluck('id');
        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
        $cart_data = json_decode($cookie_data, true);
        $user=[];
        $user = User::where('id',Auth::id())->with('address')->first();
        // echo "<pre>";
        // print_r($cart_data);
        // die;
        return view('cart.cart_details')
            ->with('cart_data',$cart_data)->with('carts',$cartIds)->with('user',$user);
    }

    public function getData()
    {
        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
        $cart_data = json_decode($cookie_data, true);

        $machin_ip = getHostByName(getHostName()); //////Get machin Ip Address////////////////
        $shipping_charge = 0;
        foreach($cart_data as $keys => $values)
        {
            $totalPrice  =  $cart_data[$keys]['price'] * $cart_data[$keys]['qty'];
            if($totalPrice >= 1000){
                $shipping_charge = 0;
            }

            if($totalPrice < 1000){
                $shipping_charge = ShippingCharges::where('machin_ip',$machin_ip)->where('vendor_id',$cart_data[$keys]['vendor_id'])->where('product_id',$cart_data[$keys]['product_id'])->where('category_id',$cart_data[$keys]['category_id'])->where('attribute_id',$cart_data[$keys]['attribute_id'])->where('attribute_value_id',$cart_data[$keys]['attribute_value_id'])->value('shipping_charge');
            }
                $cart_data[$keys]["shipping_charge"] = $shipping_charge;
                $item_data = json_encode($cart_data);
                //$minutes = 3000;
                $minutes = time() + (10 * 365 * 24 * 60 * 60);
                Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));
                $cookie_data2 = stripslashes(Cookie::get('shopping_cart'));
                $cart_data2 = json_decode($cookie_data2, true);
        }
        return response()->json(['data'=>$cart_data2]);
    }

    public function addtocart(Request $request , $product=null)
    {
        $prod_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        if(Cookie::get('shopping_cart'))
        {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);
        }
        else
        {
            $cart_data = array();
        }

        
        // print_r($cart_data);
        // die();

        $item_id_list = array_column($cart_data, 'item_id');
        $prod_id_is_there = $prod_id;

        if(in_array($prod_id_is_there, $item_id_list))
        {
            $category_id_list = array_column($cart_data, 'category_id');
            $category_id_there = $request->category_id;

            if (in_array($category_id_there, $category_id_list)) {

                $attribute_id_list = array_column($cart_data, 'attribute_id');
                $attribute_id_there = $request->attribute_id;

                if (in_array($attribute_id_there,$attribute_id_list)) {

                        $attribute_value_id_list = array_column($cart_data, 'attribute_value_id');
                        $attribute_value_id_there = $request->attribute_value_id;

                    if (in_array($attribute_value_id_there, $attribute_value_id_list)) {
                            foreach($cart_data as $keys => $values)
                            {
                                return response()->json(['status'=> false , 'msg'=> 'Already Added to Cart']);                
                            }
                    } else {
                        $this->AddCartTableAndSetCoo($request);
                        return response()->json(['status'=>true,'msg'=> 'Added to Cart','data'=>'cart.details','data'=>url('/').'/cart']);
                    }
                    
                } else {
                    $this->AddCartTableAndSetCoo($request);
                    return response()->json(['status'=>true,'msg'=> 'Added to Cart','data'=>'cart.details','data'=>url('/').'/cart']);   

                }
                
            }
            else{
                $this->AddCartTableAndSetCoo($request);
                return response()->json(['status'=>true,'msg'=> 'Added to Cart','data'=>'cart.details','data'=>url('/').'/cart']);
            }
        }
        else
        {
            $machin_ip = getHostByName(getHostName());
            $product = Product::find($prod_id);
            $prod_name = $product->name;
            $prod_image = $product->image;
            $priceval = $product->price;

            if($product)
            {
                $item_array = array(
                    'item_id' => $prod_id,
                    // 'user_id' => 1,
                    'vendor_id' => $product->created_by,
                     'product_id' => $product->id,
                     'machin_ip' => $machin_ip,
                     'shipping_charge' => 0,
                     'category_id' => $request->category_id,
                     'attribute_id' => $request->attribute_id,
                     'attribute_value_id' => $request->attribute_value_id,
                     'total_price' => $product->unit_price * $quantity,
                     'product_name' => $product->product_name,
                     'created_by' => $product->created_by,
                     'qty' => $quantity,
                     'price' => $product->unit_price,
                     'image' => $product->image
                );
                $cart_data[] = $item_array;
                unset($item_array['item_id']);
                Cart::create($item_array);
                $item_data = json_encode($cart_data);
                $minutes = time() + (10 * 365 * 24 * 60 * 60);
                Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));

            //////////////////   Set Shepping Charges /////////////////////////////////
            
            $user = User::where('id',Auth::id())->with('address')->first();
            $vendor = User::where('id',$product->created_by)->with('address')->first();
            $sheppingDetails = array (
                'shipment_type' => 'forward',
                'pickup_pincode' => $user ? $vendor->address->postal_code : '',
                'drop_pincode' => $user ? $user->address->postal_code : '',
                'delivery_mode' => 'express',
                'payment_mode' => 'prepaid',
                );


            $totalAmount = 0;
            $vendorArray = [];
          //  for ($i=0; $i <count($resent_data) ; $i++) { 
                //if ($product->created_by == $vendor->id) {
                    $totalAmount = $totalAmount + ($product->unit_price * $quantity);
                    $vendorArray[$vendor->id] = $totalAmount;
                    if ($vendorArray[$vendor->id] >= 1000) {
                        $highSheppingCharge = 0;
                        
                        $cart_data[0]["shipping_charge"] = $highSheppingCharge;
                        $item_data = json_encode($cart_data);
                        $minutes = time() + (10 * 365 * 24 * 60 * 60);
                        Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));
                    }
                    if ($vendorArray[$vendor->id] < 1000) {
                        $sheppingChargeJson = $this->checkSheppingCharges($sheppingDetails);
                        $sheppingCharge = json_decode($sheppingChargeJson , TRUE);
              
                        if (!empty($sheppingCharge['rate_list'])) {

                            $highSheppingCharge = max(array_column($sheppingCharge['rate_list'], 'delivered_charges'));
                            $shippingZone=null;
                            for ($i=0; $i <count($sheppingCharge['rate_list']); $i++) { 
                                if ($highSheppingCharge == $sheppingCharge['rate_list'][$i]['delivered_charges']) {
                                    $shippingZone = $sheppingCharge['rate_list'][$i];
                                }
                                
                            }
                            $shippingArray = array(
                                'vendor_id' => $product->created_by,
                                'product_id' => $product->id,
                                'machin_ip' => $machin_ip,
                                'user_id' => $user ? $user->id : null,
                                'shipping_charge' => $highSheppingCharge,
                                'category_id' => $request->category_id,
                                'attribute_id' => $request->attribute_id,
                                'attribute_value_id' => $request->attribute_value_id,
                                'billing_zone' => $sheppingCharge['billing_zone'],
                                'courier_id' => $shippingZone['courier_id'],
                                'courier' => $shippingZone['courier'],
                                'returned_charges' => $shippingZone['returned_charges'],
                            );
                            ShippingCharges::create($shippingArray);
                            Cart::where('machin_ip',$machin_ip)->where('vendor_id',$vendor->id)->update(['shipping_charge' => $highSheppingCharge]);

                            $cart_data[0]["shipping_charge"] = $highSheppingCharge;
                            $item_data = json_encode($cart_data);
                            $minutes = time() + (10 * 365 * 24 * 60 * 60);
                            Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));

                        }
                        if (empty($sheppingCharge['rate_list'])) {
                            $highSheppingCharge = 57;

                            $shippingArray = array(
                                'vendor_id' => $product->created_by,
                                'product_id' => $product->id,
                                'machin_ip' => $machin_ip,
                                'user_id' => $user ? $user->id : null,
                                'shipping_charge' => $highSheppingCharge,
                                'category_id' => $request->category_id,
                                'attribute_id' => $request->attribute_id,
                                'attribute_value_id' => $request->attribute_value_id,
                                'billing_zone' => 'A',
                                'courier_id' => 123,
                                'courier' => 'any',
                                'returned_charges' => 70,
                            );
                           ShippingCharges::create($shippingArray);
                           Cart::where('machin_ip',$machin_ip)->where('vendor_id',$vendor->id)->update(['shipping_charge' => $highSheppingCharge]);
                        
                           $cart_data[0]["shipping_charge"] = $highSheppingCharge;
                           $item_data = json_encode($cart_data);
                           $minutes = time() + (10 * 365 * 24 * 60 * 60);
                           Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));
                        }
                    }

                return response()->json(['status'=>true,'msg'=> 'Added to Cart','data'=>'cart.details','data'=>url('/').'/cart']);
            }
        }
    }

    public function AddCartTableAndSetCoo(Request $request)
    {
 
        if(Cookie::get('shopping_cart'))
        {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);
        }
        else
        {
            $cart_data = array();
        }

        $machin_ip = getHostByName(getHostName()); //////Get machin Ip Address////////////////

        $prod_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $product = Product::find($prod_id);

        if($product)
        {
            $item_array = array('item_id' => $prod_id,'vendor_id' => $product->created_by,'product_id' => $product->id,'machin_ip' => $machin_ip,'shipping_charge' => 0,'category_id' => $request->category_id,'attribute_id' => $request->attribute_id,'attribute_value_id' => $request->attribute_value_id,'total_price' => $product->unit_price * $quantity,'product_name' => $product->product_name,'created_by' => $product->created_by,'qty' => $quantity,'price' => $product->unit_price,'image' => $product->image );
            $cart_data[] = $item_array;
            unset($item_array['item_id']);
            Cart::create($item_array);
            $item_data = json_encode($cart_data);
            $minutes = time() + (10 * 365 * 24 * 60 * 60);
            Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));

            //////////////////   Set Shepping Charges /////////////////////////////////
            
            $user = User::where('id',Auth::id())->with('address')->first();
            $vendor = User::where('id',$product->created_by)->with('address')->first();
            $sheppingDetails = array (
                'shipment_type' => 'forward',
                'pickup_pincode' => $user ? $vendor->address->postal_code : '',
                'drop_pincode' => $user ? $user->address->postal_code : '',
                'delivery_mode' => 'express',
                'payment_mode' => 'prepaid',
                );
    
            // $resent = stripslashes(Cookie::get('shopping_cart'));
            // $resent_data = json_decode($resent, true);
            $totalAmount = 0;
            $vendorArray = [];
            $highSheppingCharge = 0;
            $resent_data = Cart::where('machin_ip',$machin_ip)->get()->toArray();

            for ($i=0; $i <count($resent_data) ; $i++) { 
                if ($resent_data[$i]['vendor_id'] == $vendor->id) {
                    $totalAmount = $totalAmount + $resent_data[$i]['total_price'];
                    $vendorArray[$vendor->id] = $totalAmount;
                

                    $totalprice = Cart::where('machin_ip',$machin_ip)->where('vendor_id',$vendor->id)->get()->sum('total_price');


                    if ($totalprice >= 1000) {
                        $highSheppingCharge = 0;

                        $cart_data[$i]["shipping_charge"] = 0;
                        $item_data = json_encode($cart_data);
                        $minutes = time() + (10 * 365 * 24 * 60 * 60);
                        Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));

                        //ShippingCharges::where('machin_ip',$machin_ip)->where('vendor_id',$vendor->id)->delete();
                        Cart::where('machin_ip',$machin_ip)->where('vendor_id',$vendor->id)->update(['shipping_charge' => 0]);

                       // return true;
                    }
                    if ($totalprice < 1000) {
                        $sheppingChargeJson = $this->checkSheppingCharges($sheppingDetails);
                        $sheppingCharge = json_decode($sheppingChargeJson , TRUE);
                        
                        if (!empty($sheppingCharge['rate_list'])) {
                            
                            $highSheppingCharge = max(array_column($sheppingCharge['rate_list'], 'delivered_charges'));
                            $shippingZone=null;
                   
                            for ($i=0; $i <count($sheppingCharge['rate_list']) ; $i++) { 
                                if ($highSheppingCharge == $sheppingCharge['rate_list'][$i]['delivered_charges']) {
                                    $shippingZone = $sheppingCharge['rate_list'][$i];
                                }
                                
                            }
                            $shippingArray = array('vendor_id' => $product->created_by,'product_id' => $product->id,'machin_ip' => $machin_ip,'user_id' => $user ? $user->id : null,'shipping_charge' => $highSheppingCharge,'category_id' => $request->category_id,'attribute_id' => $request->attribute_id,'attribute_value_id' => $request->attribute_value_id,'billing_zone' => $sheppingCharge['billing_zone'],'courier_id' => $shippingZone['courier_id'],'courier' => $shippingZone['courier'],'returned_charges' => $shippingZone['returned_charges'],);
                            ShippingCharges::create($shippingArray);
                            Cart::where('machin_ip',$machin_ip)->where('vendor_id',$vendor->id)->update(['shipping_charge' => $highSheppingCharge]);

                            $cart_data[$i]["shipping_charge"] = $highSheppingCharge;
                            $item_data = json_encode($cart_data);
                            $minutes = time() + (10 * 365 * 24 * 60 * 60);
                            Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));

                        }
                        if (empty($sheppingCharge['rate_list'])) {
                                    $highSheppingCharge = 57;
                                    $shippingArray = array('vendor_id' => $product->created_by,'product_id' => $product->id,'machin_ip' => $machin_ip,'user_id' => $user ? $user->id : null,'shipping_charge' => $highSheppingCharge,'category_id' => $request->category_id,'attribute_id' => $request->attribute_id,'attribute_value_id' => $request->attribute_value_id,'billing_zone' => 'A','courier_id' => '1234','courier' => 'any','returned_charges' => 'any');

                                    ShippingCharges::create($shippingArray);
                                    Cart::where('machin_ip',$machin_ip)->where('vendor_id',$vendor->id)->update(['shipping_charge' => $highSheppingCharge]);
                                  
                                    $cart_data[$i]["shipping_charge"] = $highSheppingCharge;
                                    $item_data = json_encode($cart_data);
                                    $minutes = time() + (10 * 365 * 24 * 60 * 60);
                                    Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));
                                }
                        }
                    }
                }

            return true;
            // return response()->json(['status'=>true,'msg'=> 'Added to Cart','data'=>'cart.details','data'=>url('/').'/cart']);
        }
    }

    public function cartloadbyajax(Request $request)
    {
        if(Cookie::get('shopping_cart'))
        {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);
            $totalcart = count($cart_data);

            echo json_encode(array('totalcart' => $totalcart)); die;
            return;
        }
        else
        {
            $totalcart = "0";
            echo json_encode(array('totalcart' => $totalcart)); die;
            return;
        }
    }

    public function deletefromcart(Request $request)
    {      
        $index = $request->input('product_id');
        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
        $cart_data = json_decode($cookie_data, true);
        foreach($cart_data as $keys => $values)
        {
            if($keys == $index) {
              array_splice($cart_data, $index, 1);
              
              Checkout::where('cart_id',$request->cart_id)->delete();
              Cart::where('id',$request->cart_id)->delete();
              //return response()->json(['status'=>'Item Removed from Cart','data'=> $cart_data]);
              $item_data = json_encode($cart_data);
              $minutes = time() + (10 * 365 * 24 * 60 * 60);
              Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));
              $cookie_data = stripslashes(Cookie::get('shopping_cart'));
              $cart_data = json_decode($cookie_data, true);
              return response()->json(['status'=>'Item Removed from Cart','data'=> $request->cart_id]);
            }
        }


        $prod_id = $request->input('product_id');

        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
        $cart_data = json_decode($cookie_data, true);

        $item_id_list = array_column($cart_data, 'item_id');
        $prod_id_is_there = $prod_id;

        if(in_array($prod_id_is_there, $item_id_list))
        {
            foreach($cart_data as $keys => $values)
            {
                if($cart_data[$keys]["item_id"] == $prod_id)
                {
                  //  unset($cart_data[$keys]);
                  array_splice($cart_data, 1, 1);
                    $item_data = json_encode($cart_data);
                    $minutes = time() + (10 * 365 * 24 * 60 * 60);
                    Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                    $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                    $cart_data = json_decode($cookie_data, true);
                    return response()->json(['status'=>'Item Removed from Cart','data'=> $cart_data]);
                }
            }
        }
    }

    public function clearcart()
    {
        $machin_ip = getHostByName(getHostName()); //////Get machin Ip Address////////////////

        Cookie::queue(Cookie::forget('shopping_cart'));
        Cart::where('machin_ip',$machin_ip)->delete();
        return response()->json(['status'=>'Your Cart is Cleared']);
    }

    public function applyCoupan(Request $request)
    {
        $couponDiscountBalance = 0;
        $sheppingCharge=[];
        $couponDetails=[];
        $sheppingUser = null;
 
            $couponData  = Coupon::where('coupon_code',$request->coupon_code)->with('coupons')->first();
            if (!empty($couponData)) {

                $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                $ifExistsCart = json_decode($cookie_data, true);
                if(!empty($ifExistsCart)){
                    
                      ////////////////////// Get all product category for created by coupon code  ///////////////////////
                        $vendorOrAdminProduct  = ProductCategory::where('created_by',$couponData->user_id)->get();

                        foreach($vendorOrAdminProduct as $adminVendorProduct){

                            foreach($ifExistsCart as $key =>  $cartData){
                                    //////////////  check coupon valid or not //////////////////////////////////
                                if ($couponData->min_price >= $cartData['total_price'] && $couponData->max_price >= $cartData['total_price'] && $couponData->exp_date >= date("Y-m-d") ) { 
                                    ////////////////// for vendor section //////////////////////////////////////
                                    if(User::where('id',$couponData->user_id)->where('is_admin',2)->value('id')){
                                        /////// check coupon product details  with cart product details //////////////////////
                                            foreach ($couponData->coupons as $productCoupon) {
                                                ///////// check selected product exists or not on same vendor/////////////////////
                                                if ($adminVendorProduct->product_id == $cartData['product_id'] && $adminVendorProduct->category_id == $cartData['category_id']) {

                                                    if ($productCoupon->category_id == $cartData['category_id'] && $productCoupon->product_id == $cartData['product_id']) {
                                            
                                                            if ($cartData['created_by'] == $couponData->user_id) {
                                                                $sheppingCharge[$key] = [$cartData['total_price'],$couponData->user_id];
                                                            }
                                                        $couponDiscountBalance = $couponData->coupon_value;
                                                        $couponDetails[] = array('user_id' => $couponData->user_id,'coupon_id' => $couponData->id,'product_id' => $cartData['product_id'] , 'category_id' => $cartData['category_id'] ,'coupon_code' =>$couponData->coupon_code, 'price' => $productCoupon->price);

                                                    } 
                                                }  
                                                if ($adminVendorProduct->product_id == $cartData['product_id']) {
                                                
                                                    if ($productCoupon->category_id != $cartData['category_id'] && $productCoupon->product_id == $cartData['product_id']) {
                                                        
                                                        if ($cartData['created_by'] == $couponData->user_id) {
                                                            $sheppingCharge[$key] = [$cartData['total_price'],$couponData->user_id];
                                                        }

                                                        $couponDiscountBalance = $couponData->coupon_value;
                                                        $couponDetails[] = array('user_id' => $couponData->user_id,'coupon_id' => $couponData->id,'product_id' => $cartData['product_id'] , 'category_id' => $cartData['category_id'] ,'coupon_code' =>$couponData->coupon_code, 'price' => $productCoupon->price);

                                                    } 
                                                }
                                                if ($adminVendorProduct->category_id == $cartData['category_id']) {
                                                
                                                    if ($productCoupon->category_id == $cartData['category_id'] && $productCoupon->product_id != $cartData['product_id']) {

                                                        if ($cartData['created_by'] == $couponData->user_id) {
                                                            $sheppingCharge[$key] = [$cartData['total_price'],$couponData->user_id];
                                                        }

                                                        $couponDiscountBalance = $couponData->coupon_value;
                                                        $couponDetails[] = array('user_id' => $couponData->user_id,'coupon_id' => $couponData->id,'product_id' => $cartData['product_id'] , 'category_id' => $cartData['category_id'] ,'coupon_code' =>$couponData->coupon_code, 'price' => $productCoupon->price);

                                                    } 
                                                }
                                            }
                                       
                                    }
                                    else{

                                        ////////////// Admin coupon applyed for all product and category //////////////////////////

                                        if (User::where('id',$couponData->user_id)->where('is_admin',1)->value('id')) {
                                            ////////// count total coupon balance //////////////////////////

                                            if ($cartData['created_by'] == $couponData->user_id) {
                                                $sheppingCharge[$key] = [$cartData['total_price'],$couponData->user_id];
                                            }
                                            $couponDiscountBalance = $couponData->coupon_value;
                                            $couponDetails[] = array('user_id' => $couponData->user_id,'coupon_id' => $couponData->id,'product_id' => $cartData['product_id'] , 'category_id' => $cartData['category_id'] ,'coupon_code' =>$couponData->coupon_code, 'price' => $couponData->coupon_value);
                                        }   
                                    }

                                }else{
                                    return response()->json(['status'=>'Invalid Coupon Code' ,'msg' => 'your coupon id invid or minimum price must be '.$couponData->min_price]);

                                }
                            }

                        }

                }else{
                 return response()->json(['status'=>'Your cart is empty' ,'data' => false]);
                }

               
            } else {
                return response()->json(['status'=>'Invalid Coupon Code' ,'data' => false]);

            }
            
        if ($couponDiscountBalance || $adminCouponValue > 0) {
            $totalCouponValue = 0;
            try {
                foreach ($ifExistsCart as  $coupon) {
                    foreach($couponDetails as $key => $couponDetail){
                        if ( ($coupon['category_id'] == $couponDetail['category_id'] && $coupon['product_id'] == $couponDetail['product_id'] )) {
                            $couponIds = CouponApplyed::where('user_id',$couponDetail['user_id'])->where('category_id',$coupon['category_id'])->where('product_id',$coupon['product_id'])->count();
                             //return response()->json($coupon);
                            if ($couponIds == 0 ) {
                                $data = array('user_id' => $couponDetail['user_id'] , 'category_id' => $coupon['category_id'] , 'product_id' => $coupon['product_id'] , 'coupon_code' => $request->coupon_code, 'price' => $couponDiscountBalance);
                                CouponApplyed::insert($data);
                            }                                
                        }
                    }
                }
                return response()->json(['status'=>true ,'coupon_value' => $couponDiscountBalance == 0 ? $adminCouponValue : $couponDiscountBalance ,'type' => $couponData->type,'coupon_code' => $request->coupon_code]);       

            } catch (\Exception $th) {
                return response()->json($th);       
            }
         } 
         else {
            return response()->json(['msg'=>'This coupone code not applicable to this product' ,'data' => 0]);
        }
    }

    public function updateCart(Request $request)
    {
        $prod_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        if(Cookie::get('shopping_cart'))
        {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);

                $machin_ip = getHostByName(getHostName()); //////Get machin Ip Address////////////////
                $shipping_charge = 0;
                $totalPrice = 0;
                foreach($cart_data as $keys => $values)
                {
                    foreach($cart_data as $keys2 => $values)
                    {
                        $totalPrice  =  $totalPrice + $cart_data[$keys2]['price'] * $quantity;
                    }

                    if($totalPrice >= 1000){
                        $shipping_charge = 0;
                    }

                    if($totalPrice < 1000){
                        $shipping_charge = ShippingCharges::where('machin_ip',$machin_ip)->where('vendor_id',$cart_data[$keys]['vendor_id'])->where('product_id',$cart_data[$keys]['product_id'])->where('category_id',$cart_data[$keys]['category_id'])->where('attribute_id',$cart_data[$keys]['attribute_id'])->where('attribute_value_id',$cart_data[$keys]['attribute_value_id'])->value('shipping_charge');
                    }
                    $cart_data[$keys]["shipping_charge"] = $shipping_charge;
                    if($keys == $prod_id)
                    {
                        //return response()->json($request->cart_id);
                        $cart_data[$keys]["qty"] =  $quantity;
                        $cart_data[$keys]["total_price"] = $cart_data[$keys]['price'] * $quantity;
                        
                        Cart::where('id',$request->cart_id)->update(['qty' => $quantity , 'total_price' => $cart_data[$keys]['price'] * $quantity]);
                        $item_data = json_encode($cart_data);
                        //$minutes = 3000;
                        $minutes = time() + (10 * 365 * 24 * 60 * 60);
                        Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));
                        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                        $cart_data = json_decode($cookie_data, true);
                        return response()->json(['status'=>'Quantity Updated' ,'data' => $cart_data]);
                    }
                }
        }
    }

    ///////////checkout section ////////////////////

    public function checkout(Request $request)
    {
     

        try {
            $machin_ip = getHostByName(getHostName());
            Cart::where('machin_ip',$machin_ip)->update(['user_id' => Auth::id()]);
            $cartDetails = Cart::where('user_id',Auth::id())->get();            
            $subtotal = 0;
            $cart_token = 0;
            $totalPrict = 0;
            $gst_price = 0;
            $coupon_value = 0;
            $shipping_charge = Cart::where('user_id',Auth::id())->sum('shipping_charge');
            $checkoutData=[];   
            $orderDrtailsId = [];
            $user = [];
            $user = User::where('id',Auth::id())->with('address')->first();
            $orders = Order::where('user_id',Auth::id())->where('status',1)->get();
            $isAvalableCOD = 0;
            foreach($cartDetails as $cart){
                $vendorDetails = User::where('id',$cart->vendor_id)->with('vaddress')->first();
                $userDetails = User::where('id',$cart->user_id)->with('address')->first();
                $subtotal += $cart->price * $cart->qty;
                $gst_price = $request->gst_price;
                $coupon_value = $request->coupon_value;
                $totalPrict = ceil($request->totalPrict);   
                /////////// Check COD avalable or NOT ////////////////////////////////////////
               // print_r($userDetails->address->postal_code);die();
                $isAvalableCOD = 0;
                $res = $this->checkCOD($vendorDetails->vaddress->HSN_codes,$userDetails->address->postal_code);
                if ($res['has_cod'] == true) {
                    $isAvalableCOD = 1;
                }else {
                    $isAvalableCOD = 0;
                }
            }

            try {
                $api_key = env('RAZOR_KEY');
                $api_secret = env('RAZOR_SECRET');
                $api = new Api($api_key, $api_secret);
        
                $order  = $api->order->create(array('receipt' => '123', 'amount' => $totalPrict * 100, 'currency' => 'INR')); // Creates order
                $orderId = $order['id']; // Get the created Order ID
                Session::put('order_id',$orderId);
                Session::put('amount',$totalPrict);

                if (count($orders) > 0) {
                    foreach ($orders as $order) {
                        $cartDetails = Cart::where('user_id',Auth::id())->get();
                            foreach ($cartDetails as  $cart) {
                            $orderDrtailsId = Order_details::where('order_id',$order->id)->where('product_id',$cart->product_id)->where('category_id',$cart->category_id)->where('attribute_id',$cart->attribute_id)->where('attribute_value_id',$cart->attribute_value_id)->where('price',$cart->price)->value('id');
                                if (!$orderDrtailsId) {
                                    $cartData[] = array('order_id'=> $order->id , 'vendor_id' => $cart->vendor_id,'product_id' => $cart->product_id,'category_id' => $cart->category_id,'attribute_id' => $cart->attribute_id,
                                    'attribute_value_id' => $cart->attribute_value_id ,'shepping_charge' => $cart->shepping_charge,'price' => $cart->price,'subtotal' => $cart->subtotal,
                                    'gst_price' => $cart->gst_price,'qty' => $cart->qty,'total_price' => $cart->total_price,'image' => $cart->image,'product_name' => $cart->product_name);
                                }
                                if ($orderDrtailsId) {
                                    Order_details::where('order_id',$order->id)->where('id','!=',$orderDrtailsId)->delete();
                                    Order::where('id',$order->id)->update(['order_number' => $orderId]);

                                }
                            }
                            if (!empty($cartData)) {
                                Order_details::insert($cartData);
                            }
                    
                        }
                }
                if (count($orders) == 0 ) {
                    $orderData = array('user_id' => Auth::id() ,'order_number' =>$orderId , 'order_date' => date("Y-m-d H:i:sa") , 'total_amount' => $totalPrict,'transact_status' => true);
                    $order_id = Order::create($orderData)->id;
                    $cartDetails = Cart::where('user_id',Auth::id())->get();
                    $cartData = [];
                    foreach ($cartDetails as  $cart) {
                        $cartData[] = array('order_id'=> $order_id , 'vendor_id' => $cart->vendor_id,'product_id' => $cart->product_id,'category_id' => $cart->category_id,'attribute_id' => $cart->attribute_id,
                        'attribute_value_id' => $cart->attribute_value_id ,'shepping_charge' => $cart->shepping_charge,'price' => $cart->price,'subtotal' => $cart->subtotal,
                        'gst_price' => $cart->gst_price,'qty' => $cart->qty,'total_price' => $cart->total_price,'image' => $cart->image,'product_name' => $cart->product_name);
                    }
                    Order_details::insert($cartData);
                }

                return view('cart.cart_ckeckout')->with('subtotal',$subtotal)->with('cart_token',$cart_token)->with('totalPrict',$totalPrict)->with('gst_price',$gst_price)->with('coupon_value',$coupon_value)->with('shipping_charge',$shipping_charge)->with('user',$user)->with('isAvalableCOD',$isAvalableCOD);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error',$th->getMessage());
            }
        } catch (\Exception $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function checkPayments(Request $request)
    {
        try {
            $payment = $request->all();
            if ($payment) {
                $order_id = Order::where('order_number',$request->razorpay_order_id)->value('id');
               $paymentInfo = array('order_id' => $order_id,'user_id' => Auth::id(),'payment_order_id' => $request->razorpay_order_id,'razorpay_payment_id' => $request->razorpay_payment_id,'razorpay_signature' => $request->razorpay_signature ,'total_amount' => Session::get('amount'), 'payment_status' => 1);
                $paymentId = Payment::create($paymentInfo)->id;
                Order::where('id',$order_id)->update(['payment_id' => $paymentId , 'payment_date' => date("Y/m/d")]);
            }
            return response()->json(['success' => 'Payment Success' , 'payment_id' => $paymentId]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function changeAddress(Request $request)
    {
       
        $address = $request->all();
        unset($address['address_id']);
        try {
            $result = UserAddress::where('id',$request->address_id)->update($address);
            return response()->json($address);
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
    }

    public function getAddress(Request $request)
    {
       // return response()->json('llllllllllllll');
       $orderId = Order::where('user_id',Auth::id())->where('status',1)->pluck('id');
       $data  = UserAddress::where('id',$request->address_id)->first();
       $newData=['userAddress' => $data,'order_id'=>$orderId];
       return response()->json($newData);
    }

    public function checkoutDetails(Request $request)
    {

        $orderDetail = Order::whereIn('id',$request->order_ids)->with('orderDetails')->first();
        Order::whereIn('id',$request->order_ids)->update(['status' => 2]);
        
            $users = User::where('id',$orderDetail->user_id)->with('address')->first();
            $orderParams = [];
            $Order_details = Order_details::where('order_id',$orderDetail->id)->groupBy('vendor_id')->pluck('vendor_id');
            foreach ($Order_details as $key => $vendorId) {
                $vendors = User::where('id',$vendorId)->with('address')->first();

                $orderParams = Order_details::whereIn('order_id',$request->order_ids)->where('vendor_id',$vendorId)->get()->toArray();
                $itemName = '';
                $productDetails = [];
                $totalQuantity =0;
                for ($i=0; $i <count($orderParams); $i++) { 
                    $AttributeValue = AttributeValue::where('id',$orderParams[$i]['attribute_value_id'])->value('value');
                    $itemName .= $orderParams[$i]['product_name'].'  '.$AttributeValue.'  '.$orderParams[$i]['qty']. ',';
                    $totalQuantity += $orderParams[$i]['qty'];
                }

                $subtotal = $request->subtotal;
                $codValue = 0;
                $gst_price = $request->gst_price;
                if ($request->paymentmathod != 'cod') {
                    $totalAmount = $request->totalPrict;
                }
                if ($request->paymentmathod == 'cod') {
                    $totalAmount = $request->totalPrict;
                     $codValue =  $subtotal * 2/100;
                     if ($codValue >= 38) {
                         $totalAmount = $totalAmount + $codValue;
                         $codValue = $codValue;
                     }else{
                        $totalAmount = $totalAmount + 38;
                        $codValue = 38;
                     }
                }
                $shippingCharges = $request->shipping_charge;
                // Do not Remove  this code ..............

                        // $params= [
                        //     'auth_token' => env('pickrr_auth_token'),
                        // //     'item_name' => "Polo Shirts x 1, pepe shirts x 1, t-shirt x 2 ", 
                        //     'item_name' => $itemName, 
                        //     "item_list" => $this->itemList($orderParams),
                        //     'from_name' => $vendors->name,
                        //     'from_phone_number' => $vendors->mobile,
                        //     'from_address' => $vendors->address->building.' '.$vendors->address->address1.' '.$vendors->address->address2.' '.$vendors->address->city.' '.$vendors->address->state,
                        //     'from_pincode' => $vendors->address->postal_code,
                        //     'pickup_gstin' => 'XXXXXXXXXX',
                        //     'to_name' => $users->name,
                        //     "to_email"=> "clark@gmail.com",
                        //     'to_phone_number' => $users->mobile,
                        //     'to_pincode' => $users->address->postal_code,
                        //     'to_address' => $users->address->building.' '.$users->address->address1.' '.$users->address->address2.' '.$users->address->city.' '.$users->address->state,  
                        //     "quantity" => $totalQuantity,
                        //     'invoice_value' =>  $totalAmount,
                        //     'cod_amount' => $totalAmount,
                        //     'client_order_id' => $orderDetail->order_number,
                        //     'item_tax_percentage' => 0,
                        //     'shipping_charge' => $shippingCharges,
                        //     'item_breadth' =>  1,
                        //     'item_length' =>  1,
                        //     'item_height' => 1,
                        //     'item_weight' =>  0.5,
                        //    // 'invoice_number' => 'null',
                        //    // 'total_discount' =>  10,
                        //    // 'transaction_charge' => 0,
                        //    // 'giftwrap_charge' =>  50,
                        //     'is_reverse' => False
                        // ];
                        // $result = $this->placeOrder($params);
                        // if (!empty($result)) {
                        //     $result['db_order_id'] = $orderDetail->id;
                        //     $result['user_id'] = $orderDetail->user_id;
                        //     $result['payment_id'] = $orderDetail->payment_id;
                        //     $value = PickeerOrderDetails::insert($result);
                        // }
            }

            $user = User::where('id',Auth::id())->with('address')->first();

        return view('cart.cart_payment_details',compact('orderDetail','gst_price','subtotal','totalAmount','shippingCharges','user'));
    }

    public function itemList($orderDetails)
    {
        $orderList = [];
        foreach ($orderDetails as  $details) {
            $orderList[]=[
                "price" => $details['price'], 
                "item_name" => $details['product_name'],
                "quantity" => $details['qty'],
                'sku' => Product::where('id',$details['product_id'])->value('sku'),
                "item_tax_percentage" =>  0, 
            ];
        }
        return $orderList;
    }

    public function cancelOrder(Request $request)
    {
        return response()->json('dddddd');
    }

}




